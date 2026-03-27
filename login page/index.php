<?php 
session_start(); 

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit();
}

// Logout handling
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - GIN System</title>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f0f2f5;
        }

        /* Navigation Bar */
        nav {
            background-color: #007bff;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-title {
            color: white;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .nav-links .username {
            color: white;
            margin-left: 20px;
            font-weight: bold;
        }

        .nav-links .logout {
            background-color: #dc3545;
        }

        /* Page Content */
        .container {
            padding: 40px;
            text-align: center;
        }

        .container h1 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #333;
        }

        .container p {
            font-size: 18px;
            color: #555;
        }

        .button-group {
            margin-top: 40px;
        }

        .button-group a {
            display: inline-block;
            margin: 10px;
            padding: 12px 22px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .button-group a:hover {
            background-color: #0056b3;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            border-radius: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="nav-title">📦 Tool Inspection System</div>
    <div class="nav-links">
    
        <span class="username">👤 <?= $_SESSION['username'] ?></span>
        <a class="logout" href="index.php?logout=1">Logout</a>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1>Welcome to the Tool Inspection Management System</h1>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="button-group">
        <a href="http://localhost/project1/gin_entry_form.php">➕ Enter GIN</a>
        <a href="http://localhost/project1/view_register.php">📋 View GIN Register</a>
        <a href="http://localhost/project1/view_visual_inspections.php">📄 View Inspection Records</a>
        <a href="http://localhost/project1/index.html">Tool Inspection Measurement Report</a>
        <a href="http://localhost/project1/upload_drawing_form.php">Upload Image</a>
    </div>
</div>
</body>
</html>   