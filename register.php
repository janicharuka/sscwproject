<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure PHP Authentication | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Body Gradient Background with Neon Color Scheme */
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

        /* Glassmorphism Container with Neon Glow Effect */
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
            transform: translateY(-12px);
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.7);
        }

        /* Neon glow for headings */
        h1 {
            color: #39FF14;
            text-shadow: 0 0 8px rgba(57, 255, 20, 0.8), 0 0 15px rgba(57, 255, 20, 0.8);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 15px;
            border-radius: 12px;
            width: 100%;
            margin-top: 8px;
            color: white;
            transition: 0.3s ease-in-out;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.15);
            outline: none;
            box-shadow: 0 0 10px rgba(57, 255, 20, 0.8), 0 0 20px rgba(57, 255, 20, 0.8);
            border-color: #39FF14;
        }

        /* 3D effect for submit button with vibrant glow */
        .submit-button {
            background-color: #1e40af;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            text-align: center;
            font-weight: 700;
            color: white;
            position: relative;
            box-shadow: 0 4px 10px rgba(30, 64, 175, 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .submit-button:before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 12px;
            background: linear-gradient(45deg, #39FF14, #3b82f6, #9333ea);
            z-index: -1;
            filter: blur(10px);
            opacity: 0.7;
            transition: filter 0.5s ease;
        }

        .submit-button:hover {
            background-color: #1d4ed8;
            box-shadow: 0 6px 18px rgba(30, 64, 175, 0.8);
        }

        .submit-button:hover:before {
            filter: blur(15px);
        }

        /* Floating animation for entire card */
        .floating {
            animation: floatingCard 7s ease-in-out infinite;
        }

        @keyframes floatingCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Floating text link with neon glow */
        .link-style {
            color: #60a5fa;
            transition: color 0.3s ease;
            text-shadow: 0 0 5px rgba(96, 165, 250, 0.8);
        }

        .link-style:hover {
            color: #93c5fd;
            text-shadow: 0 0 10px rgba(147, 197, 253, 0.8);
        }

        /* Error message styling */
        .error-message {
            background-color: rgba(220, 38, 38, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.5);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="glass-effect max-w-lg w-full floating">
        <h1 class="text-4xl font-bold text-center mb-8">Register</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="./src/auth/register.php" method="POST" class="space-y-8">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                <input type="text" id="username" name="username" required class="input-field" placeholder="Enter your username">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" id="email" name="email" required class="input-field" placeholder="Enter your email">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input type="password" id="password" name="password" required class="input-field" placeholder="Enter your password">
            </div>

            <div>
                <input type="submit" value="Register" class="submit-button cursor-pointer">
            </div>
        </form>
        <p class="text-sm text-center text-gray-400 mt-6">Already have an account? 
            <a href="./login.php" class="link-style">Login here</a>
        </p>
    </div>
</body>
</html>
