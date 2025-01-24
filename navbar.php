<?php
session_start();
?>

<header>
    <h2 class="logo">SwooshX</h2>
    <nav class="navigation">
        <a href="index.php">Home</a>
        <a href="#">About</a>
        <a href="product.php">Product</a>
        <a href="#">Contact</a>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- Show logout button if logged in -->
            <form action="logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btnLogin-popup">Logout</button>
            </form>
        <?php else: ?>
            <!-- Show login button if not logged in -->
            <button class="btnLogin-popup"><a href="login.php">Login</a></button>
        <?php endif; ?>
    </nav>
</header>
