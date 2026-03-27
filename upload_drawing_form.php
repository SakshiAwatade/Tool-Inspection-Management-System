<!DOCTYPE html>
<html>
<head>
    <title>Upload Drawing</title>
</head>
<body>
    <h2>Upload Drawing Image</h2>
    <form action="upload_drawing.php" method="POST" enctype="multipart/form-data">
        <label>Drawing Number:</label><br>
        <input type="text" name="drawing_number" required><br><br>

        <label>Choose Drawing Image:</label><br>
        <input type="file" name="drawing_image" accept="image/*" required><br><br>

        <button type="submit">Upload</button>
    </form>
</body>
</html>