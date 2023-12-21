<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection details (replace with your actual database credentials)
    $servername = "localhost:3307";
    $dbUsername = "root";
    $dbPassword = "your_password";
    $dbname = "tiptoolroom_db";

    // Create a new mysqli connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query to check credentials
    $query = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the entered credentials are valid
    if ($result->num_rows > 0) {
        // Redirect to admin_transac.php upon successful login
        header("Location: admin_transac.php");
        exit();
    } else {
        echo "Invalid username or password. Please try again.";
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
