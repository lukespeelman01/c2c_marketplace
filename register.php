<?php
// connect to the database
include "database.php";

$error = "";

// check if the form was submitted
if (isset($_POST['register'])) {

    // get form values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ✅ check if email already exists
    $check = mysqli_query($conn, "SELECT user_id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered.";
    } else {

        // insert user into database
        $query = "
            INSERT INTO users (name, email, user_password, role, phone)
            VALUES ('$name', '$email', '$hashedPassword', '$role', '$phone')
        ";

        if (mysqli_query($conn, $query)) {
            // ✅ redirect properly (no meta refresh)
            header("Location: C2C Marketplace.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-container {
            background-color: #ffffff;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .register-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #FFF8E1;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #FFF3CD;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: red;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="register-container">
    <h2>Register</h2>

    <?php if (!empty($error)) { ?>
        <div class="message"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST" action="">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="tel" name="phone" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role" required>
            <option value="Buyer">Buyer</option>
            <option value="Seller">Seller</option>
        </select>

        <button type="submit" name="register">Register</button>
    </form>

    <a class="back-link" href="C2C Marketplace.php">Back to Marketplace</a>
</div>

</body>
</html>