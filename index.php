<?php
session_start(); // Start the session to track user login status

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Tours</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-image {
            background-size: cover;
            background-position: center;
            height: 100vh;
            transition: background-image 1s ease-in-out;
        }

        .mynav {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 15px;
            width: 100%;
            text-align: center;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }

        h1, p {
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: white;
            margin-top: 100px;
        }

        .container h1 {
            font-size: 2.5rem;
        }

        .container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff4b4b;
            transform: translateY(-3px);
        }

        a {
            color: #ffeb3b;
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #ffcd38;
        }
    </style>
</head>
<body>
    <div class="bg-image" id="bgImage">
        <div class="mynav">
            <h1>Lucky Tours</h1>
        </div>

        <div class="container">
            <?php if ($isLoggedIn): ?>
                <!-- Content for logged-in users -->
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>You are now logged in.</p>
                <div class="mt-4">
                    <a href="./src/auth/logout.php" class="btn btn-primary">Logout</a>
                    
                    <?php if ($_SESSION['role_id'] == 1): ?>
                        <a href="./dashboard.php" class="btn btn-primary">Go to Admin Dashboard</a>
                    <?php else: ?>
                        <a href="./my_dashboard.php" class="btn btn-primary">Go to User Dashboard</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Content for guests -->
                <h1>Welcome to Lucky Tours </h1>
                <p>We are a leading brand in the People Transportation Industry, providing quick and safe journeys to your destinations.</p>
                <p>"Join us for Unforgettable & Joyful Journeys!"</p>
                <br>
                <div>
                    <a href="register.php" class="btn btn-primary">Sign Up</a>
                    <p>If you already have an account, please <a href="login.php">Sign In</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const images = ["images/image1.jpg", "images/image2.jpg", "images/image3.jpg"]; // Image paths
        let currentIndex = 0;

        function changeBackground() {
            document.getElementById('bgImage').style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length;
            setTimeout(changeBackground, 4000); // Change every 4 seconds
        }

        changeBackground();
    </script>
</body>
</html>
