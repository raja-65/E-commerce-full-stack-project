<!DOCTYPE html>
<?php
include_once "../shared/connection.php";
include "../shared/authguard_customer.php";

// Retrieve the product details using a parameter, e.g., product ID
if (isset($_GET['pid'])) {
    $productId = $_GET['pid'];

    // Prepare the SQL statement with a placeholder
    $sql = "SELECT * FROM product WHERE pid = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameter and execute the query
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $product = $result->fetch_assoc();
        } else {
            // Handle product not found error
            echo "Product not found.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        echo "Error preparing the SQL statement.";
    }
} else {
    // Handle missing product ID error
    echo "Product ID is missing.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
            .product-header {
                 background-color: black ; /* Header background color */
                 color: #fff; 
                 text-align: center; 
                 padding: 20px; 
                }

           .button {
            display: inline-flex;
            align-items: center ;
            justify-content: center ;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: black ;
            color: white;
           
        }

        /* Style for social media logos */
        .social-logo {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        /* Additional styles for better alignment */
        .social-buttons {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        /* Basic styling for the product container */
        .product-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Styling for the product image */
        .product-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        /* Styling for product details */
        .product-details {
            font-size: 18px;
        }

        /* Styling for product price */
        .product-price {
            font-weight: bold;
            color: #333;
            font-size: 24px;
        }

        /* Styling for product description */
        .product-description {
            margin-top: 20px;
        }

        /* Styling for the add to cart button */
        .add-to-cart-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Styling for the add to cart button on hover */
        .add-to-cart-button:hover {
            background-color: #0056b3;
        }
      /* CSS for Similar Product Cards */
.similar-pdt-card {
    width: 200px; /* Set the width of each similar product card */
    padding: 10px;
    margin: 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    text-align: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
/* Style for the container of similar products */
.similar-products-container {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap to the next row */
    justify-content: space-between; /* Distribute items evenly and leave space in between */
}
.similar-pdt-card img {
    max-width: 100%;
    height: auto;
    margin: 10px 0;
}

/* CSS for Similar Products Container */
.similar-products-container {
    display: flex;
    justify-content: center; /* Center-align the content horizontally */
    align-items: center; /* Center-align the content vertically */
    flex-wrap: wrap;
    margin: 20px 0;
}

/* Additional styles for the similar products section */
.similar-products h2 {
    text-align: center;
    margin-bottom: 20px;
      margin-top: 20px;
      background-color: black ; 
                 color: #fff; 
                 padding: 20px; 
}

.comments h3 {
    text-align: center;
    margin-bottom: 20px;
     margin-top: 20px;
      background-color: black ; 
                 color: #fff; 
                 padding: 20px; 
}
.ratings-reviews h3 {
    text-align: center;
    margin-bottom: 20px;
      margin-top: 20px;
      background-color: black ; 
                 color: #fff; 
                 padding: 20px; 
}
.issue-reporting h3 {
    text-align: center;
    margin-bottom: 20px;
      margin-top: 20px;
      background-color: black ; 
                 color: #fff; 
                 padding: 20px; 
}

/* CSS for the table */
table {
    width: 100%;
    border-collapse: collapse;
}
    </style>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>
    <header class="product-header">
        <h1>Welcome to the Product Page</h1>
    </header>
    <!-- Product Container -->
    <div class="product-container">
        <!-- Product Image -->
        <img class="product-image" src="<?php echo $product['imgpath']; ?>" alt="<?php echo $product['name']; ?>">

        <!-- Product Details -->
        <div class="product-details">
            <div class="product-name"><?php echo $product['name']; ?></div>
            <div class="product-price">$<?php echo $product['price']; ?></div>
            <div class="product-code">Product Code: <?php echo $product['code']; ?></div>
           <div class='category'>category: <?php echo $product['category']; ?></div>
        </div>

        <!-- Product Description -->
        <div class="product-description">
            <h2>Description</h2>
            <p><?php echo $product['details']; ?></p>
       </div>
        <!-- Add to Cart Button -->
        <div class="add-to-cart">
        <a href='addcart.php?pid=<?php echo $product['pid']; ?>'>
            <button class="add-to-cart-button">Add to Cart</button>
        </a>
        </div>
    
 <!-- Social Media Sharing Buttons -->
 <div class="social-buttons">
        <button class="button" onclick="shareOnFacebook()">
            <img src="facebook-logo-icon-png_241252.jpg" alt="Facebook Logo" class="social-logo">
            Share on Facebook
        </button>
        <button class="button" onclick="shareOnTwitter()">
            <img src="png-clipart-twitter-twitter-thumbnail.png" alt="Twitter Logo" class="social-logo">
            Share on Twitter
        </button>
        <button class="button" onclick="shareOnWhatsApp()">
            <img src="png-transparent-whatsapp-logo-whatsapp-logo-whatsapp-text-trademark-logo-thumbnail.png" alt="WhatsApp Logo" class="social-logo">
            Share on WhatsApp
        </button>
        <button class="button" onclick="shareOnGmail()">
            <img src="pngtree-gmail-logo-png-image_282635.jpg" alt="Gmail Logo" class="social-logo">
            Share on Gmail
        </button>
        <button class="button" onclick="shareOnTelegram()">
            <img src="png-transparent-telegram-logo-computer-icons-telegram-logo-blue-angle-triangle-thumbnail.png" alt="Telegram Logo" class="social-logo">
            Share on Telegram
        </button>
    </div>

    <script>
        // JavaScript functions for sharing on social media platforms
        function shareOnFacebook() {
            // Replace the URL and title with your product's details
            var url = encodeURIComponent('https://your-website.com/product_details.php?id=<?php echo $product['pid']; ?>');
            var title = encodeURIComponent('<?php echo $product['name']; ?>');
            var facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url + '&t=' + title;
            window.open(facebookShareUrl, 'Share on Facebook', 'width=600,height=400');
        }

        function shareOnTwitter() {
            // Replace the URL and text with your product's details
            var url = encodeURIComponent('https://your-website.com/product_details.php?id=<?php echo $product['pid']; ?>');
            var text = encodeURIComponent('Check out this amazing product: <?php echo $product['name']; ?>');
            var twitterShareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + text;
            window.open(twitterShareUrl, 'Share on Twitter', 'width=600,height=400');
        }

        function shareOnWhatsApp() {
            // Replace the message and product's URL with your details
            var text = encodeURIComponent('Check out this amazing product: <?php echo $product['name']; ?>\n');
            var url = encodeURIComponent('https://your-website.com/product_details.php?id=<?php echo $product['pid']; ?>');
            var whatsappShareUrl = 'https://api.whatsapp.com/send?text=' + text + url;
            window.open(whatsappShareUrl, 'Share on WhatsApp');
        }

        function shareOnGmail() {
            // Replace the subject, body, and product's URL with your details
            var subject = encodeURIComponent('Check out this amazing product: <?php echo $product['name']; ?>');
            var body = encodeURIComponent('Check out this amazing product: <?php echo $product['name']; ?>\n\nProduct URL: https://your-website.com/product_details.php?id=<?php echo $product['pid']; ?>');
            var gmailShareUrl = 'https://mail.google.com/mail/?view=cm&su=' + subject + '&body=' + body;
            window.open(gmailShareUrl, 'Share on Gmail', 'width=600,height=400');
        }

        function shareOnTelegram() {
            // Replace the text and product's URL with your details
            var text = encodeURIComponent('Check out this amazing product: <?php echo $product['name']; ?>\n');
            var url = encodeURIComponent('https://your-website.com/product_details.php?id=<?php echo $product['pid']; ?>');
            var telegramShareUrl = 'https://t.me/share/url?url=' + url + '&text=' + text;
            window.open(telegramShareUrl, 'Share on Telegram', 'width=600,height=400');
        }
    </script>
    </div>
    <!-- User Interaction Section -->
 <div class="user-interaction-section">
    <!-- Comment Section -->
    <div class="comments">
        <h3>Comments</h3>
        <!-- Display existing comments from the database -->
        <?php
        $commentsSql = "SELECT * FROM product_comments WHERE product_id = $productId";
        $commentsResult = $conn->query($commentsSql);

        if ($commentsResult->num_rows > 0) {
            while ($commentRow = $commentsResult->fetch_assoc()) {
                echo "<div class='comment'>
                        <span class='comment-user'>$commentRow[user_name]:</span>
                        <span class='comment-text'>$commentRow[comment_text]</span>
                      </div>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        ?>
        <!-- Comment Form -->
        <form action="post_comment.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['pid']; ?>">
            <label for="comment_text">Add a Comment:</label>
            <textarea name="comment_text" id="comment_text" rows="3" required></textarea>
            <button type="submit">Post Comment</button>
        </form>
    </div>

    <!-- Rating and Review Section -->
    <div class="ratings-reviews">
        <h3>Rating & Review</h3>
        <!-- Display existing ratings and reviews from the database -->
        <?php
        $ratingsSql = "SELECT * FROM product_ratings WHERE product_id = $productId";
        $ratingsResult = $conn->query($ratingsSql);

        if ($ratingsResult->num_rows > 0) {
            while ($ratingRow = $ratingsResult->fetch_assoc()) {
                echo "<div class='rating'>
                        <span class='rating-user'>$ratingRow[user_name] rated it $ratingRow[rating] stars:</span>
                        <span class='rating-text'>$ratingRow[review_text]</span>
                      </div>";
            }
        } else {
            echo "<p>No ratings and reviews yet.</p>";
        }
        ?>
        <!-- Rating and Review Form -->
        <form action="post_rating_review.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['pid']; ?>">
            <label for="rating">Rate this Product (1-5):</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>
            <label for="review_text">Add a Review:</label>
            <textarea name="review_text" id="review_text" rows="3"></textarea>
            <button type="submit">Submit Rating/Review</button>
        </form>
    </div>

    <!-- Issue Reporting Section -->
    <div class="issue-reporting">
        <h3>Report an Issue</h3>
        <form action="report_issue.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['pid']; ?>">
            <label for="issue_text">Report an Issue:</label>
            <textarea name="issue_text" id="issue_text" rows="3" required></textarea>
            <button type="submit">Report Issue</button>
        </form>
    </div>
 </div>

<!-- Section for Similar Products -->
<div class="similar-products">
    <h2>Similar Products</h2>
    <div class="similar-products-container">
        <table>
            <tr>
                <?php
                // Query to retrieve similar products from the same category
                $category = $product['category'];
                $similarSql = "SELECT * FROM product WHERE category = '$category' AND pid != $productId LIMIT 5";
                $similarResult = $conn->query($similarSql);

                if ($similarResult->num_rows > 0) {
                    while ($similarRow = $similarResult->fetch_assoc()) {
                        echo "<div class='similar-pdt-card'>
                                    <div class='name'>$similarRow[name]</div>
                                    <div class='price'>$similarRow[price]</div>    
                                    <div class='code'>$similarRow[code]</div>            
                                    <a href='product_detail.php?pid=$similarRow[pid]'>
                                        <img class='similar-pdt-img' src='$similarRow[imgpath]'>   
                                    </a>
                                    <div class='category'>$similarRow[category]</div>                                 
                                    <div class='details'>$similarRow[details]</div>
                                    <hr>
                                    <div class='text center'>
                                        <a href='addcart.php?pid=$similarRow[pid]'>
                                            <button class='add-to-cart-button'>Add to Cart</button>
                                        </a>
                                    </div>
                                </div>";
                    }
                } else {
                    echo "No similar products found.";
                }
                ?>
          <div class="load-more">
    <form action="search.php" method="get">
         <input name="query" type="hidden" name="category" value="<?php echo htmlspecialchars($product['category']); ?>">
        <input type="submit" value="Load More">
    </form>
</div>
</tr>
        </table>
    </div>
</div>
</body>
</html>