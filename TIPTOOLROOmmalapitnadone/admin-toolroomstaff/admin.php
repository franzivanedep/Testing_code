<!DOCTYPE html>
<html>
<head>
  <title>Ecommerce Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Your CSS styles go here */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0; /* Background color for the entire page */
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      background-color: #222;
      color: #fff;
      padding: 20px;
      width: 250px;
      height: 100vh;
      position: fixed;
      z-index: 1;
      overflow-y: auto;
      transition: width 0.3s ease;
    }

    .sidebar:hover {
      width: 300px;
    }

    .sidebar h2 {
      color: #fff;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 2px;
      margin-bottom: 10px;
    }

    .sidebar p {
      color: #ccc;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .sidebar li {
      margin-bottom: 10px;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      transition: color 0.3s ease;
      padding: 10px 15px;
      border-radius: 5px;
    }

    .sidebar a i {
      margin-right: 10px;
    }

    .sidebar a:hover {
      color: #fff;
      background-color: #555;
    }

    .content {
      flex-grow: 1;
      padding: 20px;
      margin-left: 250px;
    }

    .content header {
      margin-bottom: 20px;
    }

    .content h1 {
      font-size: 32px;
      color: #333;
      margin-bottom: 10px;
    }

    .main-content {
      background-color: #fff; /* Background color for the main content */
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for the main content */
    }

    .main-content h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .main-content p {
      color: #666;
      line-height: 1.6;
    }

    /* Media Queries for Responsive Design */
    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
        position: static;
        margin-bottom: 20px;
        overflow-y: visible;
      }

      .content {
        margin-left: 0;
      }
    }

    /* Additional styles for the table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #555;
      color: #fff;
    }

    /* Styles for form elements */
    label {
      display: block;
      font-weight: bold;
      margin-top: 10px;
    }

    input[type="text"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    button[type="submit"] {
      background-color: #555;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #333;
    }

    /* Style for the custom file upload button */
    .custom-file-upload {
      display: inline-block;
      padding: 10px 15px;
      background-color: #555;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .custom-file-upload:hover {
      background-color: #333;
    }

    /* Style for the selected file name */
    #selected-file {
      display: inline-block;
      margin-left: 10px;
      color: #333;
    }

    /* Style for the file input's label (hidden) */
    #item_image {
      display: none;
    }
    /* Style for the category dropdown */
select#category {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
  color: #333; /* Text color */
  cursor: pointer;
}

/* Style for the selected option */
select#category option {
  background-color: #fff;
  color: #333; /* Text color */
}

  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Tip Toom Room</h2>
      <ul>
        <li><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="#"><i class="fas fa-toolbox"></i> Items</a></li>
        <li><a href="admin_transac.php"><i class="fas fa-clipboard-list"></i> Request</a></li>
        <li><a href="#"><i class="fas fa-users"></i> Students</a></li>
        <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
      </ul>
    </div>
    <div class="content">
      <header>
        <h1>Welcome to the Admin Panel</h1>
      </header>
      <div class="main-content">
        <h2>Items</h2>

        <!-- Item List -->
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Category</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Database configuration
              $servername = "localhost:3307";
              $username = "root";
              $db_password = ""; // Replace with your actual MySQL password
              $dbname = "tiptoolroom_db";


              // Create a database connection
              $conn = new mysqli($servername, $username, $password, $dbname);

              // Check the connection
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              // Fetch items from the database
              $sql = "SELECT * FROM items";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id_num"] . "</td>";
                  echo "<td>" . $row["name"] . "</td>";
                  echo "<td>" . $row["description"] . "</td>";
                  echo "<td>" . $row["quantity"] . "</td>";
                  echo "<td>" . $row["category"] . "</td>";
                  echo "<td><a href='/TIPTOOLROOmmalapitnadone/student/PHP/delete_item.php?id=" . $row["id_num"] . "' onclick=\"return confirm('Are you sure you want to delete this item?')\">Delete</a></td>";
                  echo "</tr>";
              }
              
              } else {
                echo "<tr><td colspan='6'>No items found.</td></tr>";
              }

              // Close the database connection
              $conn->close();
            ?>
          </tbody>
        </table>

        <!-- Add Item Form -->
      <!-- Add Item Form -->
<h3>Add Item</h3>
<form action="/TIPTOOLROOmmalapitnadone/student/PHP/add_item.php" method="POST" enctype="multipart/form-data">
  <!-- Remove the duplicate label for file input -->
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br>

  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea><br>

  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" required><br>

  <!-- Replace the input for Category with a dropdown menu -->
  <label for="category">Category:</label>
  <select id="category" name="category" required>
  <option value="Computer Equipments">Computer Equipments</option>
  <option value="Electrical Equipments">Electrical Equipments</option>
  <option value="Hand Tools">Hand Tools</option>
    <!-- Add more options based on your categories -->
  </select><br>

  <!-- Use the custom button for the file input -->
  <label for="images" class="custom-file-upload">
    <i class="fas fa-cloud-upload-alt"></i> Choose File
  </label>
  <input type="file" id="images" name="images" accept="image/*" required style="display: none;">
  <span id="selected-file">No file selected</span><br>

  <!-- Add input for the ID -->
  <label for="id_num">Item ID:</label>
  <input type="text" id="id_num" name="id_num" required><br>

  <button type="submit" name="submit">Add Item</button>
</form>

<style>
  /* CSS to hide the file input without the custom style */
  input[type="file"]:not(.custom-file-upload) {
    display: none;
  }
</style>


      </div>
    </div>
  </div>

  <script>
    // JavaScript to display the selected file name
    document.getElementById("images").addEventListener("change", function () {
      const selectedFile = this.files[0];
      if (selectedFile) {
        document.getElementById("selected-file").textContent = selectedFile.name;
      } else {
        document.getElementById("selected-file").textContent = "No file selected";
      }
    });
  </script>
  <script>
    <?php
    if (isset($_SESSION['item_added_success']) && $_SESSION['item_added_success']) {
      echo "alert('Item added successfully.');";
      unset($_SESSION['item_added_success']); 
    }
    ?>
  </script>
  
 

</body>
</html>