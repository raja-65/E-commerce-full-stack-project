<?php
// Include database connection code here
include_once "../shared/connection.php";

// Initialize variables to store banner details
$bannerId = "";
$caption = "";
$startDate = "";
$endDate = "";
$imagePath = "";

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $bannerId = $_GET['id'];

    // Query to retrieve banner data by ID
    $sql = "SELECT banner_id, image_path, caption, start_date, end_date FROM banners WHERE banner_id = $bannerId";

    // Execute SQL query to fetch banner data
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch and store the banner details
        $row = $result->fetch_assoc();
        $caption = $row['caption'];
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $imagePath = $row['image_path'];
    } else {
        echo "Banner not found.";
    }
}

// Check if the form is submitted for updating the banner
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $caption = $_POST["caption"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

   // Handle image upload logic here
   if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../shared/images/";
        $targetFile = $targetDir . $_FILES['banner_image']['name'];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile; // Use the full path, not just the file name
        } else {
            echo "Error uploading image.";
        }
    }

    // Update the banner's details and image path in the database
    $updateSql = "UPDATE banners SET image_path = '$imagePath', caption = '$caption', start_date = '$startDate', end_date = '$endDate' WHERE banner_id = $bannerId";

    if ($conn->query($updateSql) === TRUE) {
        // Banner updated successfully, redirect back to banner management page
        header("Location: add_banner.php");
        exit();
    } else {
        echo "Error updating banner: " . $conn->error;
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
    <title>Edit Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
    <form action="edit_banner.php?id=<?php echo $bannerId; ?>" method="post" enctype="multipart/form-data" class="w-50 bg-warning p-5">
        <h3 class="text-center">Edit Banner</h3>

        <div class="form-group">
            <label for="banner_image">Banner Image:</label>
            <input type="file" class="form-control mt-2" name="banner_image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="caption">Caption:</label>
            <input class="form-control" type="text" id="caption" name="caption" value="<?php echo $caption; ?>" required>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input class="form-control" type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input class="form-control" type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>" required>
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-success">Update Banner</button>
        </div>
    </form>
</div>
</body>
</html>
