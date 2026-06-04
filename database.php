

<?php
$host = "localhost";
$username = "c2c_user";  // I decided to not use root because of security concerns
$password = "Bolt8144";
$database = "c2c_ecommerce"; // 3306 didnt work so i had to change it to 3307
$port = 3307;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error()); // This tells us where the error is and stops the program form running
}


?>