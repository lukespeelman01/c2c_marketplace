<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if role is Admin
if ($_SESSION['role'] !== "Admin") {
    echo "Access denied";
    exit();
}
?>

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

/* Main content */
.main {
    flex: 1;
    padding: 25px;
}

.main h2 {
    margin-top: 0;
}

/* Info boxes */
.card {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
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

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

<!-- DASHBOARD LAYOUT -->
<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Welcome, <?php echo $_SESSION['name']; ?> (Admin)</h3>

		<a href="users.php">View Users</a>
		<a href="products.php">Manage Products</a>
		<a href="roles.php">Assign Roles</a>

        <hr><br>

        <a href="../C2C Marketplace.php">Back to Marketplace</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <h2>Admin Dashboard</h2>

        <div class="card">
            <h3>User Management</h3>
            <p>View, update, and remove users registered on the platform.</p>
        </div>

        <div class="card">
            <h3>Product Moderation</h3>
            <p>Review and manage product listings to ensure platform quality.</p>
        </div>

        <div class="card">
            <h3>Platform Control</h3>
            <ul>
                <li>Assign or update user roles</li>
                <li>Monitor marketplace activity</li>
                <li>Remove fraudulent users or listings</li>
            </ul>
        </div>

    </div>

</div>

</body>
</html>