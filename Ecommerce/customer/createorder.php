<?php
// Start or resume the user's session
//session_start();
/*
// Check if the user is logged in and get the user's ID (You should implement your authentication logic here)
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    // Redirect the user to a login page or show an error message
    header('Location: login.php'); // Redirect to your login page
    exit();
}
*/
// Get the user's address from the POST request
if (isset($_POST['address']) && !empty($_POST['address'])) {
    $address = $_POST['address'];
} else {
    echo 'Please enter a valid address.';
    exit();
}

// Connect to the database using mysqli or PDO
include "../shared/authguard_customer.php";
Include "menu.html";
include "../shared/connection.php";

// Generate a unique order ID (You can use a different method if needed)
//$orderid = uniqid();

// Prepare a SQL statement to select the cart items
$sql = 'SELECT * FROM cart WHERE userid = ?';
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind the userid parameter and execute the statement
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    // Get the result set
    $result = $stmt->get_result();

    // Prepare another SQL statement to insert each cart item into the order table
    $sql2 = 'INSERT INTO orders(orderid, userid, pid, address, created_date) VALUES (?, ?, ?, ?, ?)';
    $stmt2 = $conn->prepare($sql2);

    if ($stmt2) {
        // Iterate through the cart items and insert them into the order table
        while ($row = $result->fetch_assoc()) {
            $pid = $row['pid'];
            $created_date = date("Y-m-d H:i:s");

            // Bind the parameters and execute the statement for each cart item
            $stmt2->bind_param('siiss', $orderid, $userid, $pid, $address, $created_date);
            $stmt2->execute();
        }

        // Close the second statement
        $stmt2->close();
    } else {
        echo 'Order failed: ' . $conn->error;
    }

    // Delete the cart items based on userid after placing them in order
    // Prepare another SQL statement to delete the cart items
    $sql3 = 'DELETE FROM cart WHERE userid = ?';
    $stmt3 = $conn->prepare($sql3);
    if ($stmt3) {
        // Bind the userid parameter and execute the statement
        $stmt3->bind_param('i', $userid);
        $stmt3->execute();
        // Check if the deletion was successful
        if ($stmt3->affected_rows > 0) {
            echo 'Order placed successfully. Cart cleared.';
        } else {
            echo 'Cart clearing failed: ' . $stmt3->error;
        }
        // Close the third statement
        $stmt3->close();
    } else {
        echo 'Cart clearing failed: ' . $conn->error;
    }

    // Close the first statement
    $stmt->close();
} else {
    echo 'View cart failed: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
