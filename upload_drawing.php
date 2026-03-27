<?php
$conn = new mysqli("localhost", "root", "", "project");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drawing_number = $_POST["drawing_number"];
    $filename = $_FILES["drawing_image"]["name"];
    $tempname = $_FILES["drawing_image"]["tmp_name"];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        $stmt = $conn->prepare("INSERT INTO drawing_uploads (drawing_number, drawing_filename) VALUES (?, ?)");
        $stmt->bind_param("ss", $drawing_number, $filename);
        $stmt->execute();
        echo "✅ Drawing uploaded successfully.";
    } else {
        echo "❌ Failed to upload image.";
    }
}
?>