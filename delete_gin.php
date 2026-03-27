<?php
$conn = new mysqli("localhost", "root", "", "project");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM GIN_Register WHERE id=$id");
}
header("Location: view_register.php");
?>
