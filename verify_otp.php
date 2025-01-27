<?php
session_start();
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the OTP from the form
    $entered_otp = htmlspecialchars(trim($_POST['otp']));

    // Verify OTP
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $entered_otp) {
        if (time() < $_SESSION['otp_expiry']) {
            $success_message = "OTP verified successfully. You can now reset your password.";
            // Clear OTP from session (optional)
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiry']);
            // Redirect to reset password page (optional)
            header("Location: reset_password.php");
            exit();
        } else {
            $error_message = "OTP has expired. Please request a new OTP.";
        }
    } else {
        $error_message = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div class="form_box">
        <h2>Verify OTP</h2>
        <form action="verify_otp.php" method="POST">
            <div class="input-box">
                <input type="text" name="otp" required>
                <label>Enter OTP</label>
            </div>
            <button type="submit" class="btn">Verify OTP</button>
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
