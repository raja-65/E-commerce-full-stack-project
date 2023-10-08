<?php
// Include database connection code here
include_once "../shared/connection.php";

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data by ID
    $sql = "SELECT userid, username FROM user WHERE userid = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if the form is submitted for updating the password
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPassword = $_POST["password"];
            // Update the user's password in the database
            $updateSql = "UPDATE user SET password = '$newPassword' WHERE userid = $userId";

            if ($conn->query($updateSql) === TRUE) {
                // Password updated successfully, redirect back to user management page
                header("Location:manage_user.php");
                exit();
            } else {
                echo "Error updating password: " . $conn->error;
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>

    <?php if (isset($user)) : ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $user['userid']); ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Update Password">
        </form>
    <?php else : ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>
