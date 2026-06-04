<?php
session_start();
include "database.php";

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];

    //Delete product
    $query = "DELETE FROM products WHERE product_id = '$product_id'";
    mysqli_query($conn, $query);
}

//Redirect back to products page
header("Location: my_products.php");
exit();
?>