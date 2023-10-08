<?php
include_once "../shared/connection.php";

// Define the cipher_text column name based on your database schema
$cipher_text_column = "password"; 

// Check if the form is submitted for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["username"];
    $newPassword = $_POST["password"];
    $newUserType = $_POST["usertype"];

    // Write an SQL query to insert a new user
    $insertSql = "INSERT INTO user (username, $cipher_text_column, usertype) VALUES ('$newUsername', '$newPassword', '$newUserType')"; // Replace $cipher_text with $newPassword

    if ($conn->query($insertSql) === TRUE) {
        // New user added successfully, redirect to user management page
        header("Location:manage_user.php");
        exit();
    } else {
        echo "Error adding user: " . $conn->error;
    }
}


// Check if the action parameter is set in the URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $userId = $_GET['id'];

    if ($action === 'delete') {
        // Write an SQL query to delete the user by ID
        $deleteSql = "DELETE FROM user WHERE userid = $userId";

        if ($conn->query($deleteSql) === TRUE) {
            // User deleted successfully, you can redirect to the user management page
            header("Location:manage_user.php");
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    }
}

// Write an SQL query to fetch user data
$sql = "SELECT userid, username, $cipher_text_column, usertype, created_date FROM user"; 

// Execute the SQL query
$result = $conn->query($sql);

// Initialize an empty array to store user data
$users = [];

if ($result->num_rows > 0) {
    // Fetch data and store it in the $users array
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "No users found.";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
            padding: 20px 0;
            text-align: center;
        }

        h3 {
            margin-top: 20px;
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

        input[type="text"],
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-links a {
            text-decoration: none;
            color: #333;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>User Management</h2>

    <!-- Add New User Form -->
    <h3>Add New User</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <label for="usertype">User Type:</label>
        <input type="text" name="usertype" required><br><br>
        <input type="submit" value="Add User">
    </form>

    <?php if (!empty($users)) : ?>
        <h3>Existing Users</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['userid']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['usertype']; ?></td>
                    <td><?php echo $user['created_date']; ?></td>
                    <td class="action-links">
                        <a href="edit_user.php?id=<?php echo $user['userid']; ?>">Edit</a>
                        <a href="manage_user.php?action=delete&id=<?php echo $user['userid']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No users found.</p>
    <?php endif; ?>
</body>
</html>
