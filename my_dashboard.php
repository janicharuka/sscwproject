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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])  || $_SESSION['role_id'] !== 2) {
    header('Location: ../../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Dark mode background animation with subtle gradient shift */
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            background-size: 200% 200%;
            animation: gradientBG 10s ease infinite;
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism container for dark mode */
        .glass-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            padding: 2.5rem;
            max-width: 600px;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .glass-container:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-10px);
        }

        /* Neon effect for text headers */
        h1 {
            color: #fff;
            text-shadow: 0 4px 30px rgba(255, 255, 255, 0.7);
        }

        /* Glowing button styles for dark mode */
        .btn-glow {
            display: block;
            width: 100%;
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.08);
            border: none;
            border-radius: 50px;
            color: white;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-glow:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4), 0 0 15px rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        /* Red glow effect for logout button */
        .bg-red-600 {
            background-color: #dc2626;
        }

        .hover\:bg-red-700:hover {
            background-color: #b91c1c;
        }

        .focus\:ring-red-500:focus {
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.7);
        }

        /* Button active effect */
        .btn-glow:active {
            transform: scale(0.98);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
        }

        /* Glow effect for text */
        .text-glow {
            color: #fff;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.7);
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .glass-container {
                padding: 3.5rem;
            }

            h1 {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="glass-container text-center">
        <h1 class="text-5xl font-bold mb-8 text-glow">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="text-lg mb-10 text-gray-300">This is your personalized dashboard. Here you can manage your account and settings with ease.</p>

        <div class="space-y-6">
            <a href="./profile.php" class="btn-glow">View Profile</a>
            <a href="./settings.php" class="btn-glow">Account Settings</a>
            <a href="./src/auth/logout.php" class="btn-glow bg-red-600 hover:bg-red-700 focus:ring-red-500">Logout</a>
        </div>
    </div>

</body>
</html>
