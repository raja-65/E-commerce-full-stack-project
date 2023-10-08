<?php
// Replace 'admin_password_here' with the actual admin password
$admin_password = 'rahul';

// Hash the admin password
$admin_password_hashed = password_hash($admin_password, PASSWORD_DEFAULT);

echo $admin_password_hashed;
?>
