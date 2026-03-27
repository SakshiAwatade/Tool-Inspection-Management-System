<?php
// DB Connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escape & collect header data
    $part = $conn->real_escape_string($_POST['part_description']);
    $gin = $conn->real_escape_string($_POST['gin_no']);
    $date = $_POST['date'];
    $drawing = $conn->real_escape_string($_POST['drawing_number']);
    $supplier = $conn->real_escape_string($_POST['supplier_name']);
    $status = $conn->real_escape_string($_POST['status']);
    $qty = (int)$_POST['quantity'];
    $tool_cat = $conn->real_escape_string($_POST['tool_category']);
    $marking = $conn->real_escape_string($_POST['marking']);
    $remarks = $conn->real_escape_string($_POST['remarks']);

    // Insert into reports table
    $report_sql = "INSERT INTO reports (part_description, gin_no, report_date, drawing_number, supplier_name, status, quantity, tool_category, marking, remarks)
                   VALUES ('$part', '$gin', '$date', '$drawing', '$supplier', '$status', $qty, '$tool_cat', '$marking', '$remarks')";

    if ($conn->query($report_sql) === TRUE) {
        $report_id = $conn->insert_id;

        // Insert measurements
        $desc = $_POST['desc'];
        $specified = $_POST['specified'];
        $actual = $_POST['actual'];

        for ($i = 0; $i < count($desc); $i++) {
            $d = $conn->real_escape_string($desc[$i]);
            $s = $conn->real_escape_string($specified[$i]);
            $a = $conn->real_escape_string($actual[$i]);

            $conn->query("INSERT INTO measurements (report_id, description, specified_size, actual_size)
                          VALUES ($report_id, '$d', '$s', '$a')");
        }

        echo "<script>alert('Report saved successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Error saving report: " . $conn->error;
    }

    $conn->close();
}
?>
