<?php
require './src/db/connection.php';
session_start();

// Check if the user is logged in and has the correct role (admin)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    // If the user is not an admin, redirect to an error page or homepage
    header('Location: ./error.php');
    exit();
}

$pdo = getDBConnection();

// Fetch all logs
$stmt = $pdo->query('SELECT user_logs.id, users.username, user_logs.action, user_logs.timestamp 
                     FROM user_logs
                     JOIN users ON user_logs.user_id = users.id
                     ORDER BY user_logs.timestamp DESC');
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #2f3e46, #4d5b61, #69797f); /* Dark gradient with a cooler tone */
            background-size: 200% 200%;
            animation: gradientShift 10s ease infinite;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism effect for container */
        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .glass-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
        }

        /* Table styling with subtle hover effects */
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background-color: #111827;
            color: #ffdd57;
            text-transform: uppercase;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(255, 221, 87, 0.5);
        }

        tr {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
        }

        tbody td {
            color: #e5e7eb;
        }

        /* Button styling */
        .back-button {
            display: inline-block;
            padding: 14px 24px;
            background-color: #3b82f6;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .back-button:hover {
            background-color: #2563eb;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.5);
        }

        /* Link styling */
        .link-style {
            color: #ffdd57;
            text-shadow: 0 0 8px rgba(255, 221, 87, 0.8);
            transition: text-shadow 0.3s ease, color 0.3s ease;
        }

        .link-style:hover {
            color: #facc15;
            text-shadow: 0 0 12px rgba(255, 221, 87, 1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="glass-container max-w-5xl w-full">
        <h2 class="text-5xl text-center font-extrabold text-yellow-400 mb-8">System Logs</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-900 rounded-lg shadow-lg">
                <thead>
                    <tr>
                        <th class="py-4 px-6">Username</th>
                        <th class="py-4 px-6">Action</th>
                        <th class="py-4 px-6">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-gray-700 border-b border-gray-700 transition duration-200">
                            <td class="py-4 px-6"><?php echo htmlspecialchars($log['username']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($log['action']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($log['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="./dashboard.php" class="back-button">Back to Admin Dashboard</a>
        </div>
    </div>

</body>
</html>
