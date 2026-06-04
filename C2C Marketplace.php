

<?php
session_start();
include "database.php";

$categoryFilter = "";
$pageTitle = "Today's Picks"; // used to make the heading dynamic instead of static

$whereConditions = [];
$pageTitle = "Today's Picks";

	// Category filter
	if (isset($_GET['category'])) { 
    $category_id = intval($_GET['category']);
    $whereConditions[] = "products.category_id = $category_id";

    $catResult = mysqli_query($conn, "SELECT name FROM category WHERE category_id = $category_id");
    if ($cat = mysqli_fetch_assoc($catResult)) {
        $pageTitle = $cat['name'];
    }
	}

	// Search filter
	if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $whereConditions[] = "(products.title LIKE '%$search%' OR products.description LIKE '%$search%')";
	}

	// Combine conditions
	$whereSQL = "";
	if (!empty($whereConditions)) {
    $whereSQL = "WHERE " . implode(" AND ", $whereConditions);
	}



$productsQuery = "
    SELECT products.*, category.name AS category_name
    FROM products
    JOIN category ON products.category_id = category.category_id
    $whereSQL
";


$productsResult = mysqli_query($conn, $productsQuery);



?>






<!DOCTYPE html>
<html>
<head>
    <title>C2C Marketplace – Marketplace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ===============================
           GLOBAL
           =============================== */
        .body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        /* ===============================
           TOP BAR
           =============================== */
        .topbar {
            background-color: #ffffff;
            padding: 1px 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;

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

        .login {
            display: flex;
            gap: 8px;
        }

        .login-button {
            padding: 6px 14px;
            background-color: #FFF8E1;
            color: #000000;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
            text-decoration: none;
        }

        /* ===============================
           LAYOUT
           =============================== */
        .layout {
            display: flex;
        }

        /* ===============================
           SIDEBAR
           =============================== */
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            padding: 15px;
            border-right: 1px solid #ddd;
            min-height: 100vh;
            text-align: left;
        }

        .sidebar-title {
            margin-top: 0;
            font-size: 20px;
        }

        .search-input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .section-title {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        /* ===============================
           ICON + ITEM STYLES
           =============================== */
        .icon-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .menu-item {
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-family: 'Inter', Arial, sans-serif;
            font-weight: 500;

        }

        .create {
            background-color: #FFF8E1;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin: 15px 0;
        }

        /* ===============================
           CONTENT
           =============================== */
        .content {
            flex: 1;
            padding: 20px;
        }

        .content-title {
            margin-top: 0;
        }

        /* ===============================
           PRODUCT GRID
           =============================== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

    .card {
	background-color: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
	}

	.card:hover {
    transform: translateY(-5px); /* lift effect */
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
	}



        .card-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-info {
            padding: 10px;
        }

        .price {
            font-weight: bold;
            margin: 0;
        }

        .title {
            font-size: 14px;
            margin: 5px 0;
        }

        .location {
            font-size: 12px;
            color: gray;
        }
		
		
		
		/* Category hover */
		.menu-item:hover {
		background-color: #f0f0f0; /* light grey */
		}

		
		/* Yellow button hover */
		.login-button:hover,
		.create:hover {
		background-color: #FFF3CD; /* golden yellow */
		}

		
		
		/* Remove underline & link color for create listing link */
		.create a {
		text-decoration: none;
		color: inherit;
		}
		
		
		.menu-item a {
		text-decoration: none;
		color: inherit;
		display: block;
		width: 100%;
		}

	.topbar {
    overflow: hidden; /*keeps header same size */
	}
		
		
    </style>
</head>

<body class="body">

<!-- TOP BAR -->
<div class="topbar">
    
	<div class="logo">
   <img src="images/logo.jpeg" alt="Logo">
    <span>LocalLink</span>
	</div>
	
	

    <div class="login" style = "margin-right: 15px;">
        <a class="login-button" href="register.php">Register</a>
        <a class="login-button" href="login.php">Log in</a>
		<a class="login-button" href="help_request.php">Help & Support</a>
    </div>
</div>

