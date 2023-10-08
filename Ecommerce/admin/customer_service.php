<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <!-- Include CSS and JavaScript libraries as needed -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

 h3, h2 {
    text-align: center;
    margin-bottom: 20px;
      margin-top: 20px;
      background-color: black ; 
                 color: #fff; 
                 padding: 20px; 
}
 .logout {
             text-align: center; 
           background-color: white;
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

                // Modify these SQL queries to retrieve comments, ratings/reviews, and reports data
                $commentsSql = "SELECT comment_id, user_name, comment_text, product_id, comment_date FROM product_comments";
                $commentsResult = $conn->query($commentsSql);

                $ratingsSql = "SELECT user_name, rating, review_text, rating_id, rating_date, product_id FROM product_ratings";
                $ratingsResult = $conn->query($ratingsSql);

                $reportsSql = "SELECT user_name, issue_text,issue_id , issue_date, product_id FROM product_issues";
                $reportsResult = $conn->query($reportsSql);
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

        <!-- Comments Table -->
<h3>Comments</h3>
<?php if ($commentsResult->num_rows > 0) : ?>
    <table>
        <tr>
            <th>Comment ID</th>
             <th>pid</th>
             <th>Comment date</th>
             <th>User</th>
            <th>Comment</th>          
        </tr>
        <?php while ($comment = $commentsResult->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $comment['comment_id']; ?></td>
                  <td><?php echo $comment['product_id']; ?></td>
                    <td><?php echo $comment['comment_date']; ?></td>
                <td><?php echo $comment['user_name']; ?></td>
                <td><?php echo $comment['comment_text']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else : ?>
    <p>No comments found.</p>
<?php endif; ?>


        <!-- Ratings & Reviews Table -->
        <h3>Ratings & Reviews</h3>
        <?php if ($ratingsResult->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>User</th>
                    <th>Rating date</th>
                     <th>Rating id</th>
                      <th>product id</th>
                       <th>Rating</th>
                    <th>Review</th>
                </tr>
                <?php while ($rating = $ratingsResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $rating['user_name']; ?></td>
                        <td><?php echo $rating['rating_date']; ?></td>
                        <td><?php echo $rating['rating_id']; ?></td>
                         <td><?php echo $rating['product_id']; ?></td>
                        <td><?php echo $rating['rating']; ?> stars</td>
                        <td><?php echo $rating['review_text']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>No ratings and reviews found.</p>
        <?php endif; ?>
 
        <!-- Reported Issues Table -->
        <h3>Reported Issues</h3>
        <?php if ($reportsResult->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>User</th>
                    <th>Issue</th>
                      <th>Issue id</th>
                        <th>Issue date</th>
                          <th>PID</th>
                </tr>
                <?php while ($report = $reportsResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $report['user_name']; ?></td>
                        <td><?php echo $report['issue_text']; ?></td>
                        <td><?php echo $report['issue_id']; ?></td>
                        <td><?php echo $report['issue_date']; ?></td>
                        <td><?php echo $report['product_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>No reported issues found.</p>
        <?php endif; ?>

        <!-- Email Notification Logic (Implement separately) -->
    </div>
</body>
</html>
