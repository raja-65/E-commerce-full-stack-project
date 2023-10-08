<?php
// Include necessary files and authenticate the vendor
include "../shared/authguard_vendor.php";
include_once "../shared/connection.php";

// Check if the delete button was clicked and a product ID was sent
if (isset($_POST['delete_product']) && isset($_POST['pid'])) {
    // Sanitize the product ID to prevent SQL injection
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);

    // Perform the product deletion (replace 'product' with your actual table name)
    $sql = "DELETE FROM product WHERE pid = '$pid' AND uploaded_by = '$_SESSION[userid]'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Product deletion was successful
        echo "Product deleted successfully.";
        // Redirect back to the vendor's home page or display a message
        header('Location: home.php');
        exit();
    } else {
        // Product deletion failed
        echo "Product deletion failed: " . mysqli_error($conn);
    }
} else {
    // Delete button not clicked or product ID not provided
    echo "Invalid request.";
}
?>
