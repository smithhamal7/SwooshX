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
    <div class="product-management" style="max-width: 800px; margin: 2rem auto; padding: 2rem; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; font-size: 2rem; color: #333; margin-bottom: 1.5rem;">Manage Products</h1>

    <!-- Add Product Form -->
    <form action="manage_products.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
        <input 
            type="text" 
            name="name" 
            placeholder="Product Name" 
            required 
            style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; width: 100%;"
        >
        <textarea 
            name="description" 
            placeholder="Product Description" 
            required 
            style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; width: 100%; resize: none; height: 100px;">
        </textarea>
        <input 
            type="number" 
            step="0.01" 
            name="price" 
            placeholder="Product Price" 
            required 
            style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; width: 100%;"
        >
        <input 
            type="text" 
            name="image_url" 
            placeholder="Product Image URL" 
            required 
            style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; width: 100%;"
        >
        <button 
            type="submit" 
            style="background-color: maroon; color: white; padding: 0.75rem; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s;">
            Add Product
        </button>
    </form>
</div>

    </main>
</body>
</html>
