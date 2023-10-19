<?php
// Replace these with your actual database connection details
$servername = "localhost:3307";
$username = "root";
$db_password = ""; // Replace with your actual MySQL password
$dbname = "professor_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $db_password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the course code and section from the form
    $Course_Code = $_POST["Course_Code"];
    $Course_Section = $_POST["Course_Section"];
    $ProfID = $_POST["ProfID"];

    // You can perform additional validation if needed

    // Insert the course information into the database
    $sql = "INSERT INTO courses (Course_Code, Course_Section, ProfID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $Course_Code, $Course_Section, $ProfID);

        if ($stmt->execute()) {
            // Course added successfully
            echo "Course added successfully.";
        } else {
            // Error adding course
            echo "Error adding course: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
