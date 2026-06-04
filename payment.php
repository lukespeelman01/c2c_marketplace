<?php
session_start();
include "database.php";

if (!isset($_GET['product_id'])) {
    echo "Invalid product";
    exit();
}

$product_id = intval($_GET['product_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        /* Top bar */
        .topbar {
            background-color: #ffffff;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            font-size: 22px;
            font-weight: bold;
        }

        /* Center container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
        }

        /* Payment card */
        .payment-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 350px;
        }

        .payment-box h2 {
            margin-top: 0;
            text-align: center;
        }

        /* Inputs */
        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Button */
        .pay-btn {
            width: 100%;
            padding: 10px;
            background-color: #fff3cd;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .pay-btn:hover {
            background-color: #ffe69c;
        }

        .back {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="topbar">LocalLink</div>

<div class="container">

    <div class="payment-box">
        <h2>Secure Payment</h2>

        <form method="POST" action="processing_payment.php">

            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <div class="input-group">
                <label>Card Number</label>
                <input type="text" name="card" placeholder="1234 5678 9012 3456" required>
            </div>

            <div class="input-group">
                <label>Expiry Date</label>
                <input type="text" name="expiry" placeholder="MM/YY" required>
            </div>

            <div class="input-group">
                <label>CVV</label>
                <input type="text" name="cvv" placeholder="123" required>
            </div>

            <button type="submit" class="pay-btn">Pay Now</button>

        </form>

        <a href="C2C Marketplace.php" class="back">Cancel Payment</a>

    </div>

</div>

</body>
</html>