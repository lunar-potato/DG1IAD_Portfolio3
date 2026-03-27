<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstonCV</title>
    <style>
        body {
            margin:  0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f5f7fa;
            color: #2d3748;
            min-height: 100vh;

            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-image: linear-gradient(to top, #a3bded 0%, #6991c7 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }

        .navbar a:hover {
            background-color: #4a5568;
        }

        .navBrand {
            font-size: 24px;
            font-weight: bold;
        }

        .navBrand a {
            background: transparent;
            padding: 0;
        }

        .navBrand a:hover {
            background: transparent;
            color: #63b3ed;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            margin-bottom: 0;
        }

        .cvGrid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .cvCard {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease;
        }

        .cvCard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .btnPrimary {
            display: inline-block;
            background: #3182ce;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: backgroud 0.3s ease;
        }

        .btnPrinary:hover {
            background: #2b6cb0;
        }
    </style>
</head>    
<body>
    <nav class="navbar">
        <div class="navBrand">
            <a href="../public/index.php">AstonCV</a>
        </div>
        <div class="navLinks">
            <a href="../public/index.php">Home</a>
            <a href="../public/search.php">Search</a>

            <?php if (isset($_SESSION['userid'])): ?>
                <a href="../user/updateCV.php">My CV</a>
                <a href="../auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="../auth/login.php">Login</a>
                <a href="../auth/register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</html>