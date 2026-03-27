<?php
$conn = mysqli_connect("localhost", "root", "", "project");

$category_id = $_GET['category_id'];

$query = "SELECT spec_name FROM specifications WHERE category_id = $category_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h3>Enter Measured Values:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['spec_name'] . ": <input type='text' name='actual_specs[" . $row['spec_name'] . "]' required><br><br>";
    }
} else {
    echo "<b>No specifications available for selected category.</b>";
}
?>