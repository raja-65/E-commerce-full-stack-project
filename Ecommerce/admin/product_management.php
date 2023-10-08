<?php
// Include database connection code here
include_once "../shared/connection.php";

// Query to retrieve product data
$sql = "SELECT pid, name, price, details, category, imgpath, uploaded_by, created_date, code FROM product";

// Execute SQL query to fetch product data
$result = $conn->query($sql);

// Initialize an empty array to store product data
$products = [];

if ($result->num_rows > 0) {
    // Fetch data and store it in the $products array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "No products found.";
}

// Function to delete a product by ID
function deleteProduct($productId) {
    global $conn;
    $deleteSql = "DELETE FROM product WHERE pid = $productId";

    if ($conn->query($deleteSql) === TRUE) {
        // Product deleted successfully
        header("Location: product_management.php"); // Redirect back to product management page
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}

// Check if the action parameter is set in the URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $productId = $_GET['id'];

    if ($action === 'delete') {
        // Call the deleteProduct function to delete the product
        deleteProduct($productId);
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve product details from the form
    $name = $_POST["name"];
    $price = $_POST["price"];
    $details = $_POST["details"];
    $category = $_POST["category"];
    $imgpath= $_POST["imgpath"];
    $uploaded_by = $_POST["uploaded_by"];
    $created_date = $_POST["created_date"];
    $code = $_POST["code"];
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>
    <!-- Display product list and provide options to edit/delete -->
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Details</th>
            <th>Category</th>
            <th>Image</th>
            <th>Uploaded By</th>
            <th>Created Date</th>
            <th>Code</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['pid']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><?php echo $product['details']; ?></td>
                <td><?php echo $product['category']; ?></td>
                <td><img src="<?php echo $product['imgpath']; ?>" alt="<?php echo $product['name']; ?>" width="100"></td>
                <td><?php echo $product['uploaded_by']; ?></td>
                <td><?php echo $product['created_date']; ?></td>
                <td><?php echo $product['code']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['pid']; ?>" class="btn btn-primary">Edit</a> 
                    <a href="product_management.php?action=delete&id=<?php echo $product['pid']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

  <!-- Add New Product Form -->
<div class="d-flex justify-content-center align-items-center" style="margin-top: 50px;">
    <form action="add_product.php" method="post" enctype="multipart/form-data" class="w-50 bg-warning p-5">
        <h3 class="text-center">Add New Product</h3>

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input class="form-control" type="text" id="name" name="name" required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="price">Product Price:</label>
            <input class="form-control" type="text" id="price" name="price"required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="details">Product Details:</label>
            <textarea class="form-control" id="details" name="details" rows="5" required autocomplete="off"></textarea>
        </div>

        <div class="form-group">
            <label for="code">Product Code:</label>
            <input class="form-control" type="text" id="code" name="code" required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category" required >
                <option>Electronics</option>
                <option>Home Appliances</option>
                <option>Fashion</option>
                <option>Sports</option>
            </select>
        </div>

        <div class="form-group">
            <label for="active">Active:</label>
            <select class="form-control" id="active" name="active" required >
                <option>Yes</option>
                <option>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="uploaded_by">Uploaded By:</label>
            <input class="form-control" type="text" id="uploaded_by" name="uploaded_by" required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="pdt_img">Product Image:</label>
            <input type="file" class="form-control mt-2"  accept=".jpg,.png,.webp" name="pdt_img">
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-success">Upload Product</button>
        </div>
    </form>
</div>
</body>
</html>