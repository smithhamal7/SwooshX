<?php
session_start();
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email from the form
    $email = htmlspecialchars(trim($_POST['email']));

    // Database connection
    include 'db.php';

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists - Generate OTP
        $otp = rand(100000, 999999); // 6-digit OTP
        $_SESSION['otp'] = $otp; // Store OTP in the session
        $_SESSION['otp_expiry'] = time() + 300; // OTP expiry in 5 minutes

        // Send OTP via email
        $mail = new PHPMailer(true);

        try {
            // Email server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'smithhamal001@gmail.com';
            $mail->Password = 'midz euvw rmhj bpcm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // SMTP port (587 for TLS, 465 for SSL)

            // Email content
            $mail->setFrom('smithhamal001@gmail.com', 'Password Reset'); // Sender email and name
            $mail->addAddress($email); // Recipient email
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "
                <h2>Password Reset Request</h2>
                <p>Your OTP code is: <strong>$otp</strong></p>
                <p>This OTP will expire in 5 minutes.</p>
            ";

            $mail->send();

            // Redirect to OTP verification page
            header("Location: verify_otp.php");
            exit(); // Stop further execution after the redirect
        } catch (Exception $e) {
            $error_message = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "The email address is not registered. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div class="form_box">
        <h2>Forgot Password</h2>
        <form action="forget_password.php" method="POST">
            <div class="input-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <button type="submit" class="btn">Send OTP</button>
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
