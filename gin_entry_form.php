<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>GIN Entry Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f8fa;
      margin: 0;
      padding: 2rem;
    }

    .container {
      max-width: 500px;
      margin: 0 auto;
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: bold;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 1rem;
    }

    .form-group input:focus {
      border-color: #007BFF;
      outline: none;
      box-shadow: 0 0 3px rgba(0,123,255,0.5);
    }

    .tooltip {
      display: none;
      color: red;
      font-size: 0.9rem;
      margin-top: 0.3rem;
    }

    button {
      width: 100%;
      padding: 0.7rem;
      background-color: #007BFF;
      color: #fff;
      font-size: 1.1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 1rem;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
  <script>
    function checkGINAvailability() {
      const ginNumber = document.getElementById('gin_number').value;
      const tooltip = document.getElementById('gin-tooltip');

      if (ginNumber.trim() === '') {
        tooltip.style.display = 'none';
        return;
      }

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "register_gin.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onload = function () {
        if (xhr.status === 200) {
          if (xhr.responseText === 'exists') {
            tooltip.textContent = 'GIN Entry is Available';
            tooltip.style.display = 'block';
          } else {
            tooltip.style.display = 'none';
          }
        }
      };

      xhr.send("check_gin=1&gin_number=" + encodeURIComponent(ginNumber));
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Enter GIN Details</h2>
    <form action="register_gin.php" method="POST">
      <div class="form-group">
        <label for="gin_number">GIN Number:</label>
        <input id="gin_number" type="text" name="gin_number" onblur="checkGINAvailability()" required>
        <div id="gin-tooltip" class="tooltip"></div>
      </div>
      <div class="form-group">
        <label for="date">Date:</label>
        <input id="date" type="date" name="date" required>
      </div>
      <div class="form-group">
        <label for="part_number">Part Number:</label>
        <input id="part_number" type="text" name="part_number" required>
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <input id="description" type="text" name="description" required>
      </div>
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input id="quantity" type="number" name="quantity" required>
      </div>
      <div class="form-group">
        <label for="transporter_name">Supplier Name:</label>
        <input id="transporter_name" type="text" name="transporter_name" required>
      </div>
    <div class="form-group">
        <label for="drawing_number">Drawing Number:</label>
        <input id="drawing_number" type="text" name="drawing_number" required>
      </div>
      <div class="form-group">
        <label for="tool_category">Tool Category:</label>
        <input id="tool_category" type="text" name="tool_category" required>
      </div>
    
    
      <button type="submit">Save Entry</button>
    </form>
  </div>
</body>
</html>
