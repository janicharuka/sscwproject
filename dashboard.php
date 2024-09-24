<?php
session_start();

// Set the session timeout duration (10 minutes)
$session_timeout = 10 * 60; // 10 minutes in seconds

// Check if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    // Logging the logout action before destroying session
    require_once '../db/connection.php';
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('INSERT INTO user_logs (user_id, action) VALUES (?, ?)');
    $stmt->execute([$_SESSION['user_id'], 'Logout due to inactivity']);

    // Session expired, destroy it and redirect to login page
    session_unset();
    session_destroy();
    header('Location: ../../login.php?error=Session%20expired%20due%20to%20inactivity');
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header('Location: ../../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Body background with smooth animation and color gradient */
        body {
            background: linear-gradient(135deg, #243b55, #141e30, #1c3144); /* Deep blue and dark tones */
            background-size: 200% 200%;
            animation: gradientShift 12s ease infinite;
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism effect for dashboard container */
        .glass-effect {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            transition: all 0.4s ease;
        }

        .glass-effect:hover {
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
            transform: translateY(-8px);
        }

        /* Button gradient styling and hover effect */
        .btn-gradient {
            transition: all 0.3s ease;
            padding: 0.75rem 1.25rem;
            font-size: 1.15rem;
            font-weight: bold;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-gradient::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            transition: all 0.5s ease;
            transform: translate(-50%, -50%) scale(0);
        }

        .btn-gradient:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn-gradient:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        /* Typography for headers and text */
        .text-glow {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        /* Additional transitions for hover effects */
        .transition {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-white">
    <div class="glass-effect p-12 rounded-3xl max-w-lg w-full transition duration-300">
        <h1 class="text-5xl font-extrabold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400 text-glow">
            Admin Dashboard
        </h1>
        <p class="text-center text-gray-300 mb-10">
            Welcome, <span class="font-semibold text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!
            Manage the application settings and user accounts below.
        </p>

        <div class="space-y-8">
            <a href="./manage_users.php" class="block w-full py-4 bg-gradient-to-r from-teal-500 to-indigo-500 text-white font-semibold rounded-full text-center shadow-lg hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-teal-300 transition transform hover:scale-105 btn-gradient">
                Manage Users
            </a>
            <a href="./site_settings.php" class="block w-full py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-full text-center shadow-lg hover:bg-purple-600 focus:outline-none focus:ring-4 focus:ring-purple-300 transition transform hover:scale-105 btn-gradient">
                Site Settings
            </a>
            <a href="./view_logs.php" class="block w-full py-4 bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold rounded-full text-center shadow-lg hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 transition transform hover:scale-105 btn-gradient">
                View Logs
            </a>
            <a href="./src/auth/logout.php" class="block w-full py-4 bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold rounded-full text-center shadow-lg hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-300 transition transform hover:scale-105 btn-gradient">
                Logout
            </a>
        </div>
    </div>
</body>
</html>
