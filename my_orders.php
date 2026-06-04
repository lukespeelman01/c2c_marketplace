<?php
session_start();
include "database.php";

//user id
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
	


$buyer_id = $_SESSION['user_id'];

/* Fetch buyer orders */
$query = "
    SELECT 
        orders.order_id,
        orders.order_date,
        orders.order_status,
        products.title,
        orderdetails.quantity
    FROM orders
    JOIN orderdetails ON orders.order_id = orderdetails.order_id
    JOIN products ON orderdetails.product_id = products.product_id
    WHERE orders.buyer_id = '$buyer_id'
    ORDER BY orders.order_date DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders Placed</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        .header {
            background-color: #ffffff;
            padding: 1px 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }
		
		
		.header h1 {
		margin: 0;
		font-size: 22px;
		}


        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff3cd;
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #ffe69c;
        }

        .main {
            flex: 1;
            padding: 25px;
        }

        .order-card {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .logout {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
		
		
		.logo {
    display: flex;
    align-items: center;
    font-size: 22px;
    font-weight: bold;
	}

	.logo img {
    width: 40px;
    height: 60px;
    object-fit: cover; /* keeps it looking clean */
	}
		
		
		
    </style>
</head>

<body>

<div class="header">
    
	<div class="logo">
   <img src="images/logo.jpeg" alt="Logo">
    <span>LocalLink</span>
	</div>
	
	
    <a href="logout.php" class="logout" style = "margin-right: 15px">Logout</a>
</div>

<div class="container">

    <div class="sidebar">
        <h3>Buyer Menu</h3>
        <a href="user_dashboard.php">Back to Dashboard</a>
		<hr>
       
       
    </div>

    <div class="main">
        <h2>Your Orders</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="order-card">
                    <p><strong>Order ID:</strong> <?php echo $row['order_id']; ?></p>
                    <p><strong>Product:</strong> <?php echo $row['title']; ?></p>
                    <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo $row['order_date']; ?></p>
                    <p><strong>Status:</strong> <?php echo $row['order_status']; ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>You have not placed any orders yet.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>