<?php
if (!isset($_GET['drawing_number'])) {
    echo "No drawing number provided.";
    exit;
}

$drawing_number = $_GET['drawing_number'];

$conn = new mysqli("localhost", "root", "", "project");

$query = "SELECT drawing_filename FROM drawing_uploads WHERE drawing_number = '$drawing_number'";
$result = $conn->query($query);

if ($row = $result->fetch_assoc()) {
    $filename = $row['drawing_filename'];
    $filepath = "uploads/" . $filename;

    if (file_exists($filepath)) {
        echo "<img src='$filepath' alt='Drawing Image'>";
    } else {
        echo "Drawing Image Not Found";
    }
} else {
    echo "Drawing not found in database.";
}
?>