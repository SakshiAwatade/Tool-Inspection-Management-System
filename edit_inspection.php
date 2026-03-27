<?php
$conn = mysqli_connect('localhost', 'root', '', 'project');
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spec_value = $_POST['spec_value'];
    $remark = $_POST['remark'];
    $inspector = $_POST['inspector'];

    $update = "UPDATE inspection_reports SET spec_value='$spec_value', remark='$remark', inspector_name='$inspector' WHERE id=$id";
    mysqli_query($conn, $update);

    header("Location: view_inspections.php");
    exit();
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inspection_reports WHERE id=$id"));
?>

<form method="POST">
    <h3>Edit Inspection Report</h3>
    Specification: <?= $data['spec_name'] ?><br><br>
    Value: <input type="text" name="spec_value" value="<?= $data['spec_value'] ?>"><br><br>
    Remark: 
    <select name="remark">
        <option <?= $data['remark']=='OK'?'selected':'' ?>>OK</option>
        <option <?= $data['remark']=='Not OK'?'selected':'' ?>>Not OK</option>
        <option <?= $data['remark']=='Hold'?'selected':'' ?>>Hold</option>
    </select><br><br>
    Inspector: <input type="text" name="inspector" value="<?= $data['inspector_name'] ?>"><br><br>
    <input type="submit" value="Update">
</form>