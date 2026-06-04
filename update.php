<?php
session_start();
include "database.php";

/* Check if logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch current user data */
$query = "SELECT email, phone FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

/* Handle form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $updateQuery = "
        UPDATE users 
        SET email = '$email', phone = '$phone' 
        WHERE user_id = $user_id
    ";

    mysqli_query($conn, $updateQuery);

    /*Show success message (NO redirect) */
    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        /* HEADER */
        .header {
            background-color: #ffffff;
            padding: 1px 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            gap: 4px;
        }

        .logo img {
            width: 40px;
            height: 60px;
            object-fit: cover;
        }

        .header-right {
            margin-right: 15px;
        }

        .logout {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            color: black;
        }

        .logout:hover {
            background-color: #ffe69c;
        }

        /* MAIN */
        .container {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .card {
            width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .card h2 {
            margin-top: 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #fff3cd;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ffe69c;
        }

        .back-link {
            display: block;           
            text-align: center;     
            margin-top: 10px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        /* SUCCESS MESSAGE */
        .success-message {
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">

    <div class="logo">
        <img src="images/logo.jpeg" alt="Logo">
        <span>LocalLink</span>
    </div>

    <div class="header-right">
        <a href="logout.php" class="logout">Logout</a>
    </div>

</div>

<!-- FORM -->
<div class="container">

    <div class="card">

        <h2>Update Profile</h2>

        <!--SHOW SUCCESS MESSAGE -->
        <?php if (isset($success)) { ?>
            <div class="success-message">
                <?php echo $success; ?>
            </div>

            
        <?php } ?>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

            <button type="submit" class="btn">Update</button>

        </form>

        <a href="user_dashboard.php" class="back-link">Back to Dashboard</a>

    </div>

</div>

</body>
</html>