<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the existing row for editing
$row = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM GIN_Register WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle form submission and update DB
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id        = intval($_POST['id']);
    $gin       = trim($_POST['gin_number'] ?? '');
    $date      = $_POST['date'] ?? '';
    $part      = trim($_POST['part_number'] ?? '');
    $desc      = trim($_POST['description'] ?? '');
    $qty       = intval($_POST['quantity'] ?? 0);
    $drawing   = trim($_POST['drawing_number'] ?? '');
    $toolCat   = trim($_POST['tool_category'] ?? '');

    $stmt = $conn->prepare("
        UPDATE GIN_Register SET
            gin_number     = ?,
            date           = ?,
            part_number    = ?,
            description    = ?,
            quantity       = ?,
            drawing_number = ?,
            tool_category  = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssissi",  // s=gin, s=date, s=part, s=desc, i=qty, s=drawing, s=toolCat, i=id
        $gin,
        $date,
        $part,
        $desc,
        $qty,
        $drawing,
        $toolCat,
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: view_register.php");
        exit;
    } else {
        echo "<p style='color:red'>Error updating record: " . htmlspecialchars($conn->error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit GIN Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus {
            border-color: #66afe9;
            outline: none;
        }

        button[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3486c9ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: orange;
        }
    </style>
</head>
<body>

<h2>Edit GIN Entry</h2>

<?php if ($row): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

        <label for="gin_number">GIN Number:</label>
        <input type="text" id="gin_number" name="gin_number" value="<?= htmlspecialchars($row['gin_number']) ?>" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($row['date']) ?>" required>

        <label for="part_number">Part Number:</label>
        <input type="text" id="part_number" name="part_number" value="<?= htmlspecialchars($row['part_number']) ?>" required>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?= htmlspecialchars($row['description']) ?>">

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" min="0">

        <label for="drawing_number">Drawing Number:</label>
        <input type="text" id="drawing_number" name="drawing_number" value="<?= htmlspecialchars($row['drawing_number'] ?? '') ?>">

        <label for="tool_category">Tool Category:</label>
        <input type="text" id="tool_category" name="tool_category" value="<?= htmlspecialchars($row['tool_category'] ?? '') ?>">

        <button type="submit">Update</button>
    </form>
<?php else: ?>
    <p class="message">No record found with that ID.</p>
<?php endif; ?>

</body>
</html>
