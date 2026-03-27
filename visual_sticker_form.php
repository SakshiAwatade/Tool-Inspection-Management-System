<?php
$conn = new mysqli("localhost", "root", "", "project");

$gin_no = isset($_GET['gin']) ? $_GET['gin'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gin = $_POST['gin_number'];
    $actual = $_POST['actual_size'];
    $mark_tool = $_POST['marking_on_tool'];
    $mark_box = $_POST['marking_on_sticker_box'];
    $remark = $_POST['remark'];
    $other = $_POST['other_remark'];
    $accept = $_POST['accepted_qty'];
    $reject = $_POST['rejected_qty'];
    $autho = $_POST['quality_autho'];

    $sql = "INSERT INTO visual_inspection 
        (gin_number, actual_size, marking_on_tool, marking_on_sticker_box, remark, other_remark, accepted_qty, rejected_qty, quality_autho)
        VALUES 
        ('$gin', '$actual', '$mark_tool', '$mark_box', '$remark', '$other', $accept, $reject, '$autho')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Visual Inspection Saved!'); window.location='view_visual_inspections.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visual Inspection Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        form {
            background: #ffffff;
            max-width: 600px;
            margin: 30px auto;
            padding: 25px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        #other_remark_input {
            display: none;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>

    <script>
    function toggleOtherRemark(select) {
        var otherInput = document.getElementById("other_remark_input");
        otherInput.style.display = (select.value === "Other") ? "block" : "none";
    }
    </script>
</head>
<body>

<h2>📝 Visual Inspection Receipt</h2>

<form method="POST">
    <label>GIN No.:</label>
    <input type="text" name="gin_number" value="<?= htmlspecialchars($gin_no) ?>" readonly>

    <label>Actual Size:</label>
    <input type="text" name="actual_size" required>

    <label>Marking on Tool:</label>
    <input type="text" name="marking_on_tool" required>

    <label>Marking on Sticker/Box:</label>
    <input type="text" name="marking_on_sticker_box" required>

    <label>Remark:</label>
    <select name="remark" onchange="toggleOtherRemark(this)" required>
        <option value="">-- Select Remark --</option>
        <option value="OK">OK</option>
        <option value="Not OK">Not OK</option>
        <option value="Hold">Hold</option>
        <option value="Other">Other</option>
    </select>

    <div id="other_remark_input">
        <label>Other Remark:</label>
        <input type="text" name="other_remark">
    </div>

    <label>Accepted Qty:</label>
    <input type="number" name="accepted_qty" required>

    <label>Rejected Qty:</label>
    <input type="number" name="rejected_qty" required>

    <label>Quality Autho.:</label>
    <input type="text" name="quality_autho" required>

    <button type="submit">✅ Submit Inspection</button>
</form>

</body>
</html>
