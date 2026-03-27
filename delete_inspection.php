<?php
$conn = mysqli_connect('localhost', 'root', '', 'project');
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM inspection_reports WHERE id=$id");

header("Location: view_inspections.php");
exit();
?>