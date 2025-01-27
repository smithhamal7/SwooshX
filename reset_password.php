<?php
session_start();
$error_message = '';
$success_message = '';

// Check if the user is allowed to reset their password
if (!isset($_SESSION['otp_email'])) {
    header("Location: forget_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new password from the form
    $new_password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    // Validate the passwords
    if (empty($new_password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        // Hash the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        include 'db.php';
        $query = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed_password, $_SESSION['otp_email']);

        if ($stmt->execute()) {
            $success_message = "Your password has been reset successfully.";
            unset($_SESSION['otp_email']); // Clear the session
            header("Refresh: 3; url=login.html"); // Redirect to the login page after 3 seconds
        } else {
            $error_message = "An error occurred. Please try again.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div class="form_box">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <div class="input-box">
                <input type="password" name="password" required>
                <label>New Password</label>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" required>
                <label>Confirm Password</label>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?= $success_message; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
