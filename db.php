<?php
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "";
$dbname = getenv('DB_NAME') ?: "php micro project";
$port = getenv('DB_PORT') ?: 3306;

$conn = mysqli_init();
mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
