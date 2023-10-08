<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        .container {
            margin: 20px;
        }

        .product-image {
            max-width: 100px; /* Adjust the maximum width as needed */
            max-height: 100px; /* Adjust the maximum height as needed */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Connect to the database using mysqli
        include "../shared/authguard_customer.php";
        include "menu.html";
        include "../shared/connection.php";

        // Prepare a SQL statement to select the orders with product details based on userid
        $sql = 'SELECT o.orderid, o.pid, o.address, o.created_date, p.imgpath 
                FROM orders o
                INNER JOIN product p ON o.pid = p.pid
                WHERE o.userid = ?';

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind the userid parameter and execute the statement
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            // Get the result set
            $result = $stmt->get_result();
            // Check if there are any orders
            if ($result->num_rows > 0) {
                // Display the orders in a table
                echo "<table border='1'>";
                echo "<tr><th>Order ID</th><th>Product</th><th>Address</th><th>Date</th></tr>";
                // Loop through all the orders
                while ($row = $result->fetch_assoc()) {
                    $orderid = $row['orderid'];
                    $pid = $row['pid'];
                    $address = $row['address'];
                    $created_date = $row['created_date'];
                    $imgpath = $row['imgpath'];

                    echo "<tr>";
                    echo "<td>$orderid</td>";
                    echo "<td><img class='product-image' src='$imgpath' alt='Product Image'></td>";
                    echo "<td>$address</td>";
                    echo "<td>$created_date</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // Display a message that there are no orders
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
