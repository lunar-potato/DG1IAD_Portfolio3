<?php
// start session for login handling 
session_start();

// connecting to database
require_once('../config/connectdb.php');

$error = '';
$success = '';

// checking if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false;

    // validating input
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        try {
           // register user by inserting the user info 
	        $stat=$db->prepare("INSERT INTO cvs (name, email, password) VALUES (?, ?, ?)");
	        $stat->execute(array($name, $email, $password));
	
	        $id=$db->lastInsertId();
	      $success = "Congratulations! You are now registered. Your ID is: $id  "; 
        } catch (PDOException $ex) {
            $error = "Sorry, a database error occurred! <br> Error details: <em>" . $ex->getMessage() . "</em>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AstonCV - Sign Up</title>
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

        .formGroup {
            margin-bottom: 20px;
        }

        .formGroupLast {
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
            color: #2d3748;
            outline: none;
            background-color: #f7fafc;
            transition: border-color 0.4s ease;
        }

        input:focus {
            border-color: #3182ce;
        }

        .submitBtn {
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

        .submitBtn:hover {
            background-color: #2b6cb0;
        }

        .submitBtn:active {
            transform: scale(0.98);
        }

        .login {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
            font-size: 14px;
        }

        .login a {
            color: #3182ce;
            text-decoration: none;
        }

        .successBanner {
            margin-top: 24px;
            margin-bottom: 10px;
            padding: 16px;
            background-color: #c6f6d5;
            border: 1px solid #9ae6b4;
            color: #2f855a;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            line-height: 1.5;
        }

        .errorBanner {
            margin-top: 24px;
            margin-bottom: 10px;
            padding: 16px;
            background-color: #fed7d7;
            border: 1px solid #feb2b2;
            color: #c53030;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            line-height: 1.5;
        }

        </style>
</head>
<body>
    <div class="container">
        <h2>AstonCV Sign Up</h2>
        <?php if ($error): ?>
            <div class="errorBanner"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="successBanner"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="register.php">
            <div class="formGroup">
                <input type="text" name="name" placeholder="Name" required />
            </div>
            <div class="formGroup">
                <input type="text" name="email" placeholder="Email" required />
            </div>
            <div class="formGroupLast">
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <button type="submit" class="submitBtn">Register</button>
        </form>
        <p class="login">Already a user? <a href="index.php">Log in</a></p>
    </div>
</body>
</html>