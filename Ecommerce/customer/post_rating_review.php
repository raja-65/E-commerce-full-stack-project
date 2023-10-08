<?php
include_once "../shared/connection.php";
include "../shared/authguard_customer.php";

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

    $rating = $_POST["rating"];
    $reviewText = $_POST["review_text"];

    // Prepare the SQL statement
    $insertSql = "INSERT INTO product_ratings (product_id, user_name, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);

    // Check for prepared statement preparation errors
    if (!$stmt) {
        die("Prepared statement preparation failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("issi", $productId, $userName, $rating, $reviewText);

    if ($stmt->execute()) {
        // Rating/Review submitted successfully
        header("Location: product_details.php?id=$productId");
        exit();
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
