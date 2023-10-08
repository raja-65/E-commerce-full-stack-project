<?php
// Include database connection code here
include_once "../shared/connection.php";

// Function to delete a promotion by ID
function deletePromotion($promotionId) {
    global $conn;
    $deleteSql = "DELETE FROM promotions WHERE promotion_id = $promotionId";

    if ($conn->query($deleteSql) === TRUE) {
        // Promotion deleted successfully
        header("Location: add_promotion.php"); // Redirect back to promotion management page
        exit();
    } else {
        echo "Error deleting promotion: " . $conn->error;
    }
}

// Check if the action parameter is set in the URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $promotionId = $_GET['id'];

    if ($action === 'delete') {
        // Call the deletePromotion function to delete the promotion
        deletePromotion($promotionId);
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve promotion details from the form
    $title = $_POST["title"];
    $description = $_POST["description"];
    $discountType = $_POST["discount_type"];
    $discountAmount = $_POST["discount_amount"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $minPurchaseAmount = $_POST["min_purchase_amount"];
    $productCategory = $_POST["product_category"];

    // Insert promotion details into the database
    $insertSql = "INSERT INTO promotions (title, description, discount_type, discount_amount, start_date, end_date, min_purchase_amount, product_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sssdssds", $title, $description, $discountType, $discountAmount, $startDate, $endDate, $minPurchaseAmount, $productCategory);

    if ($stmt->execute()) {
        // Promotion data inserted successfully
        header("Location: add_promotion.php?success=1");
        exit();
    } else {
        // Handle database insert error
        echo "Error inserting promotion data: " . $stmt->error;
    }
}

// Query to retrieve promotion data
$sql = "SELECT promotion_id, title, description, discount_type, discount_amount, start_date, end_date, min_purchase_amount, product_category FROM promotions";

// Execute SQL query to fetch promotion data
$result = $conn->query($sql);

// Initialize an empty array to store promotion data
$promotions = [];

if ($result->num_rows > 0) {
    // Fetch data and store it in the $promotions array
    while ($row = $result->fetch_assoc()) {
        $promotions[] = $row;
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
    <title>Add Promotion</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Promotion</h1>

        <!-- Form for adding promotions -->
        <form action="add_promotion.php" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="discount_type">Discount Type:</label>
                <select class="form-control" name="discount_type" id="discount_type" required>
                    <option value="Percentage">Percentage</option>
                    <option value="Fixed Amount">Fixed Amount</option>
                </select>
            </div>

            <div class="form-group">
                <label for="discount_amount">Discount Amount:</label>
                <input type="number" class="form-control" name="discount_amount" id="discount_amount" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
            </div>

            <div class="form-group">
                <label for="min_purchase_amount">Minimum Purchase Amount (Optional):</label>
                <input type="number" class="form-control" name="min_purchase_amount" id="min_purchase_amount" step="0.01">
            </div>

            <div class="form-group">
                <label for="product_category">Product Category (Optional):</label>
                <input type="text" class="form-control" name="product_category" id="product_category">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Add Promotion</button>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <h2>Existing Promotions</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Discount Type</th>
                    <th>Discount Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Min Purchase Amount</th>
                    <th>Product Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promotion) : ?>
                    <tr>
                        <td><?php echo $promotion['promotion_id']; ?></td>
                        <td><?php echo $promotion['title']; ?></td>
                        <td><?php echo $promotion['description']; ?></td>
                        <td><?php echo $promotion['discount_type']; ?></td>
                        <td><?php echo $promotion['discount_amount']; ?></td>
                        <td><?php echo $promotion['start_date']; ?></td>
                        <td><?php echo $promotion['end_date']; ?></td>
                        <td><?php echo $promotion['min_purchase_amount']; ?></td>
                        <td><?php echo $promotion['product_category']; ?></td>
                        <td>
                            <a href="edit_promotion.php?id=<?php echo $promotion['promotion_id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="add_promotion.php?action=delete&id=<?php echo $promotion['promotion_id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
