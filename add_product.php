<?php
session_start();
include "database.php";

/* Only sellers can access this page */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Seller") {
    echo "Access denied";
    exit();
}

/* Handle form submission */
if (isset($_POST['add_product'])) {

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $location = $_POST['location'];

    /*Handle image upload */
    $image = "no-image.png";

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "images/" . $imageName;

        /* Optional safety check */
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExt, $allowedTypes)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
            $image = $imageName;
        }
    }

    /* Insert product */
    $query = "
        INSERT INTO products 
        (user_id, category_id, title, description, price, image, location)
        VALUES 
        ('$user_id', '$category_id', '$title', '$description', '$price', '$image', '$location')
    ";

    if (mysqli_query($conn, $query)) {
        $success = "Product added successfully";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

/* Fetch categories */
$categories = mysqli_query($conn, "SELECT * FROM category");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

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

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
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

        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="form-container">
    <h2>Add New Product</h2>

    <?php if (isset($success)) echo "<div class='message' style='color:green;'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='message' style='color:red;'>$error</div>"; ?>

    <!--enctype is REQUIRED for file upload -->
    <form method="POST" enctype="multipart/form-data">

        <label>Product Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Price</label>
        <input type="number" name="price" step="0.01" required>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                <option value="<?php echo $cat['category_id']; ?>">
                    <?php echo $cat['name']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Location</label>
        <input type="text" name="location" required>

        <!--NEW: Image upload -->
        <label>Product Image</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <a href="user_dashboard.php" class="back-link">Back to Seller Dashboard</a>
</div>

</body>
</html>