<?php
session_start();
include "database.php";

/* Any logged-in user can view products */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
    <title>View Products</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .product-card img {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background-color: #eee;
            margin-bottom: 10px;
        }

        .product-card h3 {
            margin: 0 0 10px 0;
        }

        .order-btn {
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

        .order-btn:hover {
            background-color: #ffe69c;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            font-weight: bold;
            text-decoration: none;
            color: #000;
        }
    </style>
</head>

<body>

<h2>Available Products</h2>

<a href="user_dashboard.php" class="back-link">Back to dashboard</a>

<div class="product-grid">

<?php if (mysqli_num_rows($result) > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">

            <img src="images/<?php echo $row['image']; ?>" alt="Product Image">

            <h3><?php echo $row['title']; ?></h3>

            <p><strong>Price:</strong> R <?php echo $row['price']; ?></p>
            <p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>
            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
            <p><strong>Location:</strong> <?php echo $row['location']; ?></p>

            <?php
            if (
                isset($_SESSION['role']) &&
                $_SESSION['role'] === 'Seller' &&
                $_SESSION['user_id'] == $row['user_id']
            ) {
            ?>
                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="order-btn">
                    Edit
                </a>

                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                   class="order-btn"
                   onclick="return confirm('Are you sure you want to delete this product?');">
                    Delete
                </a>
            <?php } ?>

        </div>
    <?php } ?>
<?php } else { ?>
    <p>No products available yet.</p>
<?php } ?>

</div>

</body>
</html>