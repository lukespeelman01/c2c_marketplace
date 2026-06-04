

<?php
session_start();
include "database.php";

/* Only sellers allowed */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Seller') {
    echo "Access denied";
    exit();
}

$seller_id = $_SESSION['user_id'];

$query = "
    SELECT 
        products.product_id,
        products.user_id,
        products.title,
        products.description,
        products.price,
        products.location,
        products.image,
        category.name AS category_name
    FROM products
    JOIN category ON products.category_id = category.category_id
    WHERE products.user_id = '$seller_id'
    ORDER BY products.created_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>

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

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .logout {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        /* LAYOUT */
        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h3 {
            margin-top: 0;
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

        /* MAIN */
        .main {
            flex: 1;
            padding: 25px;
        }

        .product-card {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .product-card img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
            background-color: #eee;
        }

        .action-btn {
            display: inline-block;
            margin-top: 10px;
            margin-right: 5px;
            padding: 8px 12px;
            background-color: #fff3cd;
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .action-btn:hover {
            background-color: #ffe69c;
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

<!--HEADER -->
<div class="header">
  
   <div class="logo">
   <img src="images/logo.jpeg" alt="Logo">
    <span>LocalLink</span>
	</div>
  
  
    
    <a href="logout.php" class="logout" style ="margin-right: 15px;">Logout</a>
</div>

<div class="container">

    <!--SIDEBAR -->
    <div class="sidebar">
        <h3>Seller Menu</h3>

        <a href="user_dashboard.php">Back to Dashboard</a>
        

        <hr>
    </div>

    <!--MAIN CONTENT -->
    <div class="main">
        <h2>My Products</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="product-card">

                    <img src="images/<?php echo $row['image']; ?>" alt="Product Image">

                    <p><strong>Title:</strong> <?php echo $row['title']; ?></p>
                    <p><strong>Price:</strong> R <?php echo $row['price']; ?></p>
                    <p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>
                    <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                    <p><strong>Location:</strong> <?php echo $row['location']; ?></p>

                    <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="action-btn">
                        Edit
                    </a>

                    <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                       class="action-btn"
                       onclick="return confirm('Are you sure you want to delete this product?');">
                        Delete
                    </a>

                </div>

            <?php } ?>
        <?php } else { ?>
            <p>You have not added any products yet.</p>
        <?php } ?>

    </div>

</div>

</body>
</html>