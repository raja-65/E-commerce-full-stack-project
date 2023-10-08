<?php
// Include database connection code here
include_once "../shared/connection.php";

// Query to retrieve banner data
$sql = "SELECT banner_id, image_path, caption, start_date, end_date FROM banners";

// Execute SQL query to fetch banner data
$result = $conn->query($sql);

// Initialize an empty array to store banner data
$banners = [];

if ($result->num_rows > 0) {
    // Fetch data and store it in the $banners array
    while ($row = $result->fetch_assoc()) {
        $banners[] = $row;
    }
} else {
    echo "No banners found.";
}

// Function to delete a banner by ID
function deleteBanner($bannerId) {
    global $conn;
    $deleteSql = "DELETE FROM banners WHERE banner_id = $bannerId";

    if ($conn->query($deleteSql) === TRUE) {
        // Banner deleted successfully
        header("Location: add_banner.php"); // Redirect back to banner management page
        exit();
    } else {
        echo "Error deleting banner: " . $conn->error;
    }
}

// Check if the action parameter is set in the URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $bannerId = $_GET['id'];

    if ($action === 'delete') {
        // Call the deleteBanner function to delete the banner
        deleteBanner($bannerId);
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve banner details from the form
    $caption = $_POST["banner_caption"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Handle image upload logic here
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../shared/images/";
        $targetFile = $targetDir . basename($_FILES['banner_image']['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile; // Store the full path of the uploaded image
        } else {
            echo "Error uploading image.";
        }
    } else {
        // Handle image upload error
        echo "Error uploading image.";
    }

    // Insert banner details and image path into the database
    $insertSql = "INSERT INTO banners (caption, start_date, end_date, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $caption, $startDate, $endDate, $imagePath);

    if ($stmt->execute()) {
        // Banner data inserted successfully
        header("Location: add_banner.php?success=1");
        exit();
    } else {
        // Handle database insert error
        echo "Error inserting banner data: " . $stmt->error;
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
    <title>Banner Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Display banner list and provide options to edit/delete -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Caption</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $banner) : ?>
                <tr>
                    <td><?php echo $banner['banner_id']; ?></td>
                     <td><img src="<?php echo $banner['image_path']; ?>" alt="Banner Image" width="100"></td>
                   <td><?php echo $banner['caption']; ?></td>
                    <td><?php echo $banner['start_date']; ?></td>
                    <td><?php echo $banner['end_date']; ?></td>
                    <td>
                        <a href="edit_banner.php?id=<?php echo $banner['banner_id']; ?>" class="btn btn-primary">Edit</a> 
                        <a href="add_banner.php?action=delete&id=<?php echo $banner['banner_id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  <div class="container mt-5">
        <h1>Add Banner</h1>
        
        <!-- Form for adding banners -->
        <form action="add_banner.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="banner_image">Banner Image:</label>
                <input type="file" class="form-control-file" name="banner_image" id="banner_image" accept=".jpg,.png,.webp" required>
            </div>
            
            <div class="form-group">
                <label for="banner_caption">Caption:</label>
                <input type="text" class="form-control" name="banner_caption" id="banner_caption" placeholder="Enter caption" required>
            </div>
            
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>
            
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
            </div>
             <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Upload Banner</button>
            </div>
        </form>

    </div>
</body>
</html>
