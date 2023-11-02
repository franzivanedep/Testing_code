<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "transaction_db";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentName = $_POST["student"];
    $courses = $_POST["course"];
    $sdate = $_POST["date"];
    $newStatus = 2; // Set the status to 2 for "Approved"

    $updateConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

    if ($updateConn->connect_error) {
        die("Connection to the database failed: " . $updateConn->connect_error);
    }

    // Update the status in the database
    $updateSql = "UPDATE transaction_db.transactionstable SET status = ? WHERE studentname = ? AND courses = ? AND sdate = ?";
    $stmt = $updateConn->prepare($updateSql);
    $stmt->bind_param("isss", $newStatus, $studentName, $courses, $sdate);

    if ($stmt->execute()) {
        echo "success"; // Return a success message
    } else {
        echo "Error: " . $updateConn->error; // Return the specific error message
    }

    $stmt->close();
    $updateConn->close();
}
?>
