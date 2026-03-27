<?php 
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM visual_inspection ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Visual Inspection Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .inspect-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .inspect-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>📋 Visual Inspection Records</h2>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>Sr. No</th>
        <th>GIN No</th>
        <th>Actual Size</th>
        <th>Marking on Tool</th>
        <th>Sticker/Box Marking</th>
        <th>Remark</th>
        <th>Other Remark</th>
        <th>Accepted Qty</th>
        <th>Rejected Qty</th>
        <th>Rejected Remark</th>
        <th>Quality Autho.</th>
        <th>Inspection Report</th>



    </tr>
    <?php
    $serial = 1;
    while($row = $result->fetch_assoc()):
        $gin = htmlspecialchars($row['gin_number']);
        $marking = urlencode($row['marking_on_sticker_box']);
        $accepted_qty = urlencode($row['accepted_qty']);

    ?>
    <tr>
        <td><?= $serial++ ?></td>
        <td><?= $gin ?></td>
        <td><?= htmlspecialchars($row['actual_size']) ?></td>
        <td><?= htmlspecialchars($row['marking_on_tool']) ?></td>
        <td><?= htmlspecialchars($row['marking_on_sticker_box']) ?></td>
        <td><?= htmlspecialchars($row['remark']) ?></td>
        <td><?= htmlspecialchars($row['other_remark']) ?></td>
        <td><?= $row['accepted_qty'] ?></td>
        <td><?= $row['rejected_qty'] ?></td>
        <td><?= htmlspecialchars($row['rejected_remark'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['quality_autho']) ?></td>
        <td>
            <form action="index.html" method="get">
                <input type="hidden" name="gin_no" value="<?= $gin ?>">
                <input type="hidden" name="marking" value="<?= $marking ?>">
                <input type="hidden" name="quantity" value="<?= $accepted_qty ?>">
                <button type="submit" class="inspect-btn">ADD</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
    <p style="text-align:center;">No records found.</p>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>
