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

    $issueText = $_POST["issue_text"];

    $insertSql = "INSERT INTO product_issues (product_id, user_name, issue_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iss", $productId, $userName, $issueText);

    if ($stmt->execute()) {
        // Issue reported successfully
        // Use JavaScript to redirect to the product details page
        echo "<script>window.location.href='product_details.php?id=$productId';</script>";
        exit();
    } else {
        echo "Error reporting issue: " . $stmt->error;
    }
}

$conn->close();
?>
