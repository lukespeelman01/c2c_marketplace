<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "database.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get inputs
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $new_password_raw = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Check empty fields
    if (empty($email) || empty($new_password_raw) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
        $message_type = "error";

    } 
    // Check passwords match
    elseif ($new_password_raw != $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "error";

    } else {

        // Check if email exists
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);

        if ($result && mysqli_num_rows($result) == 1) {

            // Hash password
            $hashed_password = password_hash($new_password_raw, PASSWORD_DEFAULT);

            // Update password
            $update_query = "
                UPDATE users 
                SET user_password = '$hashed_password' 
                WHERE email = '$email'
            ";

            if (mysqli_query($conn, $update_query)) {
                $message = "Password updated successfully!";
                $message_type = "success";
            } else {
                $message = "Error updating password.";
                $message_type = "error";
            }

        } else {
            $message = "Email not found.";
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 300px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #fff3cd;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #ffe69c;
        }

        .message {
            margin-top: 10px;
            font-weight: bold;
        }

        .message.error {
            color: red;
        }

        .message.success {
            color: green;
        }

        a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Forgot Password</h2>

    <!-- FORM -->
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>

        <input type="password" name="new_password" placeholder="New Password" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit">Reset Password</button>
    </form>

    <!-- MESSAGE -->
    <div class="message <?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>

    <a href="login.php">Back to Login</a>

</div>

</body>
</html>