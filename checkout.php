<?php
// Start the session
session_start();

// Include database connection
include 'db.php';

// Check if the cart exists and is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: home.php');  // Redirect to home if cart is empty
    exit;
}

// Calculate total amount
$totalAmount = 0;
foreach ($_SESSION['cart'] as $productId => $product) {
    $totalAmount += $product['price'] * $product['quantity'];
}

// Process payment method selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment_method'])) {
        $paymentMethod = $_POST['payment_method'];

        // Handle Khalti Wallet Payment
        if ($paymentMethod === 'khalti') {
            // Redirect to Khalti payment page (Add Khalti API integration here)
            header('Location: khalti_payment.php');
            exit;
        }
        // Handle Cash on Delivery
        elseif ($paymentMethod === 'cod') {
            // Simulate the COD order processing
            unset($_SESSION['cart']);  // Clear the cart after confirmation
            header('Location: order_confirmation.php?payment=cod');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <h3>Total Amount: $<?= htmlspecialchars(number_format($totalAmount, 2)); ?></h3>
        <p>Please choose your payment method:</p>

        <!-- Payment Method Form -->
        <form method="POST">
            <div class="payment-option">
                <input type="radio" name="payment_method" value="khalti" id="khalti" required>
                <label for="khalti">Pay with Khalti Wallet</label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" value="cod" id="cod" required>
                <label for="cod">Cash on Delivery</label>
            </div>
            
            <input type="submit" value="Proceed with Payment" class="btn">
        </form>
    </div>
</main>

</body>
</html>
