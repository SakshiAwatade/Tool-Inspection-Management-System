<?php
include 'connection.php';

// 1. AJAX check for GIN availability
if (isset($_POST['check_gin'], $_POST['gin_number'])) {
    $gin = trim($_POST['gin_number']);
    $stmt = $conn->prepare("SELECT 1 FROM GIN_Register WHERE gin_number = ?");
    $stmt->bind_param("s", $gin);
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows ? 'exists' : 'not_exists';
    exit;
}

// 2. Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = [
      'gin_number', 'date', 'part_number', 'description',
      'quantity', 'transporter_name', 'drawing_number', 'tool_category'
    ];
    foreach ($required as $fld) {
        if (empty($_POST[$fld])) {
            die("Form error: Missing field '$fld'.");
        }
    }

    $gin       = trim($_POST['gin_number']);
    $date      = $_POST['date'];
    $part      = trim($_POST['part_number']);
    $desc      = trim($_POST['description']);
    $qty       = intval($_POST['quantity']);
    $trans     = trim($_POST['transporter_name']);
    $drawing   = trim($_POST['drawing_number']);
    $tool      = trim($_POST['tool_category']);

    // Prevent duplicates
    $stmt = $conn->prepare("SELECT 1 FROM GIN_Register WHERE gin_number = ?");
    $stmt->bind_param("s", $gin);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows) {
        echo "<script>alert('⚠️ GIN already exists.'); window.history.back();</script>";
        exit;
    }
    $stmt->close();

    // Insert full record
    $sql = "
      INSERT INTO GIN_Register
        (gin_number, date, part_number, description,
         quantity, transporter_name, drawing_number, tool_category)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind exactly eight params: 4 strings (s), 1 int (i), and 3 strings (s)
    $stmt->bind_param(
      "ssssisss",
      $gin, $date, $part, $desc,
      $qty, $trans, $drawing, $tool
    );
    if ($stmt->execute()) {
        header("Location: view_register.php");
        exit;
    } else {
        die("Insert error: " . $stmt->error);
    }
}
?>
