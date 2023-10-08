<!-- platform_management.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Management</title>
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
    <h1>Platform Management Dashboard</h1>

    <!-- Menu for different management sections -->
    <ul class="menu">
        <li><a href="?section=dashboard">Dashboard</a></li>
        <li><a href="?section=manage_user">Manage User</a></li>
        <li><a href="?section=vendor_management">Vendor Management</a></li>
        <li><a href="?section=product_management">Product Management</a></li>
        <!-- Add more menu items as needed -->
    </ul>

    <!-- Content for the selected menu item will be displayed here -->
    <div class="content">
        <?php
        if (isset($_GET['section'])) {
            $section = $_GET['section'];
            switch ($section) {
                case 'dashboard':
                    include 'dashboard.php';
                    break;
                case 'manage_user':
                    include 'manage_user.php';
                    break;
                case 'vendor_management':
                    include 'vendor_management.php';
                    break;
                case 'product_management':
                    include 'product_management.php';
                    break;
                // Add more cases for other sections
                default:
                    // Handle invalid section
                    echo 'Invalid section.';
                    break;
            }
        } else {
            echo ' Hey Dear ADMIN welcome to platform management :) ';
        }
        ?>
    </div>
</body>
</html>
