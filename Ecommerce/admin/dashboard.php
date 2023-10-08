<?php
//include_once "../shared/connection.php";
// Replace these with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'webdev';

// Create a database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to count users
$userCountQuery = "SELECT COUNT(*) AS user_count FROM user";
$userCountResult = mysqli_query($connection, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['user_count'];

// Query to count orders
$orderCountQuery = "SELECT COUNT(*) AS order_count FROM orders";
$orderCountResult = mysqli_query($connection, $orderCountQuery);
$orderCount = mysqli_fetch_assoc($orderCountResult)['order_count'];

// Query to count products
$productCountQuery = "SELECT COUNT(*) AS product_count FROM product";
$productCountResult = mysqli_query($connection, $productCountQuery);
$productCount = mysqli_fetch_assoc($productCountResult)['product_count'];

// Close the database connection
mysqli_close($connection);

/*// Display the counts
echo "<h2>Dashboard</h2>";
echo "<p>Total Users: $userCount</p>";
echo "<p>Total Orders: $orderCount</p>";
echo "<p>Total Products: $productCount</p>";*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .dashboard {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }

        .dashboard-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            margin: 10px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="dashboard">
        <div class="dashboard-item">
            <h2>Total Users</h2>
            <p><?php echo $userCount; ?></p>
        </div>
        <div class="dashboard-item">
            <h2>Total Orders</h2>
            <p><?php echo $orderCount; ?></p>
        </div>
        <div class="dashboard-item">
            <h2>Total Products</h2>
            <p><?php echo $productCount; ?></p>
        </div>
    </div>
</body>
</html>
