<?php
session_start(); // Start a session

$servername = "localhost:3307";
$username = "root";
$db_password = ""; // Replace with your actual MySQL password
$dbname = "transaction_db";

$conn = new mysqli($servername, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query with hardcoded studentID
$sql = "SELECT ID, TransactID, item, quantity, sdate, studentname FROM transactionstable WHERE studentID = 2113896";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Echo the retrieved data here
        echo "ID: " . $row['ID'] . ", TransactID: " . $row['TransactID'] . ", Item: " . $row['item'] . ", Quantity: " . $row['quantity'] . ", Student Name: " . $row['studentname'] . ", Date: " . $row['sdate'] . "<br>";
    }
} else {
    echo "Error in the query: " . $conn->error;
}

// Set or retrieve session variables
if (isset($_SESSION['ID'])) {
    echo $_SESSION['ID'];
}

if (isset($_SESSION['studentname'])) {
    echo $_SESSION['studentname'];
}

$conn->close(); // Close the database connection
?>
