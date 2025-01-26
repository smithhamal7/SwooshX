<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwooshX</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        /* Center main content */
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
            font-size: 1.5rem;
        }

        main h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        main p {
            font-size: 1.25rem;
        }

        .section {
            padding: 50px 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
            margin: 10px;
            border-radius: 8px;
        }

        .section:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }

        .section h2 {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .section p {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            main h1 {
                font-size: 2.5rem;
            }

            main p {
                font-size: 1rem;
            }

            .section {
                padding: 30px 15px;
            }

            .section h2 {
                font-size: 1.8rem;
            }

            .section p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<?php
// Start the session
session_start();
?>

<body>
    <!--  include 'navbar.php'; ?> -->
    <header>
        <nav class="navigation">
            <?php if (isset($_SESSION['username'])): ?>
                    <!-- Show logout button if logged in -->
                    <form action="logout.php" method="POST" style="display:inline ">
                        <button type="submit" class="btnLogin-popup" style="float:right;">Logout</button>
                    </form>
                <?php else: ?>
                    <!-- Show login button if not logged in -->
                    <button class="btnLogin-popup"  style="float:right;"><a href="login.html">Login</a></button>
                <?php endif; ?>
        </nav>
    </header>
    <main>
        <h1>Welcome to SwooshX</h1>
        <p>Your one-stop shop for amazing products!</p>
    </main>

    <div class="section">
        <h2>Featured Products</h2>
        <p>Check out our latest and greatest products, curated just for you.</p>
    </div>

    <div class="section">
        <h2>About Us</h2>
        <p>Learn more about SwooshX and our mission to deliver excellence.</p>
    </div>

    <div class="section">
        <h2>Customer Reviews</h2>
        <p>See what our happy customers have to say about our products.</p>
    </div>

    <div class="section">
        <h2>Contact Us</h2>
        <p>Have questions? Get in touch with our friendly support team.</p>
    </div>

    <script src="script.js"></script>
</body>
</html>
