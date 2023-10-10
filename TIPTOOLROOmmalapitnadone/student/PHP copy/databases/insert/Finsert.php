<?php

// User details
$facultyEmail = 'email';
$facultyUsername = $FacultyEmail;
$facultyPassword = 'password';

// Add user to the faculty table
$facultyQuery = "INSERT INTO faculty (username==email, password, email) VALUES ('$facultyUsername', '$facultyPassword', '$facultyEmail')";
if ($facultyConnection->query($facultyQuery) === TRUE) {
    echo "Faculty user added successfully.";
} else {
    echo "Error adding faculty user: " . $facultyConnection->error;
}

// Close the database connection
$facultyConnection->close();
?>
