<?php
include 'db.php';

// Fetch products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwooshX Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

    <main>
        <div class="products-container">
            <h1>Our Products</h1>
            <div class="products">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($product = $result->fetch_assoc()): ?>
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                            <h3><?= htmlspecialchars($product['name']); ?></h3>
                            <p><?= htmlspecialchars($product['description']); ?></p>
                            <span class="price">$<?= htmlspecialchars(number_format($product['price'], 2)); ?></span>
                            <?php if (isset($_SESSION['username'])): ?>
                                <button class="btn">Add to Cart</button>
                            <?php else: ?>
                                <p class="login-message">Login to purchase</p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No products available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
