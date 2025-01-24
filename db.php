<?php
$host = 'localhost'; // Change if needed
$user = 'root';      // Your MySQL username
$password = '';      // Your MySQL password
$dbname = 'swooshx'; // Database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
