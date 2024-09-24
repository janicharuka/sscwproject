<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Body background with gradient and animation */
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-size: 200% 200%;
            animation: gradientShift 10s ease infinite;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism card with soft shadows */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-effect:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
        }

        /* Neon glow effect for headings */
        h1 {
            color: #ffdd57;
            text-shadow: 0 0 8px rgba(255, 221, 87, 0.8), 0 0 15px rgba(255, 221, 87, 0.8);
        }

        /* Input field styling with focus effects */
        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 15px;
            border-radius: 12px;
            width: 100%;
            margin-top: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.2);
            outline: none;
            border-color: #ffdd57;
            box-shadow: 0 0 10px rgba(255, 221, 87, 0.7), 0 0 20px rgba(255, 221, 87, 0.7);
        }

        /* Button style with glowing hover effect */
        .button {
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            font-weight: 700;
            color: white;
            position: relative;
            background-color: #3b82f6;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .button:hover {
            background-color: #2563eb;
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.6);
        }

        .button-delete {
            background-color: #ef4444;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
        }

        .button-delete:hover {
            background-color: #dc2626;
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.6);
        }

        /* Link style */
        .link-style {
            color: #ffdd57;
            transition: color 0.3s ease, text-shadow 0.3s ease;
            text-shadow: 0 0 5px rgba(255, 221, 87, 0.8);
        }

        .link-style:hover {
            color: #facc15;
            text-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="glass-effect max-w-lg w-full">
        <h1 class="text-4xl font-bold text-center mb-8">User Profile</h1>

        <?php
        // Check if there's an error
        if (!empty($error)) {
            echo "<div class='bg-red-500 text-white p-3 rounded-lg mb-6'>{$error}</div>";
        } elseif (!empty($message)) {
            echo "<div class='bg-green-500 text-white p-3 rounded-lg mb-6'>{$message}</div>";
        }
        ?>

        <!-- Profile Update Form -->
        <form action="./profile.php" method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                <input type="text" id="username" name="username" required
                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>"
                       class="input-field">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                       class="input-field">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="button">
                    Update Profile
                </button>
            </div>
        </form>

        <!-- Account Deletion Form -->
        <form action="./profile.php" method="POST" class="mt-6">
            <input type="hidden" name="deleteAccount" value="1">
            <button type="submit" class="button button-delete">
                Delete Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="./my_dashboard.php" class="link-style">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
