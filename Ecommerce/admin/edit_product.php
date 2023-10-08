<?php
// Include database connection code here
include_once "../shared/connection.php";

// Initialize variables to store product details
$productId = "";
$name = "";
$price = "";
$details = "";
$code = "";
$category = "";
$active = "";
$imgpath = "";
$uploaded_by = ""; // Add this line

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Query to retrieve product data by ID
    $sql = "SELECT pid, name, price, details, code, category, imgpath, uploaded_by, active FROM product WHERE pid = $productId";

    // Execute SQL query to fetch product data
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch and store the product details
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $price = $row['price'];
        $details = $row['details'];
        $code = $row['code'];
        $category = $row['category'];
        $active = $row['active'];
        $imgpath = $row['imgpath'];
        $uploaded_by = $row['uploaded_by']; // Add this line
    } else {
        echo "Product not found.";
    }
}

// Check if the form is submitted for updating the product
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $details = $_POST["details"];
    $code = $_POST["code"];
    $category = $_POST["category"];
    $active = $_POST["active"];

   // Handle image upload
   if (isset($_FILES['pdt_img']) && $_FILES['pdt_img']['error'] === 0) {
    $targetDir = "../shared/images/";
    $targetFile = $targetDir . $_FILES['pdt_img']['name'];

    // Check if the file already exists
    if (!file_exists($targetFile)) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['pdt_img']['tmp_name'], $targetFile)) {
            $imgpath = $targetFile; // Use the full path, not just the file name
        } else {
            echo "Error uploading image.";
            }
    } else {
            echo "File already exists.";
        }
    }

    // Update the product's details in the database, including the image path
    $updateSql = "UPDATE product SET name = '$name', price = $price, details = '$details', code = '$code', category = '$category', active = '$active', imgpath = '$imgpath' WHERE pid = $productId";

    if ($conn->query($updateSql) === TRUE) {
        // Product updated successfully, redirect back to product management page
        header("Location: product_management.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!-- Your HTML form for editing products here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
    <form action="edit_product.php?id=<?php echo $productId; ?>" method="post" enctype="multipart/form-data" class="w-50 bg-warning p-5">
        <h3 class="text-center">Edit Product</h3>

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input class="form-control" type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Product Price:</label>
            <input class="form-control" type="text" id="price" name="price" value="<?php echo $price; ?>" required>
        </div>

        <div class="form-group">
            <label for="details">Product Details:</label>
            <textarea class="form-control" id="details" name="details" rows="5" required><?php echo $details; ?></textarea>
        </div>

        <div class="form-group">
            <label for="code">Product Code:</label>
            <input class="form-control" type="text" id="code" name="code" value="<?php echo $code; ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category" required>
                <option <?php if ($category === "Electronics") echo "selected"; ?>>Electronics</option>
                <option <?php if ($category === "Home Appliances") echo "selected"; ?>>Home Appliances</option>
                <option <?php if ($category === "Fashion") echo "selected"; ?>>Fashion</option>
                <option <?php if ($category === "Sports") echo "selected"; ?>>Sports</option>
            </select>
        </div>

        <div class="form-group">
            <label for="active">Active:</label>
            <select class="form-control" id="active" name="active" required>
                <option <?php if ($active === "Yes") echo "selected"; ?>>Yes</option>
                <option <?php if ($active === "No") echo "selected"; ?>>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="uploaded_by">Uploaded By:</label>
            <input class="form-control" type="text" id="uploaded_by" name="uploaded_by" value="<?php echo $uploaded_by; ?>"disabled>
        </div>

        <div class="form-group">
            <label for="pdt_img">Product Image:</label>
            <input type="file" class="form-control mt-2" accept=".jpg,.png,.webp" name="pdt_img">
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-success">Update Product</button>
        </div>
    </form>
</div>

</body>
</html>
