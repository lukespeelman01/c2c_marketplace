


<?php
session_start();

//Not logged in → go login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//If Seller → allow access to add product page
if (isset($_SESSION['role']) && $_SESSION['role'] === "Seller") {
    header("Location: add_product.php");
    exit();
}

//Everyone else (Buyer) will see the message page below
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Listing</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
		
		

        .topbar {
            background-color: #ffffff;
            padding: 12px 20px;
            border-bottom: 1px solid #ddd;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        .message-box {
            background-color: #ffffff;
            display: inline-block;
            padding: 30px 40px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .message-box p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFF8E1;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="topbar">LocalLink</div>

<div class="container">
    <div class="message-box">
        <p>Only sellers can create listings.</p>
        <a class="back-link" href="C2C Marketplace.php">Back to Marketplace</a>
    </div>
</div>

</body>
</html>