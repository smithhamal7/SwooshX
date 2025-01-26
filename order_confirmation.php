<?php
// Start the session
session_start();

// Check if the payment method is set to Cash on Delivery (COD)
if (isset($_GET['payment']) && $_GET['payment'] === 'cod') {
    // Clear the cart after the order is confirmed
    unset($_SESSION['cart']);
    echo "Your order has been confirmed! Payment will be collected upon delivery.";
}
?>
