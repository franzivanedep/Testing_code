<?php
$studentName = $_GET['studentName'];
$studentID = $_GET['studentID'];
$courseCode = $_GET['Course_Code'];
$courseSection = $_GET['Course_Section'];
$selectedItems = json_decode($_GET['selectedItems'], true);

// Check if all expected parameters are provided
if (!$studentName || !$studentID || !$courseCode || !$courseSection || !$selectedItems) {
    die("Required data missing.");
}

// Your database connection code
$servername = "localhost:3307";
$username = "root";
$db_password = "your_password"; // Replace with your actual MySQL password
$dbname = "transaction_db";
$conn = new mysqli($servername, $username, $db_password, $dbname);

// Check if the connection to the database was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$transactID = uniqid();

// Combine courseCode and courseSection
$courses = $courseCode . ' ' . $courseSection;

foreach ($selectedItems as $item) {
    $itemName = $item['name'];
    $itemQuantity = $item['quantity'];
    $sdate = date("Y-m-d");
    $status = 0;

    $sql = "INSERT INTO transactionstable (ID, TransactID, item, quantity, studentname, studentID, sdate, status, courses)
            VALUES (NULL, '$transactID', '$itemName', '$itemQuantity', '$studentName', '$studentID', '$sdate', '$status', '$courses')";

    if ($conn->query($sql) === TRUE) {
        // Insertion success, you can add further logic if needed
    } else {
        die("Error: " . $sql . "<br>" . $conn->error); // Handle the error
    }
}

$conn->close();
?>