<!-- MAIN LAYOUT -->
<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3 class="sidebar-title">Marketplace</h3>

     <form method="GET">
    <input 
        class="search-input" 
        type="text" 
        name="search" 
        placeholder="Search Marketplace"
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
	>
	</form>


        <!-- ACCOUNT -->
        <div class="menu-item icon-item create">
            <svg class="icon" viewBox="0 0 32 32">
                <circle cx="16" cy="16" r="16" fill="#E6E6E6"/>
                <circle cx="16" cy="12" r="4" fill="#000000"/>
                <path d="M8.5 24c0-4.5 15-4.5 15 0" fill="#000000"/>
            </svg>
			
        <?php
		$accountLink = "login.php";

		$accountLink = "login.php";

		if (isset($_SESSION['user_id'])) {
		$accountLink = "user_dashboard.php";
		}

		?>

		<a href="<?php echo $accountLink; ?>">Your account</a>
			
        </div>

        <!-- CREATE LISTING -->

        <div class="menu-item icon-item create">
            <svg class="icon" viewBox="0 0 32 32">
                <circle cx="16" cy="16" r="16" fill="#E6E6E6"/>
                <rect x="15" y="8" width="2" height="16" fill="#000000"/>
                <rect x="8" y="15" width="16" height="2" fill="#000000"/>
            </svg>
            <a href="create_listing.php">Create new listing</a>
        </div>

        <hr>

        <div class="section-title">Categories</div>

        <div class="menu-item icon-item">
            <svg class="icon" viewBox="0 0 32 32">
                <rect x="6" y="4" width="20" height="24" rx="3" fill="#E6E6E6"/>
                <rect x="10" y="8" width="12" height="16" fill="#000000"/>
            </svg>
            <a href="C2C Marketplace.php?category=1">Electronics</a>
        </div>

        <div class="menu-item icon-item">
            <svg class="icon" viewBox="0 0 32 32">
                <path d="M8 6l6 4h4l6-4 4 6-6 4v10H10V16l-6-4z" fill="#E6E6E6"/>
                <rect x="13" y="10" width="6" height="14" fill="#000000"/>
            </svg>
          <a href="C2C Marketplace.php?category=2">Clothing</a>
        </div>

        <div class="menu-item icon-item">
            <svg class="icon" viewBox="0 0 32 32">
                <rect x="6" y="10" width="20" height="8" rx="2" fill="#E6E6E6"/>
                <rect x="8" y="18" width="2" height="8" fill="#000000"/>
                <rect x="22" y="18" width="2" height="8" fill="#000000"/>
            </svg>
            <a href="C2C Marketplace.php?category=3">Furniture</a>
        </div>

        <div class="menu-item icon-item">
            <svg class="icon" viewBox="0 0 32 32">
                <rect x="6" y="14" width="20" height="6" rx="2" fill="#E6E6E6"/>
                <circle cx="10" cy="22" r="2" fill="#7A7A7A"/>
                <circle cx="22" cy="22" r="2" fill="#7A7A7A"/>
            </svg>
            <a href="C2C Marketplace.php?category=4">Vehicles</a>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">
       <h2 class="content-title"><?php echo $pageTitle; ?></h2>
	   
	   <div class="grid">
    <?php if (mysqli_num_rows($productsResult) > 0) { ?>
        <?php while ($product = mysqli_fetch_assoc($productsResult)) { ?>
		
           
		   <div class="card">
		   
		   
               
<a href="product_details.php?id=<?php echo $product['product_id']; ?>">
    <img
        src="images/<?php echo $product['image']; ?>"
        class="card-image"
        alt="<?php echo $product['title']; ?>"
    >
</a>


                <div class="card-info">
                    <p class="price">R<?php echo number_format($product['price'], 2); ?></p>
                    <p class="title"><?php echo $product['title']; ?></p>
                    <p class="location">
                        <?php echo $product['location']; ?> • <?php echo $product['category_name']; ?>
                    </p>

                   
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No products found in this category.</p>
    <?php } ?>
</div>

	   
	   
    </div>

</div>

</body>
</html> 



