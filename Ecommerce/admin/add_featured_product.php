<?php
// Include database connection code here
include_once "../shared/connection.php";

// Check if the form is submitted for adding a featured product
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Check if the product is not already featured
        $checkSql = "SELECT * FROM featured_products WHERE product_id = $productId";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows == 0) {
            // Product is not featured, so add it
            $insertSql = "INSERT INTO featured_products (product_id) VALUES ($productId)";

            if ($conn->query($insertSql) === TRUE) {
                // Product added as featured successfully
                header("Location: add_featured_product.php");
                exit();
            } else {
                echo "Error adding product as featured: " . $conn->error;
            }
        } else {
            echo "Product is already featured.";
        }
    }
}

// Check if the action parameter is set for removing a featured product
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Remove the product from the featured products list
    $deleteSql = "DELETE FROM featured_products WHERE product_id = $productId";

    if ($conn->query($deleteSql) === TRUE) {
        // Product removed from featured successfully
        header("Location: add_featured_product.php");
        exit();
    } else {
        echo "Error removing product from featured: " . $conn->error;
    }
}

// Retrieve a list of featured products
$featuredProducts = [];
$featuredSql = "SELECT f.product_id, p.name FROM featured_products f
                JOIN product p ON f.product_id = p.pid";
$featuredResult = $conn->query($featuredSql);

if ($featuredResult->num_rows > 0) {
    while ($row = $featuredResult->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}

// Fetch the list of available products from the database
$availableProducts = [];
$availableSql = "SELECT pid, name FROM product";
$availableResult = $conn->query($availableSql);

if ($availableResult->num_rows > 0) {
    while ($row = $availableResult->fetch_assoc()) {
        $availableProducts[] = $row;
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
    <title>Add Featured Product</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Add Featured Product</h1>

    <!-- Form for adding a product as featured -->
    <form action="add_featured_product.php" method="post">
        <label for="product_id">Select a Product:</label>
        <select name="product_id" id="product_id">
            <?php
            // Loop through the available products to populate the dropdown
            foreach ($availableProducts as $product) {
                echo '<option value="' . $product['pid'] . '">' . $product['name'] . '</option>';
            }
            ?>
        </select>
        <button type="submit">Add</button>
    </form>

    <!-- List of featured products -->
    <h2>Featured Products</h2>
    <ul>
        <?php
        foreach ($featuredProducts as $featuredProduct) {
            echo '<li>' . $featuredProduct['name'] . ' - <a href="add_featured_product.php?action=remove&product_id=' . $featuredProduct['product_id'] . '">Remove</a></li>';
        }
        ?>
    </ul>
</body>
</html>
