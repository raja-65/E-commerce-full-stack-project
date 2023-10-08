<?php
session_start();

// Define the admin credentials (replace with actual admin credentials)
$admin_username = 'admin';
$admin_password_hashed = password_hash('rahul', PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST['admin_username'];
    $entered_password = $_POST['admin_password'];

    // Check if entered username matches the admin username
    if ($entered_username === $admin_username) {
        // Verify the entered password against the hashed password
        if (password_verify($entered_password, $admin_password_hashed)) {
            // Authentication successful, set admin session variable
            $_SESSION['admin_id'] = 1; // You can use an admin ID or any other identifier
            header('Location: admin_dashboard.html');
            exit();
        }
    }

    // Authentication failed, redirect back to the login page with an error message
    header('Location: admin_login.php?error=1');
    exit();
} else {
    // Redirect to the admin login page if accessed directly
    header('Location: admin_login.php');
    exit();
}
?>
