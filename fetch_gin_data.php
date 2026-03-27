<?php
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

if (isset($_GET['gin_no'])) {
    $gin_no = $conn->real_escape_string($_GET['gin_no']);
    $sql = "SELECT * FROM GIN_Register WHERE gin_number = '$gin_no' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'GIN number not found']);
    }
} else {
    echo json_encode(['error' => 'GIN number not provided']);
}
$conn->close();
?>
