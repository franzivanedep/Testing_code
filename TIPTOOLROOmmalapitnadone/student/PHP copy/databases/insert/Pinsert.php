<?php
// Database connection details
$hostname = "localhost"; // Replace with your MySQL hostname
$username = "your_username"; // Replace with your MySQL username
$password = "your_password"; // Replace with your MySQL password

// Connect to the professor database
$professorConnection = new mysqli($hostname, $username, $password, "professor_db");
if ($professorConnection->connect_error) {
    die("Professor database connection failed: " . $professorConnection->connect_error);
}

// User details
$professorUsername = "professor456";
$professorPassword = "professorpass";
$professorEmail = "professor@example.com";

// Add user to the professors table
$professorQuery = "INSERT INTO professors (username, password, email) VALUES ('$professorUsername', '$professorPassword', '$professorEmail')";
if ($professorConnection->query($professorQuery) === TRUE) {
    echo "Professor user added successfully.";
} else {
    echo "Error adding professor user: " . $professorConnection->error;
}

// Close the database connection
$professorConnection->close();
?>
