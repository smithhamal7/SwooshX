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

$totalAmount = 0;
foreach ($_SESSION['cart'] as $productId => $product) {
    $totalAmount += $product['price'] * $product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <h3>Total Amount: $<?= htmlspecialchars(number_format($totalAmount / 100, 2)); ?></h3> <!-- Assuming totalAmount is in paisa -->

        <p>Please choose a payment method:</p>
        <form action="payment_handler.php" method="POST">
            <input type="hidden" name="amount" value="<?= $totalAmount; ?>">
            <div>
                <input type="radio" id="cash_on_delivery" name="payment_method" value="cod" required>
                <label for="cash_on_delivery">Cash on Delivery</label>
            </div>
            <div>
                <input type="radio" id="khalti_wallet" name="payment_method" value="khalti">
                <label for="khalti_wallet">Khalti Wallet</label>
            </div>
            <button type="submit" class="btn">Proceed to Payment</button>
        </form>
    </div>
</main>

</body>
</html>
