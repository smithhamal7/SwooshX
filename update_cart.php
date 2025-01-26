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

// Here you can add your payment and order processing logic (e.g., Stripe, PayPal)

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
        <p>Please proceed to payment to complete your purchase.</p>
        
        <!-- Example Payment Form (You can implement actual payment methods) -->
        <form action="payment.php" method="POST">
            <input type="submit" value="Proceed to Payment" class="btn">
        </form>
    </div>
</main>

</body>
</html>

