<?php
session_start();
include 'db.php';

// Initialize error message
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            echo 'Session variables are set.';
            session_regenerate_id(true);

            // Check user role and redirect accordingly
            if ($user['role'] === 'admin') {
                header("Location: admin.php"); // Redirect admin to admin panel
            } else {
                header("Location: home.php"); // Redirect other users to home page
            }
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "Email not found. Please register first.";
    }

    session_set_cookie_params([
        'lifetime' => 0,            // Session lasts until browser closes
        'path' => '/',              // Available across the entire domain
        'domain' => '',             // Default to the current domain
        'secure' => true,           // Send cookies only over HTTPS
        'httponly' => true,         // Prevent JavaScript access to session cookie
        'samesite' => 'Strict'      // Prevent cross-site request
    ]);

    $stmt->close();
    $conn->close();
}
?>

<!-- Display error message -->
<?php if (!empty($error_message)): ?>
    <div class="error-message">
        <?= $error_message; ?>
    </div>
<?php endif; ?>
