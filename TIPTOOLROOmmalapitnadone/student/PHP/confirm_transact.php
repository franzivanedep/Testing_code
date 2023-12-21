<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "tiptoolroom_db";

$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

if ($transactionConn->connect_error) {
    die("Connection to the transaction database failed: " . $transactionConn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['professorName']) || !isset($_POST['stime'])) {
        die("Error: 'professorName' or 'stime' not set in POST.");
    }

    $professorName = $_POST['professorName'];
    $stime = $_POST['stime'];

    // Validate and sanitize user input
    $professorName = htmlspecialchars($professorName);
    $stime = htmlspecialchars($stime);

    // Extracting first and last name
    $nameParts = explode(' ', $professorName);
    $professorFirstName = $nameParts[0];
    $professorLastName = isset($nameParts[1]) ? $nameParts[1] : '';

    // Update the transactions in the transaction database
    $sql = "UPDATE transactionstable
            SET status = 1,
            confirmed_by = CONCAT(?, ' ', ?)
            WHERE stime = ?"; // Add stime condition

    $stmt = $transactionConn->prepare($sql);

    if (!$stmt) {
        error_log("Error preparing statement: " . $transactionConn->error);
        die("An error occurred while processing the request. Please try again later.");
    }

    $stmt->bind_param("sss", $professorFirstName, $professorLastName, $stime);

    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        die("An error occurred while processing the request. Please try again later.");
    }

    echo "Transactions updated successfully.<br>";

    $stmt->close();
} else {
    echo "No professorName or stime found in the provided data.<br>";
    die("No professorName or stime found in the provided data.");
}

$transactionConn->close();

header("Location: /TIPTOOLROOmmalapitnadone/admin-toolroomstaff/admin_transac.php");
exit;
?>
