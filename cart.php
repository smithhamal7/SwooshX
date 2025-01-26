<?php
// Start the session
session_start();

// Include database connection
include 'db.php';

// Check if the cart exists in the session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cartEmpty = true;
} else {
    $cartEmpty = false;
}

// Handle updating the cart (edit quantity or remove product)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_product'])) {
        $productIdToRemove = $_POST['remove_product'];
        unset($_SESSION['cart'][$productIdToRemove]); // Remove the product from the cart
    } elseif (isset($_POST['update_quantity'])) {
        $productIdToUpdate = $_POST['update_product_id'];
        $newQuantity = $_POST['new_quantity'];
        if ($newQuantity > 0) {
            $_SESSION['cart'][$productIdToUpdate]['quantity'] = $newQuantity; // Update the quantity
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
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <?php if ($cartEmpty): ?>
            <p>Your cart is empty. Add some products to your cart!</p>
        <?php else: ?>
            <form method="POST">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalAmount = 0;

                        // Loop through the cart and display each product
                        foreach ($_SESSION['cart'] as $productId => $product) {
                            $totalPrice = $product['price'] * $product['quantity'];
                            $totalAmount += $totalPrice;
                        ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image"></td>
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td>$<?= htmlspecialchars(number_format($product['price'], 2)); ?></td>
                                <td>
                                    <input type="number" name="new_quantity" value="<?= $product['quantity']; ?>" min="1">
                                    <input type="hidden" name="update_product_id" value="<?= $productId; ?>">
                                    <input type="submit" name="update_quantity" value="Update Quantity" class="btn">
                                </td>
                                <td>$<?= htmlspecialchars(number_format($totalPrice, 2)); ?></td>
                                <td>
                                    <button type="submit" name="remove_product" value="<?= $productId; ?>" class="btn remove-btn">Remove</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <h3>Total Amount: $<?= htmlspecialchars(number_format($totalAmount, 2)); ?></h3>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
