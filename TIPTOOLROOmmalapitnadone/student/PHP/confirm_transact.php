<?php
// First database connection for transaction data
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "transaction_db";

// Create the database connection for transaction data
$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

// Check the connection
if ($transactionConn->connect_error) {
    die("Connection to transaction database failed: " . $transactionConn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transactionId'];
    $professorId = $_POST['professorId'];

    // Get the professor's first_name and last_name from the professor database
    $sql = "SELECT first_name, last_name FROM professor_db.professors WHERE id_num = ?";
    $stmt = $transactionConn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $transactionConn->error);
    }

    $stmt->bind_param("i", $professorId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($professorFirstName, $professorLastName);
        $stmt->fetch();

        // Update the transaction in the transaction database
        $sql = "UPDATE transaction_db.transactionstable
                SET status = 'confirm',
                confirmed_by = CONCAT('$professorFirstName', ' ', '$professorLastName')
                WHERE ID = ?";
        $stmt = $transactionConn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $transactionConn->error);
        }

        $stmt->bind_param("i", $transactionId);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            die("No rows were updated. Transaction may not exist.");
        }

        $stmt->close();
    } else {
        die("No professor found with the provided professorId.");
    }
}

// Close the database connection
$transactionConn->close();

// Redirect to the admin page
header("Location: /TIPTOOLROOmmalapitnadone/admin-toolroomstaff/admin_transac.php");
exit;
?>