<?php
$servername = "localhost";
$username = "root";
$password = ""; // default for XAMPP
$dbname = "ecommerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
