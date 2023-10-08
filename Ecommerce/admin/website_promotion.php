<!-- platform_management.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Promotion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        ul.menu {
            background-color: #333;
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        ul.menu li {
            display: inline-block;
            margin-right: 10px;
        }

        ul.menu li a {
            text-decoration: none;
            color: #fff;
            padding: 5px 10px;
        }

        ul.menu li a:hover {
            background-color: #555;
        }

        .content {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        </style>
</head>
<body>
    <h1>Website promotion Dashboard</h1>

    <!-- Menu for different management sections -->
    <ul class="menu">
        <li><a href="?section=add_banner">Add Banner</a></li>
        <li><a href="?section=add_promotion">Add Promotion</a></li>
       <li><a href="?section=add_featured_product">Add Featured Product</a></li>
    <!-- Add more menu items as needed -->
    </ul>

    <!-- Content for the selected menu item will be displayed here -->
    <div class="content">
        <?php
        if (isset($_GET['section'])) {
            $section = $_GET['section'];
            switch ($section) {
                case 'add_banner':
                    include 'add_banner.php';
                    break;
                case 'add_promotion':
                    include 'add_promotion.php';
                    break;
                case 'add_featured_product':
                    include 'add_featured_product.php';
                    break;
                // Add more cases for other sections
                default:
                    // Handle invalid section
                    echo 'Invalid section.';
                    break;
            }
        } else {
            echo ' Hey Dear ADMIN welcome proceed with above tools selection for website promotion :) ';
        }
        ?>
    </div>
</body>
</html>