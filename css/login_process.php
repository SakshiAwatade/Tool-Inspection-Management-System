<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        header('location: dashboard.php');
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header('location: login.php');
    }
}