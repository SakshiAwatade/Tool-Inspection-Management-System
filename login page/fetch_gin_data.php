<?php
// fetch_gin_data.php

$conn = new mysqli("localhost", "root", "", "project");

// Check if gin_no is set
if (!isset($_GET['gin_no'])) {
    echo json_encode(["error" => "GIN No is missing"]);
    exit;
}

$gin_no = $conn->real_escape_string($_GET['gin_no']);

$query = "SELECT * FROM visual_inspection WHERE gin_no = '$gin_no'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "description" => $row['description'],
        "transporter_name" => $row['transporter_name'],
        "date" => $row['date'],
        "drawing_number" => $row['drawing_number'],
        "tool_category" => $row['tool_category'],
        "quantity" => $row['quantity'],
        "drawing_path" => $row['drawing_path']
    ]);
} else {
    echo json_encode(["error" => "No data found for GIN No: $gin_no"]);
}
?>