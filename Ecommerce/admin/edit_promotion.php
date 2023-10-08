<?php
// Include database connection code here
include_once "../shared/connection.php";

// Initialize variables to store promotion details
$promotionId = "";
$title = "";
$description = "";
$discountType = "";
$discountAmount = "";
$startDate = "";
$endDate = "";
$minPurchaseAmount = "";
$productCategory = "";

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $promotionId = $_GET['id'];

    // Query to retrieve promotion data by ID
    $sql = "SELECT promotion_id, title, description, discount_type, discount_amount, start_date, end_date, min_purchase_amount, product_category FROM promotions WHERE promotion_id = $promotionId";

    // Execute SQL query to fetch promotion data
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch and store the promotion details
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $discountType = $row['discount_type'];
        $discountAmount = $row['discount_amount'];
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $minPurchaseAmount = $row['min_purchase_amount'];
        $productCategory = $row['product_category'];
    } else {
        echo "Promotion not found.";
    }
}

// Check if the form is submitted for updating the promotion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $discountType = $_POST["discount_type"];
    $discountAmount = $_POST["discount_amount"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $minPurchaseAmount = $_POST["min_purchase_amount"];
    $productCategory = $_POST["product_category"];

    // Update the promotion's details in the database
    $updateSql = "UPDATE promotions SET title = ?, description = ?, discount_type = ?, discount_amount = ?, start_date = ?, end_date = ?, min_purchase_amount = ?, product_category = ? WHERE promotion_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssdssdsi", $title, $description, $discountType, $discountAmount, $startDate, $endDate, $minPurchaseAmount, $productCategory, $promotionId);

    if ($stmt->execute()) {
        // Promotion updated successfully, redirect back to promotion management page
        header("Location: add_promotion.php");
        exit();
    } else {
        echo "Error updating promotion: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
    <!-- Include CSS and JavaScript libraries as needed -->
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Promotion</h1>

        <!-- Form for editing promotions -->
        <form action="edit_promotion.php?id=<?php echo $promotionId; ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description" rows="4" required><?php echo $description; ?></textarea>
            </div>

            <div class="form-group">
                <label for="discount_type">Discount Type:</label>
                <select class="form-control" name="discount_type" id="discount_type" required>
                    <option value="Percentage" <?php if ($discountType === "Percentage") echo "selected"; ?>>Percentage</option>
                    <option value="Fixed Amount" <?php if ($discountType === "Fixed Amount") echo "selected"; ?>>Fixed Amount</option>
                </select>
            </div>

            <div class="form-group">
                <label for="discount_amount">Discount Amount:</label>
                <input type="number" class="form-control" name="discount_amount" id="discount_amount" step="0.01" value="<?php echo $discountAmount; ?>" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $startDate; ?>" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $endDate; ?>" required>
            </div>

            <div class="form-group">
                <label for="min_purchase_amount">Minimum Purchase Amount (Optional):</label>
                <input type="number" class="form-control" name="min_purchase_amount" id="min_purchase_amount" step="0.01" value="<?php echo $minPurchaseAmount; ?>">
            </div>

            <div class="form-group">
                <label for="product_category">Product Category (Optional):</label>
                <input type="text" class="form-control" name="product_category" id="product_category" value="<?php echo $productCategory; ?>">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Update Promotion</button>
            </div>
        </form>
    </div>
</body>
</html>
