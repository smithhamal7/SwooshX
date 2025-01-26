<?php
// Start the session
session_start();

// Check if cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: home.php');  // Redirect to home if cart is empty
    exit;
}

// Total amount
$totalAmount = 0;
foreach ($_SESSION['cart'] as $productId => $product) {
    $totalAmount += $product['price'] * $product['quantity'];
}

// Example Khalti API - this requires actual integration with Khalti's API
// You will need Khalti's API key and other setup which I will simplify here
echo "Redirecting to Khalti Wallet for payment...";

// In reality, you would use the Khalti API here. After a successful transaction, 
// you would redirect to an order confirmation page or success page.
// header('Location: payment_success.php');
// exit;
?>
