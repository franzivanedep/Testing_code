<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "tiptoolroom_db";

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if required parameters are set
    if (isset($_POST["student"], $_POST["course"], $_POST["date"], $_POST["status"], $_POST["time"])) {
        $studentName = $_POST["student"];
        $courses = $_POST["course"];
        $sdate = $_POST["date"];
        $newStatus = $_POST["status"];
        $transactionTime = $_POST["time"];

        $updateConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

        // Check the connection
        if ($updateConn->connect_error) {
            echo json_encode(["status" => "error", "message" => "Connection to the database failed: " . $updateConn->connect_error]);
            exit();
        }

        // Update the status in the database
        $updateSql = "UPDATE tiptoolroom_db.transactionstable SET status = ? WHERE studentname = ? AND courses = ? AND sdate = ? AND stime = ?";
        $stmt = $updateConn->prepare($updateSql);

        if ($stmt) {
            $stmt->bind_param("issss", $newStatus, $studentName, $courses, $sdate, $transactionTime);

            // Execute the statement
            if ($stmt->execute()) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating status: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing statement."]);
        }

        $updateConn->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Required parameters are missing."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method. This script should be accessed via a POST request."]);
}
?>
