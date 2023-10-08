<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .submit-button {
            width: 100%;
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="POST" action="admin_authenticate.php">
            <div class="form-group">
                <label for="admin_username">Username:</label>
                <input type="text" id="admin_username" name="admin_username" required>
            </div>
            <div class="form-group">
                <label for="admin_password">Password:</label>
                <input type="password" id="admin_password" name="admin_password" required>
            </div>
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="error-message">Invalid admin credentials.</div>';
            }
            ?>
            <button type="submit" class="submit-button">Login</button>
        </form>
    </div>
</body>
</html>
