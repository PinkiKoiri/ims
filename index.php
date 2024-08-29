<?php
session_start();
require './config/dbcon.php';

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackR - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h2 class="login-title"><i class="fas fa-box-open me-2"></i>TrackR</h2>
            <form action="./views/login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label"><i class="fas fa-user me-2"></i>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>