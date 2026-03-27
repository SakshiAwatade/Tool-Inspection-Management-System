<?php
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$gin_no = $_GET['gin_no'];

$sql = "SELECT drawing_number, tool_category FROM visual_inspection WHERE gin_no = '$gin_no'";
$result = $conn->query($sql);

$response = ['drawing_number' => '', 'tool_category' => ''];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['drawing_number'] = $row['drawing_number'];
    $response['tool_category'] = $row['tool_category'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>