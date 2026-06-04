<?php
session_start();

if (!isset($_POST['product_id'])) {
    echo "Invalid request";
    exit();
}

$product_id = $_POST['product_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>

    <!--Auto redirect after 3 seconds -->
    <meta http-equiv="refresh" content="3;url=place_order.php">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 5px solid #ccc;
            border-top: 5px solid #000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="box">
        <h2>Processing Payment...</h2>
        <div class="spinner"></div>
        <p>Please wait while we confirm your payment.</p>

        <!-- Hidden form auto-submits -->
        <form id="orderForm" method="POST" action="place_order.php">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        </form>
    </div>
</div>

<script>
    // Auto submit after delay
    setTimeout(function() {
        document.getElementById("orderForm").submit();
    }, 3000);
</script>

</body>
</html>