<?php
require './src/db/connection.php';
session_start();

// Check if the user is logged in and has the correct role (admin)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header('Location: ./error.html');
    exit();
}

$pdo = getDBConnection();

// Fetch all users with their roles
$stmt = $pdo->query('SELECT users.id, username, email, role_name
                     FROM users
                     JOIN roles ON users.role_id = roles.id');
$users = $stmt->fetchAll();

// Fetch roles for adding/editing users
$stmt_roles = $pdo->query('SELECT id, role_name FROM roles');
$roles = $stmt_roles->fetchAll();

// Handle Add User form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    // Insert the new user
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $password, $role_id]);

    header('Location: manage_users.php');
    exit();
}

// Handle Edit User form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];

    // Update the user
    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?');
    $stmt->execute([$username, $email, $role_id, $user_id]);

    header('Location: manage_users.php');
    exit();
}

// Handle delete user request
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

    // First, delete user-related logs from user_logs and failed_logins
    $stmt = $pdo->prepare('DELETE FROM user_logs WHERE user_id = ?');
    $stmt->execute([$user_id]);

    $stmt = $pdo->prepare('DELETE FROM failed_logins WHERE user_id = ?');
    $stmt->execute([$user_id]);

    // Finally, delete the user
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$user_id]);

    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #141E30, #243B55);
            font-family: 'Poppins', sans-serif;
        }
        .glass-bg {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(6px);
        }
        table {
            backdrop-filter: blur(10px);
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        table thead {
            background: rgba(59, 130, 246, 0.9);
        }
        table tbody tr {
            background: rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }
        table tbody tr:hover {
            transform: scale(1.02);
            background: rgba(255, 255, 255, 0.15);
        }
        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-black to-gray-800 text-white">
    <div class="container mx-auto p-8 glass-bg rounded-xl shadow-lg">
        <h2 class="text-4xl text-center font-semibold mb-8 text-white">Manage Users</h2>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm uppercase font-medium">
                        <th class="py-3 px-6">Username</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-700 hover:shadow-lg">
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($user['role_name']); ?></td>
                            <td class="py-4 px-6">
                                <a href="manage_users.php?edit_id=<?php echo $user['id']; ?>" class="text-blue-400 hover:text-blue-300">Edit</a> |
                                <a href="manage_users.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-400 hover:text-red-300">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add User Form -->
        <h3 class="text-2xl text-center font-semibold mt-8 text-white">Add User</h3>
        <form action="manage_users.php" method="POST" class="flex flex-col gap-4 mt-4">
            <input type="text" name="username" placeholder="Username" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="email" name="email" placeholder="Email" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="password" name="password" placeholder="Password" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <select name="role_id" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php foreach ($roles as $role): ?>
                    <option value="<?php echo $role['id']; ?>"><?php echo $role['role_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add_user" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold p-3 rounded-md btn mt-2">Add User</button>
        </form>

        <!-- Edit User Form (Only shown when edit_id is set in the URL) -->
        <?php if (isset($_GET['edit_id'])): ?>
        <?php
            $edit_id = $_GET['edit_id'];
            $stmt_edit = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt_edit->execute([$edit_id]);
            $edit_user = $stmt_edit->fetch();
        ?>
        <h3 class="text-2xl text-center font-semibold mt-8 text-white">Edit User</h3>
        <form action="manage_users.php" method="POST" class="flex flex-col gap-4 mt-4">
            <input type="hidden" name="user_id" value="<?php echo $edit_user['id']; ?>">
            <input type="text" name="username" value="<?php echo htmlspecialchars($edit_user['username']); ?>" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="email" name="email" value="<?php echo htmlspecialchars($edit_user['email']); ?>" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <select name="role_id" required class="p-3 rounded-md bg-gray-700 text-white glass-input focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php foreach ($roles as $role): ?>
                    <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $edit_user['role_id']) echo 'selected'; ?>>
                        <?php echo $role['role_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="edit_user" class="bg-green-500 hover:bg-green-600 text-white font-semibold p-3 rounded-md btn mt-2">Update User</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
