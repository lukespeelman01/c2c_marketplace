<?php
session_start();
include "database.php";

/* Only sellers allowed */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Seller") {
    echo "Access denied";
    exit();
}

/* Check product ID */
if (!isset($_GET['id'])) {
    echo "Product not found.";
    exit();
}

$product_id = intval($_GET['id']);
$seller_id = $_SESSION['user_id'];

/* Fetch product and verify ownership */
$query = "
    SELECT *
    FROM products
    WHERE product_id = '$product_id'
    AND user_id = '$seller_id'
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) !== 1) {
    echo "You do not have permission to edit this product.";
    exit();
}

$product = mysqli_fetch_assoc($result);

/* Handle form submission */
if (isset($_POST['update_product'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    $image = $product['image'];

    /* Handle image replacement */
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "images/" . $imageName;

        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
            $image = $imageName;
        }
    }

    $updateQuery = "
        UPDATE products SET
            title = '$title',
            description = '$description',
            price = '$price',
            location = '$location',
            image = '$image'
        WHERE product_id = '$product_id'
    ";

    if (mysqli_query($conn, $updateQuery)) {
        $success = "Product updated successfully.";
    } else {
        $error = "Error updating product.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            width: 420px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #FFF8E1;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #FFF3CD;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>

<body>

<div class="form-container">
    <h2>Edit Product</h2>

    <?php if (isset($success)) echo "<div class='message' style='color:green;'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='message' style='color:red;'>$error</div>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Product Title</label>
        <input type="text" name="title" value="<?php echo $product['title']; ?>" required>

        <label>Description</label>
        <textarea name="description" required><?php echo $product['description']; ?></textarea>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

        <label>Location</label>
        <input type="text" name="location" value="<?php echo $product['location']; ?>" required>

        <label>Replace Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="update_product">Update Product</button>
    </form>

    <a href="user_dashboard.php" class="back-link">Back to Dashboard</a>
</div>

</body>
</html>