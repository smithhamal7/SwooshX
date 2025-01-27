<?php
session_start();
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get OTP input
    $entered_otp = htmlspecialchars(trim($_POST['otp']));

    // Check if OTP is correct and not expired
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $entered_otp) {
        if (time() < $_SESSION['otp_expiry']) {
            $success_message = "OTP verified successfully. You can now reset your password.";
            // Proceed to reset password page or display reset form
        } else {
            $error_message = "OTP has expired. Please request a new OTP.";
        }
    } else {
        $error_message = "Invalid OTP. Please try again.";
    }
}
?>

<!-- OTP Verification Form -->
<form action="verify_otp.php" method="POST">
    <div class="input-box">
        <input type="text" name="otp" required>
        <label>Enter OTP</label>
    </div>
    <button type="submit" class="btn">Verify OTP</button>
</form>

<!-- Display error or success messages -->
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
