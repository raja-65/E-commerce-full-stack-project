<!DOCTYPE html>
<?php
include_once "../shared/connection.php";
include "../shared/authguard_customer.php"; // Assuming this includes your user authentication logic

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST["product_id"];

    // Ensure that a valid username is available after user authentication
    if (isset($_SESSION['username'])) {
        $userName = $_SESSION['username'];
    } else {
        // Handle the case where the user is not authenticated
        // You can redirect them to the login page or take appropriate action
        echo "User not authenticated."; // Modify this message or redirect as needed
        exit();
    }

    $commentText = $_POST["comment_text"];

    $insertSql = "INSERT INTO product_comments (product_id, user_name, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iss", $productId, $userName, $commentText);

    if ($stmt->execute()) {
        // Comment posted successfully
        header("Location: product_details.php");
        exit();
    } else {
        echo "Error posting comment: " . $stmt->error;
    }
}

$conn->close();
?>
