<?php
session_start();
include "../database.php";

/* Only admins allowed */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Admin") {
    echo "Access denied";
    exit();
}

/* Fetch all users */
$query = "
    SELECT user_id, name, email, role, phone
    FROM users
    ORDER BY user_id DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>

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
            font-weight: bold;
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
        

        <a href="dashboard.php">Back To Dashboard</a>
        
        <hr>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h2>View Users</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No users found.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>