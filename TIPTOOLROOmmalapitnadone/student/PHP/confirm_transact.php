<?php
// First, ensure you have a database connection established.
// Replace these variables with your actual database connection details.
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "tiptoolroom_db";

// Create a database connection for transaction data
$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

// Check the connection
if ($transactionConn->connect_error) {
    die("Connection to transaction database failed: " . $transactionConn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionIds = $_POST['transactionIds'];
    $professorId = $_POST['professorId'];

    // Debug statement
    echo "Received professorId: " . $professorId . "<br>";

    // Get the professor's first_name and last_name from the professor database
    $sql = "SELECT first_name, last_name FROM professors WHERE id_num = ?";
    $stmt = $transactionConn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $transactionConn->error);
    }

    $stmt->bind_param("i", $professorId);
    $stmt->execute();

    // Check for execution errors
    if ($stmt->error) {
        die("Error executing statement: " . $stmt->error);
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($professorFirstName, $professorLastName);
        $stmt->fetch();

        // Debug statement
        echo "Found professor: " . $professorFirstName . " " . $professorLastName . "<br>";

        // Convert $transactionIds array to a comma-separated string
        $transactionIdsString = implode(',', $transactionIds);

        // Update all the transactions in the transaction database and set status to '1'
        $sql = "UPDATE transactionstable
                SET status = '1',
                confirmed_by = CONCAT(?, ' ', ?)
                WHERE ID IN ($transactionIdsString)";
        $stmt = $transactionConn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $transactionConn->error);
        }

        // Bind parameters
        $stmt->bind_param("ss", $professorFirstName, $professorLastName);
        $stmt->execute();

        // Check for execution errors
        if ($stmt->error) {
            die("Error executing statement: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            // Debug statement
            echo "No rows were updated. Transactions may not exist.<br>";
            die("No rows were updated. Transactions may not exist.");
        }

        // Debug statement
        echo "Transactions updated successfully.<br>";

        $stmt->close();
    } else {
        // Debug statement
        echo "No professor found with the provided professorId.<br>";
        die("No professor found with the provided professorId.");
    }
}

// Close the database connection
$transactionConn->close();

// Redirect to the admin page
header("Location: /TIPTOOLROOmmalapitnadone/admin-toolroomstaff/admin_transac.php");
exit;
?>
