<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Management (Admin)</title>
    
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        h3 {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .welcome {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .error {
            background-color: #ff6961;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .logout {
             text-align: center; 
           background-color: white;
         }

    </style>
</head>
<body>
<div class="container">
<?php
session_start(); // Start the session
include_once "../shared/connection.php";

// Check if the user is logged in as an admin
if (isset($_SESSION['admin_id'])) {
    $adminId = $_SESSION['admin_id'];

    // Retrieve the admin's data from the admin_users table
    $sql = "SELECT admin_id, username FROM admin_users WHERE admin_id = $adminId";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $adminData = $result->fetch_assoc();

        // SQL query to retrieve all vendors
        $vendorSql = "SELECT userid, username FROM user WHERE usertype = 'vendor'";

        // Execute the SQL query to fetch vendor data
        $vendorResult = $conn->query($vendorSql);

        // SQL query to retrieve product listings for all vendors
        $productSql = "SELECT pid, name, price, details, imgpath, uploaded_by FROM product";

        // Execute the SQL query to fetch product data
        $productResult = $conn->query($productSql);

        // SQL query to retrieve all orders
        $orderSql = "SELECT o.orderid, o.userid, o.pid, o.created_date, p.name AS product_name, p.price AS product_price, u.username AS vendor_name
                     FROM orders o
                     JOIN product p ON o.pid = p.pid
                     JOIN user u ON p.uploaded_by = u.userid
                     WHERE u.usertype = 'vendor'";

        // Execute the SQL query to fetch order data
        $orderResult = $conn->query($orderSql);
    } else {
        // Admin not found, deny access
        echo "Access denied. Admin not found.";
        exit(); // Stop further execution
    }
} else {
    // Admin is not logged in, deny access
    echo "Access denied. Admin not logged in.";
    exit(); // Stop further execution
}
?>

       <div class="welcome">
            <h2>Welcome, <?php echo $adminData['username']; ?>!</h2>
            <div class="logout">
                <a href="logout.php">Logout</a>
            </div>
        </div>

    <!-- Display vendor, product, and order information here -->
    
    <h3>All Vendors</h3>
    <?php if ($vendorResult->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Vendor ID</th>
                <th>Vendor Name</th>
            </tr>
            <?php while ($vendor = $vendorResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $vendor['userid']; ?></td>
                    <td><?php echo $vendor['username']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No vendors found.</p>
    <?php endif; ?>

    <h3>All Product Listings</h3>
    <?php if ($productResult->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Details</th>
                <th>Image</th>
                <th>Vendor Name</th>
            </tr>
            <?php while ($product = $productResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['details']; ?></td>
                    <td><img src="<?php echo $product['imgpath']; ?>" alt="<?php echo $product['name']; ?>" width="100"></td>
                    <td><?php echo $product['uploaded_by']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No product listings found.</p>
    <?php endif; ?>

    <h3>All Orders</h3>
    <?php if ($orderResult->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Vendor Name</th>
                <th>Order Date</th>
            </tr>
            <?php while ($order = $orderResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $order['orderid']; ?></td>
                    <td><?php echo $order['userid']; ?></td>
                    <td><?php echo $order['product_name']; ?></td>
                    <td><?php echo $order['product_price']; ?></td>
                    <td><?php echo $order['vendor_name']; ?></td>
                    <td><?php echo $order['created_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No orders found.</p>
    <?php endif; ?>
    </div>
</body>
</html>

