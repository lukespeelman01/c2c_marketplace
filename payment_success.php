<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>

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

        /* Center layout */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
        }

        /* Message box */
        .success-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-align: center;
            width: 350px;
        }

        .success-box h2 {
            margin-top: 0;
            color: green;
        }

        .success-box p {
            margin: 15px 0;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            background-color: #fff3cd;
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #ffe69c;
        }
    </style>
</head>

<body>

<div class="topbar">LocalLink</div>

<div class="container">

    <div class="success-box">

        <h2>✅ Payment Successful</h2>

        <p>Your order has been placed successfully.</p>

        <p><strong>Thank you for your purchase!</strong></p>

        <a href="user_dashboard.php" class="btn">
            Back to Dashboard
        </a>

    </div>

</div>

</body>
</html>