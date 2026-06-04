<?php
session_start();
include "database.php";

//  Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//  Handle "Become Seller"
if (isset($_POST['become_seller'])) {
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE users SET role = 'Seller' WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    $_SESSION['role'] = "Seller";

    header("Location: user_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>

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
    min-height: 100%;
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

.sidebar button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #fff3cd;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

.sidebar button:hover {
    background-color: #ffe69c;
}

/* Main content */
.main {
    flex: 1;
    padding: 25px;
}

.card {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
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



.logout {
    text-decoration: none;
    color: #000;
    font-weight: bold;
}


	
	
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

   <div style="display: flex; align-items: center; gap: 10px; margin-right: 15px;">


        <?php if ($_SESSION['role'] == "Buyer") { ?>
            <form method="POST" style="margin: 0;">
                <button name="become_seller"
                    style="background-color: #fff3cd;
                           border: none;
                           padding: 6px 12px;
                           border-radius: 6px;
                           font-weight: bold;
                           cursor: pointer;">
                    Start Selling
                </button>
            </form>
        <?php } ?>

        <a href="logout.php" class="logout">Logout</a>

    </div>
</div>


<!-- DASHBOARD LAYOUT -->
<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h3>
            Welcome, <?php echo $_SESSION['name']; ?><br>
            
        </h3>
		<hr>

        <!--BUYING SECTION -->
        <h4>Buying</h4>
		<a href="my_orders.php">Orders placed</a>
		<a href="C2C Marketplace.php">Browse Products</a>
		<a href="update.php">Update Profile</a>
		
		
        <!--SELLING SECTION (ONLY FOR SELLERS) -->
        <?php if ($_SESSION['role'] == "Seller") { ?>
            <h4>Selling</h4>
            <a href="add_product.php">Create New Listing</a>
            <a href="my_products.php">My Listings</a>
            <a href="sellers_orders.php">My Sales</a>
        <?php } ?>

      

       
		
		
		 

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h2>User Dashboard</h2>

        <div class="card">
            <h3>Account Overview</h3>
            <p>This dashboard allows you to manage both buying and selling activities. To become a seller click on the start selling button in the top right corner to unlock more features</p>
        </div>

        <div class="card">
            <h3>Buying Activity</h3>
            <p>View the products you have purchased using by clicking on "Orders placed".</p>
        </div>

        <?php if ($_SESSION['role'] == "Seller") { ?>
        <div class="card">
            <h3>Selling Activity</h3>
            <p>Manage your listings and track sales from buyers.</p>
        </div>
        <?php } ?>

    </div>

</div>

</body>
</html>