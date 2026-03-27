<?php
// start and immediately destroy the session to log out 
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logged Out - AstonCV</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            margin: 20px;
        }

        h2 {
            margin-top: 0;
            color: #2d3748;
            text-align: center;
            margin-bottom: 28px;
            font-size: 28px;
            font-weight: 600;
        }

        p {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 24px;
            text-align: center;
            line-height: 1.5;
        }

        .logoutBtn {
            width: 100%;
            padding: 14px;
            background-color: #3182ce;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .logoutBtn:hover {
            background-color: #2b6cb0;
        }

        .logoutBtn:active {
            transform: scale(0.98);
        }

        .logout {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
            font-size: 14px;
        }

        .logout a {
            color: #3182ce;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>You have been logged out</h2>
        <p>You have successfully logged out</p>
        <a href="../public/index.php"><button class="logoutBtn">Return to Home</button></a>
    </div>