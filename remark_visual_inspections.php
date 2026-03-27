<?php 
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showAlert = false;

// Handle rejected remark submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_remark'])) {
    $inspection_id = $_POST['inspection_id'];
    $rejected_remark = mysqli_real_escape_string($conn, $_POST['rejected_remark']);

    if (!empty($inspection_id)) {
        $update = $conn->query("UPDATE visual_inspection SET rejected_remark = '$rejected_remark' WHERE id = $inspection_id");
        if ($update) {
            $showAlert = true;
        }
    }
}

// ✅ Fetch records with newest at bottom
$sql = "SELECT * FROM visual_inspection WHERE rejected_qty > 0 ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rejected Visual Inspection Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
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
            vertical-align: middle;
        }
        th {
            background-color: rgb(91, 79, 222);
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        textarea {
            width: 100%;
            padding: 6px;
            resize: vertical;
            font-size: 14px;
        }
        .save-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .save-btn:hover {
            background-color: #218838;
        }
        .no-record {
            text-align: center;
            margin-top: 50px;
            color: #777;
        }
    </style>
</head>
<body>

<h2>🚫 Rejected Visual Inspection Records</h2>

<?php if ($showAlert): ?>
    <script>alert("✅ Remark saved successfully!");</script>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>

<table>
    <thead>
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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $serial = 1; while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $serial++ ?></td>
            <td><?= htmlspecialchars($row['gin_number']) ?></td>
            <td><?= htmlspecialchars($row['actual_size']) ?></td>
            <td><?= htmlspecialchars($row['marking_on_tool']) ?></td>
            <td><?= htmlspecialchars($row['marking_on_sticker_box']) ?></td>
            <td><?= htmlspecialchars($row['remark']) ?></td>
            <td><?= htmlspecialchars($row['other_remark']) ?></td>
            <td><?= $row['accepted_qty'] ?></td>
            <td style="color:red; font-weight:bold;"><?= $row['rejected_qty'] ?></td>
            
            <td>
                <form method="POST">
                    <input type="hidden" name="inspection_id" value="<?= $row['id'] ?>">
                    <textarea name="rejected_remark" rows="2"><?= htmlspecialchars($row['rejected_remark'] ?? '') ?></textarea>
            </td>
            <td><?= htmlspecialchars($row['quality_autho']) ?></td>
            <td>
                    <button type="submit" name="save_remark" class="save-btn">💾 Save</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="no-record">No rejected inspection records found.</div>
<?php endif; ?>

<?php $conn->close(); ?>


</body>
</html>

