<?php
// Start the session
session_start();

// Clear the cart after successful order confirmation
if (isset($_GET['payment'])) {
    $paymentMethod = $_GET['payment'];

    if ($paymentMethod === 'khalti' || $paymentMethod === 'cod') {
        unset($_SESSION['cart']); // Clear the cart
        echo "<h1>Order Confirmed!</h1>";
        echo "<p>Payment Method: " . strtoupper($paymentMethod) . "</p>";
        echo "<p>Thank you for your purchase!</p>";
        exit;
    }
}

// Redirect to home if accessed directly
header('Location: home.php');
exit;
?>
