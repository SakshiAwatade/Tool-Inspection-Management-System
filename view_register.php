<?php
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$message = '';
$showMessage = false;

// Bulk delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'], $_POST['delete_ids'])) {
    $ids = array_map('intval', $_POST['delete_ids']);
    $idList = implode(',', $ids);
    $sql = "DELETE FROM GIN_Register WHERE id IN ($idList)";
    $showMessage = true;
    $message = $conn->query($sql) ? "✅ Selected records deleted." : "❌ Error: " . $conn->error;
}

// Insert new record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gin_number']) && !isset($_POST['delete_selected'])) { 
    $required = ['gin_number', 'date', 'part_number', 'description', 'quantity', 'transporter_name', 'received_time', 'drawing_number', 'tool_category'];
    foreach ($required as $f)
        if (empty($_POST[$f])) die("Missing field '$f'.");
    $esc = fn($k) => $conn->real_escape_string($_POST[$k]);
    $gin = $esc('gin_number');
    $date = $esc('date');
    $part = $esc('part_number');
    $desc = $esc('description');
    $qty = (int)$_POST['quantity'];
    $trans = $esc('transporter_name');
    $time = $esc('received_time');
    $drawing = $esc('drawing_number');
    $tool = $esc('tool_category');
    $sql = "INSERT INTO GIN_Register (gin_number,date,part_number,description,quantity,transporter_name,received_time,drawing_number,tool_category)
            VALUES ('$gin','$date','$part','$desc',$qty,'$trans','$time','$drawing','$tool')";
    $showMessage = true;
    $message = $conn->query($sql) ? "✅ Record inserted." : "❌ Insert error: " . $conn->error;
}

// Fetch records
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM GIN_Register WHERE gin_number LIKE '%$search%' OR part_number LIKE '%$search%' ORDER BY id ASC";
$result = $conn->query($sql) or die("Query error: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GIN Register</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f7fa; margin: 20px; }
    h2 { text-align: center; color: #333; margin-bottom: 10px; }
    .message {
      background: #e0ffe0;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #b0ffb0;
      border-radius: 4px;
      text-align: center;
    }
    .search-box { display: flex; justify-content: center; margin-bottom: 20px; }
    .search-box input[type=text] { width: 300px; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
    .search-box button { padding: 8px 14px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 8px; }
    .search-box button:hover { background: #0056b3; }
    form, table { margin: 0 auto 20px; max-width: 95%; }
    table { width: 100%; border-collapse: collapse; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: center; }
    th { background: #007bff; color: white; position: sticky; top: 0; }
    tr:hover { background: #f1f1f1; }
    .action-buttons a { padding: 6px 10px; margin: 2px; text-decoration: none; color: white; border-radius: 4px; display: inline-block; font-size: 14px; }
    .action-buttons a.edit    { background: #1ad430ff; color: #000; }
    .action-buttons a.delete  { background: #d62136ff; }
    .action-buttons a.sticker { background: #1a74bdff; color: black; }
    .action-buttons a.inspect { background: #1a74bdff
    ; color: black; } /* Highlight inspection button */
    .action-buttons a.metro   { background: #1a74bdff; } 

    
    .action-buttons a.download{ background: #17a2b8; }
    .action-buttons a:hover { opacity: 0.9; }
  </style>
</head>
<body>
  <h2>🔍 GIN Register</h2>

  <?php if ($showMessage): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <div class="search-box">
    <form method="GET">
      <input type="text" name="search" placeholder="Search GIN or Part No" value="<?= htmlspecialchars($search) ?>">
      <button>Search</button>
    </form>
  </div>

  <form method="POST">
    <div id="deleteSelectedBox" style="text-align:center; margin-bottom:10px; display:none;">
      <button name="delete_selected" onclick="return confirm('Delete selected?')">🗑 Delete Selected</button>
    </div>
    <table>
      <thead>
        <tr>
          <th><input id="selectAll" type="checkbox" onclick="toggleSelectAll(this)"></th>
          <th>Id</th><th>GIN</th><th>Date</th><th>Part No</th><th>Description</th>
          <th>Qty</th><th>Supplier</th><th>Time</th><th>Drawing No</th><th>Tool Category</th>
          <th>Actions</th><th>Sticker</th><th>Inspection</th><th>Metrology</th><th>Download</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><input class="row-checkbox" type="checkbox" name="delete_ids[]" value="<?= $row['id'] ?>" onclick="toggleDeleteButton()"></td>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['gin_number']) ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td><?= htmlspecialchars($row['part_number']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td><?= (int)$row['quantity'] ?></td>
          <td><?= htmlspecialchars($row['transporter_name']) ?></td>
          <td><?= htmlspecialchars($row['received_time']) ?></td>
          <td><?= htmlspecialchars($row['drawing_number']) ?></td>
          <td><?= htmlspecialchars($row['tool_category']) ?></td>
          <td class="action-buttons">
            <a class="edit" href="edit_gin.php?id=<?= $row['id'] ?>">✏ Edit</a>
            <a class="delete" href="delete_gin.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete?')">🗑 Delete</a>
          </td>
          <td class="action-buttons">
            <a class="sticker" href="visual_sticker_form.php?gin=<?= urlencode($row['gin_number']) ?>">🎟 Sticker</a>
          </td>
          <td class="action-buttons">
            <a class="inspect" href="index.html?gin_no=<?= urlencode($row['gin_number']) ?>">🔍 Inspect</a>
          </td>
          <td class="action-buttons">
            <a class="metro" href="gin_entry_form.php?gin=<?= urlencode($row['gin_number']) ?>">🎟 Metrology</a>
          </td>
          <td class="action-buttons">
            <a class="download" href="download_pdf.php?id=<?= $row['id'] ?>">📥 Download</a>
          </td>
        </tr>
        
        
        <?php endwhile; ?>
      </tbody>
    </table>
  </form> 

  <script>
    function toggleSelectAll(src) {
      document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = src.checked);
      toggleDeleteButton();
    }
    function toggleDeleteButton() {
      const btn = document.getElementById('deleteSelectedBox');
      btn.style.display = document.querySelectorAll('.row-checkbox:checked').length ? 'block' : 'none';
    }
  </script>

</body>
</html>
