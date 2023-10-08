<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .product-image {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Connect to the database using mysqli
        include "../shared/authguard_vendor.php"; // Authenticate as a vendor
        include "menu.html";
        include "../shared/connection.php";

        // Assuming you have the vendor ID of the currently logged-in vendor
      //$userid=$_SESSION['userid'];
       $vendor_id = $_SESSION['userid']; // Assuming 'user_id' is the vendor's user ID

        // Prepare a SQL statement to select orders for the vendor
        $sql = 'SELECT o.orderid, o.pid, o.address, o.created_date, u.username, p.imgpath 
                FROM orders o
                INNER JOIN product p ON o.pid = p.pid
                INNER JOIN user u ON o.userid = u.userid
                WHERE p.uploaded_by = ?';

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind the vendor ID parameter and execute the statement
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            // Get the result set
            $result = $stmt->get_result();
            // Check if there are any orders
            if ($result->num_rows > 0) {
                // Display the orders in a table
                echo "<table border='1'>";
                echo "<tr><th>Order ID</th><th>Product</th><th>Delivery Address</th><th>Created Date</th><th>Customer Username</th></tr>";
                // Loop through all the orders
                while ($row = $result->fetch_assoc()) {
                    $orderid = $row['orderid'];
                    $pid = $row['pid'];
                    $address = $row['address'];
                    $created_date = $row['created_date'];
                    $imgpath = $row['imgpath'];
                    $customer_username = $row['username'];

                    echo "<tr>";
                    echo "<td>$orderid</td>";
                    echo "<td><img class='product-image' src='$imgpath' alt='Product Image'></td>";
                    echo "<td>$address</td>";
                    echo "<td>$created_date</td>";
                    echo "<td>$customer_username</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // Display a message that there are no orders for this vendor
                echo "<p>You have no orders.</p>";
            }
            // Close the statement
            $stmt->close();
        } else {
            // Show an error message or handle the preparation error
            echo 'View order failed: ' . $conn->error;
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
