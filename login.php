<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure PHP Authentication | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
    <style>
        body {
            background: linear-gradient(to right, #6EE7B7, #3B82F6);
            font-family: 'Poppins', sans-serif;
        }
        .custom-bg {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(38, 38, 38, 0.9));
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
        .glow-border {
            border: 2px solid transparent;
            background-image: linear-gradient(to right, #3b82f6, #f97316);
            background-origin: border-box;
            background-clip: padding-box, border-box;
            border-radius: 12px;
            box-shadow: 0 4px 30px rgba(255, 255, 255, 0.1);
        }
        .glow-border:focus {
            box-shadow: 0 4px 30px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">
    <form action="./src/auth/login.php" method="POST" class="custom-bg p-8 rounded-3xl w-full max-w-md space-y-6 glow-border transition duration-300 ease-in-out transform hover:scale-105">
        <h1 class="text-4xl font-extrabold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">Welcome Back</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-500 text-white p-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-200 mb-2">Email:</label>
            <input type="email" id="email" name="email" required 
                   class="w-full px-4 py-3 bg-gray-800 text-white border border-gray-600 rounded-lg glow-border focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 placeholder-gray-400" placeholder="Enter your email">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-200 mb-2">Password:</label>
            <input type="password" id="password" name="password" required 
                   class="w-full px-4 py-3 bg-gray-800 text-white border border-gray-600 rounded-lg glow-border focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 placeholder-gray-400" placeholder="Enter your password">
        </div>

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
            </div>
            <a href="#" class="text-sm text-blue-400 hover:text-blue-500 transition duration-200">Forgot password?</a>
        </div>

        <div>
            <input type="submit" value="Login" 
                   class="w-full px-4 py-3 bg-gradient-to-r from-yellow-600 to-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 cursor-pointer transition duration-300 transform hover:scale-105">
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">Don't have an account? <a href="./register.php" class="text-blue-400 hover:text-blue-500 transition duration-200">Sign up</a></p>
        </div>
    </form>
</body>
</html>
