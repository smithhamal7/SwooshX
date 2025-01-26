<?php
// Start the session
session_start();

// Include database connection
include 'db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent in the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate the product_id from the request
    if (!isset($data['product_id']) || !is_numeric($data['product_id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
        exit;
    }

    $productId = (int)$data['product_id'];

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Add product to the session cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1; // Increment quantity
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
                'image_url' => $product['image_url'],
            ];
        }

        echo json_encode(['success' => true, 'message' => 'Product added to cart.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
