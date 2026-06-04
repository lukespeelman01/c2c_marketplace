<?php
session_start();
include "database.php";

/* Check product_id */
if (!isset($_GET['id'])) {
    echo "Product not found.";
    exit();
}

$product_id = intval($_GET['id']);

/*Fetch product + seller info */
$query = "
    SELECT 
        products.product_id,
        products.title,
        products.description,
        products.price,
        products.location,
        products.image,
        products.user_id AS seller_id,
        category.name AS category_name,
        users.phone,
        users.email
    FROM products
    JOIN category ON products.category_id = category.category_id
    JOIN users ON products.user_id = users.user_id
    WHERE products.product_id = $product_id
    LIMIT 1
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) !== 1) {
    echo "Product not found.";
    exit();
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['title']; ?> | Product Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }

        .product-container {
            max-width: 800px;
            background-color: #ffffff;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .product-image {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background-color: #eee;
            margin-bottom: 20px;
        }

        h2 {
            margin-top: 0;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .label {
            font-weight: bold;
        }

        .action-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 14px;
            background-color: #fff3cd;
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .action-btn:hover {
            background-color: #ffe69c;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="product-container">

    <img 
        src="images/<?php echo $product['image']; ?>"
        alt="Product image"
        class="product-image"
    >

    <h2><?php echo $product['title']; ?></h2>

    <p class="price">R <?php echo number_format($product['price'], 2); ?></p>

    <p><span class="label">Category:</span> <?php echo $product['category_name']; ?></p>

    <p><span class="label">Location:</span> <?php echo $product['location']; ?></p>

    <p><span class="label">Description:</span> <?php echo $product['description']; ?></p>

    <!--REAL seller contact -->
    <p>
        <span class="label">Seller Contact:</span><br>
        <?php 
        if (isset($_SESSION['user_id'])) {
            echo "Phone: " . $product['phone'] . "<br>";
            echo "Email: " . $product['email'];
        } else {
            echo "Login to view contact details";
        }
        ?>
    </p>

    <!--Buyer can order -->
    <?php if (
        isset($_SESSION['user_id']) &&
        $_SESSION['user_id'] != $product['seller_id']
    ) { ?>
        <a 
            href="payment.php?product_id=<?php echo $product['product_id']; ?>"
            class="action-btn"
        >
            Place Order
        </a>
    <?php } ?>

    <!--Seller controls -->
    <?php if (
        isset($_SESSION['role']) &&
        $_SESSION['role'] === "Seller" &&
        $_SESSION['user_id'] == $product['seller_id']
    ) { ?>
        <a href="edit_product.php?id=<?php echo $product['product_id']; ?>" class="action-btn">
            Edit Product
        </a>

        <a href="delete_product.php?id=<?php echo $product['product_id']; ?>" class="action-btn">
            Delete Product
        </a>
    <?php } ?>

    <br>
    <a href="C2C Marketplace.php" class="back-link">
        Back to Marketplace
    </a>

</div>

</body>
</html>
