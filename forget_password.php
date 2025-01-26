<?php
session_start();
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email input
    $email = htmlspecialchars(trim($_POST['email']));

    // Check if email exists in the database
    include 'db.php'; // Make sure your DB connection is correctly set

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The email exists, initiate the process (you could send an OTP or an email here)
        // For simplicity, let's display a success message that the password reset request was processed
        $success_message = "An email has been sent to your address with instructions to reset your password.";
    } else {
        // The email does not exist in the database
        $error_message = "The email address you entered is not registered. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div class="form_box">
        <h2>Forgot Password</h2>

        <!-- Forgot Password Form -->
        <form action="forgot_password.php" method="POST">
            <div class="input-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <button type="submit" class="btn">Send OTP Code</button>
            <div class="login-register">
                <p>Remember your password? <a href="login.html">Login</a></p>
            </div>
        </form>

        <!-- Error Message -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?= $success_message; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
