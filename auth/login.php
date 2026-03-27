<?php
// securely remember user session 
session_start();

// connect to db
require_once ("../config/connectdb.php");

$error = '';

	//checking if form has been submitted
	if (isset($_POST['submitted'])){
		if ( !isset($_POST['email'] , $_POST['password']) ) {
		// ensure that user have filled in all fields
		 exit('Please fill in all fields!');
	    } try {
		// query to check if exists
		//using prepare/bindparameter to prevent SQL injection.
			$stat = $db->prepare('SELECT password FROM user WHERE email = ?');
			$stat->execute(array($_POST['email']));
		    
			// fetch the result row and check 
			if ($stat->rowCount()>0){  // matching email
				$row=$stat->fetch();

                // check if matching password
				if (password_verify($_POST['password'], $row['password'])){ 				
					$_SESSION["email"]=$_POST['email'];
					header("Location:login.php");
					exit();
				
				} else {
				 $error = "<p style='color:red'>Password does not match </p>";
 			    }
		    } else {
			 //else display an error
			  $error = "<p style='color:red'>Email not found </p>";
		    }
		}
		catch(PDOException $ex) {
			echo("Failed to connect to the database.<br>");
			echo($ex->getMessage());
			exit;
		}

  }
?>
<!-- a HTML part -->
<html>
<head>
	<title>Aston CV - Log In</title>
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