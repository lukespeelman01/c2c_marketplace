<?php
session_start();
include "database.php";

/*
 Only logged-in users can place orders
*/
if (!isset($_SESSION['user_id'])) {
    echo "Access denied";
    exit();
}

/*
 Accept product_id from POST (payment) OR GET (direct link)
*/
if (isset($_POST['product_id'])) {
    // from payment page
    $product_id = intval($_POST['product_id']);

} elseif (isset($_GET['product_id'])) {
    // fallback (direct access)
    $product_id = intval($_GET['product_id']);

} else {
    echo "Invalid product";
    exit();
}

$buyer_id = $_SESSION['user_id'];
$order_date = date("Y-m-d");
$order_status = "Pending";
$quantity = 1; // default quantity (no cart yet)

/*
 STEP 1: Insert into orders table
*/
$order_sql = "
    INSERT INTO orders (buyer_id, order_date, order_status)
    VALUES ('$buyer_id', '$order_date', '$order_status')
";

if (!mysqli_query($conn, $order_sql)) {
    die("Error creating order: " . mysqli_error($conn));
}

/*
 Get the newly created order_id
*/
$order_id = mysqli_insert_id($conn);

/*
 STEP 2: Insert into orderdetails table
*/
$details_sql = "
    INSERT INTO orderdetails (order_id, product_id, quantity)
    VALUES ('$order_id', '$product_id', '$quantity')
";

if (!mysqli_query($conn, $details_sql)) {
    die("Error creating order item: " . mysqli_error($conn));
}

/*
 STEP 3: Redirect user back to dashboard (or success page later)
*/
header("Location: payment_success.php");
exit();
?>
