<?php
if (isset($_GET['category']) && $_GET['category'] == 1) {
    //fetch result
} else {
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = $_GET['query'];
        // Proceed with fetching products based on the user's query
    } else {
        // Show an error message or redirect to the home page
        echo 'Please enter a valid query.';
        exit();
    }
}
Include "../shared/connection.php";
include "menu.html";
// Prepare a SQL statement that selects the products that match the user input
// Use the MATCH...AGAINST syntax to perform a full-text search
// Use the ORDER BY clause to sort the results by relevance
// Use the LIMIT clause to paginate the results to 10 per page
$sql = 'SELECT * FROM product WHERE MATCH(name, category) AGAINST(? IN NATURAL LANGUAGE MODE) ORDER BY MATCH(name, category) AGAINST(? IN NATURAL LANGUAGE MODE) DESC LIMIT 20';
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind the query parameter and execute the statement
    $stmt->bind_param('ss', $query, $query);
    $stmt->execute();
    // The rest of the code will be written in the next step
} else {
    // Show an error message or handle the preparation error
    echo 'Search failed: ' . $conn->error;
}

// Fetch the result set and display it in an HTML table or a grid format
// Get the result set
$result = $stmt->get_result();
// Check if there are any matching products
if ($result->num_rows > 0) {
    // Start a HTML table to display the search results
    echo '<table>';
    echo '<tr>';
    echo '<th>Image</th>';
    echo '<th>Name</th>';
    echo '<th>Price</th>';
    echo '<th>Category</th>';
    echo '<th>Add to Cart</th>';
    echo '</tr>';
    // Loop through all the matching products
    while ($row = $result->fetch_assoc()) {
        // Get the product id, name, price, category, and image from each row
        $pid = $row['pid'];
        $name = $row['name'];
        $price = $row['price'];
        $category = $row['category'];
        $image = $row['imgpath'];
        // Display each product as a table row
        echo '<tr>';
        echo '<td><img src="' . $image . '" alt="' . $name . '" width="100"  height="100"></td>';
        echo '<td>' . $name . '</td>';
        echo '<td>' . $price . '</td>';
        echo '<td>' . $category . '</td>';
        // Create a form element that sends the product id to addcart.php using the POST/get method
        echo '<td><form action="addcart.php" method="GET">';
        // Create a hidden input element that stores the product id
        echo '<input type="hidden" name="pid" value="' . $pid . '">';
        // Create a submit input element that adds the product to the cart
        echo '<input type="submit" value=":)">';
        echo '</form> </td>';
        echo '</tr>';
    }
    // End the HTML table
    echo '</table>';
} else {
    // Show an error message or inform the user that there are no matching products
    echo 'No products found for your query.';
}
// Close the statement
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <meta charset="utf-8">
 <style>/* Add some style for the table element */
table {
    /* Center the table element */
    margin: 10px auto;
    /* Add some border and spacing */
    border: 1px solid black;
    border-collapse: collapse;
}

/* Add some style for the table cells */
td, th {
    /* Add some padding and border */
    padding: 10px;
    border: 1px solid black;
}

/* Add some style for the table headers */
th {
    /* Change the background color and text color */
    background-color: blue;
    color: white;
}

/* Add some style for the submit input element */
input[type=submit] {
    /* Change the background color and text color */
    background-color: green  ;
    color: white ;
}

 </style>
</head>

<body>
<script>
// Get the table element by its tag name
    var table = document.querySelector("table");
// Add an event listener to the table element that triggers when a cell is clicked
table.addEventListener("click", function(event) {
    // Get the target element of the event
    var target = event.target;
    // Check if the target element is an image element
    if (target.tagName == "IMG") {
        // Get the source attribute of the image element
        var src = target.getAttribute("src");
        // Open a new window that shows the image in full size
        window.open(src);
    }
});
</script>

</body>

</html>