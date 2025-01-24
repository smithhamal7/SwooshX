<?php
session_start();
include 'db.php';

// Initialize variables for error and success messages
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        $error_message = "Email already exists. Please use a different email.";
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Registration successful! Please <a href='login.php'>log in</a>.";
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
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
    <title>SwooshX Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-box register">
    <h2>Registration</h2>

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

    <!-- Registration Form -->
    <form action="registration.php" method="POST">
        <div class="input-box">
            <span class="icon">
                <ion-icon name="person"></ion-icon>
            </span>
            <input type="text" name="username" required>
            <label>Username</label>
        </div>
        <div class="input-box">
            <span class="icon">
                <ion-icon name="mail"></ion-icon>
            </span>
            <input type="email" name="email" required>
            <label>Email</label>
        </div> 
        <div class="input-box">
            <span class="icon">
                <ion-icon name="lock-closed"></ion-icon>
            </span>
            <input type="password" name="password" required>
            <label>Password</label>
        </div>
        <div class="remember-forget">
            <label>
                <input type="checkbox" required>I agree to the terms & conditions
            </label>
        </div>
        <button type="submit" class="btn">Register</button>
        <div class="login-register">
            <p>Already have an Account?<a href="login.html" class="login-link">Login</a></p>
        </div>
    </form>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
