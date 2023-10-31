<?php
// First, ensure you have a database connection established.
// Replace these variables with your actual database connection details.
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "transaction_db";

// Create a database connection for transaction data
$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

// Check the connection
if ($transactionConn->connect_error) {
    die("Connection to transaction database failed: " . $transactionConn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionIds = $_POST['transactionIds'];
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

        // Update all the transactions in the transaction database and set status to '1'
        $transactionIds = implode(',', $transactionIds);
        $sql = "UPDATE transaction_db.transactionstable
                SET status = '1',
                confirmed_by = CONCAT('$professorFirstName', ' ', '$professorLastName')
                WHERE ID IN ($transactionIds)";
        $stmt = $transactionConn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $transactionConn->error);
        }

        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            die("No rows were updated. Transactions may not exist.");
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
