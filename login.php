<?php
session_start();
$error = "";
include "database.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['user_password'])) {

            //  VERY IMPORTANT: reset session to avoid conflicts
            session_regenerate_id(true);

            //  Store fresh session data
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

           
			// Redirect after login
			if ($user['role'] == "Admin") {
			header("Location: admin/dashboard.php");
			} else {
			header("Location: user_dashboard.php");
			}


            exit();

        } else {
            $error = "Incorrect password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            width: 360px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #FFF8E1;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #FFF3CD;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
		
		
	
	.forgot-box {
    background-color: rgba(173, 216, 230, 0.3); /* light blue transparent */
    padding: 8px;
    margin-top: 10px;
    border-radius: 6px;
    width: 200px;           
    margin-left: auto;      
    margin-right: auto;     
    text-align: center;
	}


	.forgot-box a {
    text-decoration: none;
    font-weight: bold;
    color: black;
	}

	
	.forgot-box:hover {
    background-color: rgba(173, 216, 230, 0.5); /* stronger blue on hover */
	}

		
		
		
    </style>
</head>

<body>

<div class="login-container">
    <h2>Login</h2>
	

<?php if (!empty($error)) { ?>
    <p style="color: red; margin-bottom: 15px; text-align: center;">
        <?php echo $error; ?>
    </p>
<?php } ?>

    <form method="POST" action="" >
        <label>Email</label>
        <input type="email" name="email" required autocomplete="off">

        <label>Password</label>
        <input type="password" name="password" required autocomplete="off">

        <button type="submit" name="login">Login</button>
    </form>

    <a class="back-link" href="C2C Marketplace.php">Back to Marketplace</a><br>
	<div class="forgot-box">
    <a href="forgot_password.php">Forgot Password?</a>
</div>
	
</div>

</body>
</html>