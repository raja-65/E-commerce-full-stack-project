<?php
// Include necessary files and establish database connection
include_once "../shared/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $details = $_POST["details"];
    $code = $_POST["code"];
    $category = $_POST["category"];
    $active = $_POST["active"];
    $userid = $_POST["uploaded_by"];

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
                exit; // Terminate the script if there's an error
            }
        } else {
            echo "File already exists.";
            exit; // Terminate the script if the file exists
        }
    } else {
        echo "No image uploaded."; // Handle case where no image is uploaded
        exit; // Terminate the script if no image is uploaded
    }

    
$status=mysqli_query($conn,"insert into product(name,price,details,code,category,imgpath,uploaded_by,active) values('$_POST[name]',$_POST[price],'$_POST[details]','$_POST[code]','$_POST[category]','$imgpath',$userid,'$_POST[active]')");


    // Insert the product into the database
    $insertSql = "INSERT INTO product (name, price, details, code, category, imgpath, uploaded_by, active) 
                  VALUES ('$name', $price, '$details', '$code', '$category', '$imgpath', $userid, '$active')";

    if ($conn->query($insertSql) === TRUE) {
        // Product added successfully, redirect to the product management page
        header("Location: product_management.php");
        exit();
    } else {
        echo "Error adding product: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
