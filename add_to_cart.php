<?php
session_start();

// Check if the cart exists in the session
if (!isset($_SESSION['cart'])) {
    // If the cart doesn't exist, initialize it as an empty array
    $_SESSION['cart'] = [];
}

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check if product_id is present
    if (isset($data['product_id'])) {
        $productId = $data['product_id'];

        // Initialize cart in session if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add product to the cart (you can add quantity logic here)
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'quantity' => 1,
            ];
        }

        // Respond with success
        echo json_encode(['success' => true, 'message' => 'Product added to cart.']);
    } else {
        // Respond with an error
        echo json_encode(['success' => false, 'message' => 'Product ID is missing.']);
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
