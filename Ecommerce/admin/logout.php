<?php
// Start the session
session_start();

// Destroy the session and redirect to admin_login.php
session_destroy();
header("Location: admin_login.php");
exit();
?>

