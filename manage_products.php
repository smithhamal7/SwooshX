<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php'); // Redirect to home page if not an admin
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new product (simple version)
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(trim($_POST['price']));
    $image_url = htmlspecialchars(trim($_POST['image_url']));

    $insertQuery = "INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $name, $description, $price, $image_url);
    
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - SwooshX</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <main>
        <div class="product-management">
            <h1>Manage Products</h1>

            <form action="manage_products.php" method="POST">
                <input type="text" name="name" placeholder="Product Name" required>
                <textarea name="description" placeholder="Product Description" required></textarea>
                <input type="number" step="0.01" name="price" placeholder="Product Price" required>
                <input type="text" name="image_url" placeholder="Product Image URL" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
