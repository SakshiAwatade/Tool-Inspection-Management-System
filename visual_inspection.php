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
        echo "<script>alert('✅ Visual Inspection Saved!'); window.location='view_register.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visual Inspection Receipt</title>
    <script>
    function toggleOtherRemark(select) {
        var otherInput = document.getElementById("other_remark_input");
        if (select.value === "Other") {
            otherInput.style.display = "block";
        } else {
            otherInput.style.display = "none";
        }
    }
    </script>
</head>
<body>

<h2>📝 Visual Inspection Receipt</h2>

<form method="POST">
    GIN No.: <input type="text" name="gin_number" value="<?= htmlspecialchars($gin_no) ?>" readonly><br><br>
    
    Actual Size: <input type="text" name="actual_size" required><br><br>
    
    Marking on Tool: <input type="text" name="marking_on_tool" required><br><br>
    
    Marking on Sticker/Box: <input type="text" name="marking_on_sticker_box" required><br><br>
    
    Remark:
    <select name="remark" onchange="toggleOtherRemark(this)" required>
        <option value="">-- Select Remark --</option>
        <option value="OK">OK</option>
        <option value="Not OK">Not OK</option>
        <option value="Hold">Hold</option>
        <option value="Other">Other</option>
    </select><br><br>

    <div id="other_remark_input" style="display:none;">
        Other Remark: <input type="text" name="other_remark"><br><br>
    </div>

    Accepted Qty: <input type="number" name="accepted_qty" required><br><br>
    
    Rejected Qty: <input type="number" name="rejected_qty" required><br><br>
    
    Quality Autho.: <input type="text" name="quality_autho" required><br><br>

    <button type="submit">✅ Submit Inspection</button>
</form>

</body>
</html>





