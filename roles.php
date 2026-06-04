<?php
session_start();
include "../database.php";

/* Only admins allowed */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Admin") {
    echo "Access denied";
    exit();
}

/* Handle role update */
if (isset($_POST['update_role'])) {

    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['role'];

    /* Count current admins */
    $adminCountResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'Admin'");
    $adminCountRow = mysqli_fetch_assoc($adminCountResult);
    $adminCount = $adminCountRow['total'];

    /* Get current role */
    $currentRoleResult = mysqli_query($conn, "SELECT role FROM users WHERE user_id = '$user_id'");
    $currentRoleRow = mysqli_fetch_assoc($currentRoleResult);
    $currentRole = $currentRoleRow['role'];

    /* Prevent removing last admin */
    if ($currentRole === 'Admin' && $new_role !== 'Admin' && $adminCount <= 1) {
        $error = "You cannot remove the last Admin.";
    } else {
        mysqli_query($conn, "UPDATE users SET role = '$new_role' WHERE user_id = '$user_id'");
        $success = "Role updated successfully.";
    }
}

/* Fetch all users */
$query = "
    SELECT user_id, name, email, role
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
    <title>Assign Roles</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

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

        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            border-right: 1px solid #ddd;
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
        }

        th {
            background-color: #f0f2f5;
        }

        select {
            padding: 6px;
        }

        button {
            padding: 6px 10px;
            background-color: #fff3cd;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #ffe69c;
        }

        .message {
            margin-bottom: 15px;
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
	
        <a href="dashboard.php"> Back To Dashboard</a>
        
		    <hr>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h2>Assign User Roles</h2>

        <?php if (isset($error)) { ?>
            <p class="message" style="color:red;"><?php echo $error; ?></p>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <p class="message" style="color:green;"><?php echo $success; ?></p>
        <?php } ?>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Current Role</th>
                <th>Change Role</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <select name="role">
                                <option value="Buyer" <?php if ($row['role'] === 'Buyer') echo 'selected'; ?>>Buyer</option>
                                <option value="Seller" <?php if ($row['role'] === 'Seller') echo 'selected'; ?>>Seller</option>
                                <option value="Admin" <?php if ($row['role'] === 'Admin') echo 'selected'; ?>>Admin</option>
                            </select>
                    </td>
                    <td>
                            <button type="submit" name="update_role">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>