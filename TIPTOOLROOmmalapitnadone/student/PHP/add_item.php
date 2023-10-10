<?php
// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Database configuration
  $servername = "localhost:3307";
  $username = "root";
  $password = "your_password"; // Replace with your actual MySQL password
  $dbname = "item_db";

  // Create a database connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve data from the form
  $id_num = $_POST['id_num']; // Admin-inputted ID
  $name = $_POST['name'];
  $description = $_POST['description'];
  $quantity = $_POST['quantity'];
  $category = $_POST['category'];


  // Check if a file was uploaded
  if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['images']['tmp_name'];
    $fileName = $_FILES['images']['name'];

    // Specify the folder where you want to save the uploaded file
    $uploadDirectory = 'uploads/';

    // You can generate a unique filename if needed
    $newFileName = uniqid() . '_' . $fileName;

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($fileTmpPath, $uploadDirectory . $newFileName)) {
      // The file has been successfully uploaded

      // Insert data into the database with the file path
      $sql = "INSERT INTO items (id_num, name, description, quantity, category, images) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ississ", $id_num, $name, $description, $quantity, $category, $newFileName);

      if ($stmt->execute()) {
        // Item added successfully
        echo "<script>
                alert('Item added successfully.');
                window.location.href = '/TIPTOOLROOmmalapitnadone/admin-toolroomstaff/admin.php'; // Redirect back to admin.php
              </script>";
        exit;
      } else {
        echo "Error: " . $stmt->error;
      }

      $stmt->close();
    } else {
      // Error handling for file upload failure
      echo "Error uploading file.";
    }
  } else {
    // Handle the case where no file was uploaded
    echo "No file uploaded.";
  }

  // Close the database connection
  $conn->close();
}
// After successfully adding an item
session_start();
$_SESSION['item_added_success'] = true;
?>



