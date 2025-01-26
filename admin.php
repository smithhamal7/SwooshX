<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php'); // Redirect to home page if not an admin
    exit();
}

// Fetch statistics
$productCountQuery = "SELECT COUNT(*) as product_count FROM products";
$userCountQuery = "SELECT COUNT(*) as user_count FROM users";
$orderCountQuery = "SELECT COUNT(*) as order_count FROM orders";

$productResult = $conn->query($productCountQuery);
$userResult = $conn->query($userCountQuery);
$orderResult = $conn->query($orderCountQuery);

$productCount = $productResult->fetch_assoc()['product_count'];
$userCount = $userResult->fetch_assoc()['user_count'];
$orderCount = $orderResult->fetch_assoc()['order_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SwooshX</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <main>
        <div class="dashboard">
            <h1>Welcome, Admin</h1>
            <div class="stats">
                <div class="stat-card">
                    <h3>Products</h3>
                    <p><?= $productCount; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Users</h3>
                    <p><?= $userCount; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Orders</h3>
                    <p><?= $orderCount; ?></p>
                </div>
            </div>

            <div class="admin-actions">
                <h2>Manage Products</h2>
                <button onclick="window.location.href='manage_products.php'">Add / Edit Products</button>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
