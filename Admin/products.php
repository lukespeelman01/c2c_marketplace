<?php
session_start();
include "../database.php";

/* Only admins allowed */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Admin") {
    echo "Access denied";
    exit();
}

/* Handle delete action */
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);

    /* Optional: fetch image to delete file */
    $imgResult = mysqli_query($conn, "SELECT image FROM products WHERE product_id = '$product_id'");
    if ($imgRow = mysqli_fetch_assoc($imgResult)) {
        if (!empty($imgRow['image']) && file_exists("../images/" . $imgRow['image'])) {
            unlink("../images/" . $imgRow['image']);
        }
    }

    mysqli_query($conn, "DELETE FROM products WHERE product_id = '$product_id'");
}

/* Fetch all products */
$query = "
    SELECT
        products.product_id,
        products.title,
        products.price,
        products.location,
        products.image,
        category.name AS category_name,
        users.name AS seller_name,
        users.email AS seller_email
    FROM products
    JOIN category ON products.category_id = category.category_id
    JOIN users ON products.user_id = users.user_id
    ORDER BY products.created_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        /* Header */
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

        /* Layout */
        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
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

        /* Main content */
        .main {
            flex: 1;
            padding: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f2f5;
        }

        img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background-color: #eee;
        }

        .action-btn {
            padding: 6px 10px;
            background-color: #fff3cd;
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .action-btn:hover {
            background-color: #ffe69c;
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

<!-- HEADER -->
<div class="header">
   
    <div class="logo">
   <img src="images/logo.jpeg" alt="Logo">
    <span>LocalLink</span>
	</div>
   
   
   
    <a href="../logout.php" class="logout" style = "margin-right: 15px">Logout</a>
</div>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        

        <a href="dashboard.php"> Back To Dashboard</a>
        
        <hr>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h2>Manage Products</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Seller</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>
                            <img src="../images/<?php echo $row['image']; ?>" alt="Product Image">
                        </td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td>R <?php echo $row['price']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                            <?php echo $row['seller_name']; ?><br>
                            <small><?php echo $row['seller_email']; ?></small>
                        </td>
                        <td>
                            <a
                                href="products.php?delete=<?php echo $row['product_id']; ?>"
                                class="action-btn"
                                onclick="return confirm('Delete this product?');"
                            >
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No products found.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>
