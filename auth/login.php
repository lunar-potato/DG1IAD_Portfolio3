<?php
// securely remember user session 
session_start();

// connect to db
require_once ("../config/connectdb.php");

$error = '';

//checking if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // ensure that user have filled in all fields
    if (empty($email) || empty($password)) {
         $error = 'Please fill in all fields!';
    } else {
        try {
            $stat = $db->prepare('SELECT id, email, password FROM cvs WHERE email = ?');
            $stat->execute(array($email));
            
            // fetch the result row and check 
            if ($row = $stat->fetch()){  
                
                // check if matching password
                if (password_verify($password, $row['password'])){                
                    // start the session with their ID and Email
                    $_SESSION["userid"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    
                    // redirect to the private dashboard
                    header("Location: ../user/updateCV.php");
                    exit();
                } else {
                    $error = "Password does not match.";
                }
            } else {
              $error = "Email not found.";
            }
        }
        catch(PDOException $ex) {
            $error = "Failed to connect to the database.<br>" . $ex->getMessage();
        }
    }
}
?>
<html>
<head>
    <title>Aston CV - Log In</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);
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
        <h2>AstonCV Log In</h2>
        <?php if ($error): ?>
            <div class="errorBanner"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="formGroup">
                <input type="text" name="email" placeholder="Email" required />
            </div>
            <div class="formGroupLast">
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <button type="submit" class="submitBtn">Log In</button>
        </form>
        <p class="login">Not registered yet? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>