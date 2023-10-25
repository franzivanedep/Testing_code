<?php
// First database connection for transaction data
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "transaction_db";

// Second database connection for professor data
$professorServername = "localhost:3307";
$professorUsername = "root";
$professorPassword = ""; // Replace with your actual MySQL password for the professor_db
$professorDbname = "professor_db";

// Create the first database connection for transaction data
$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

// Check the first connection
if ($transactionConn->connect_error) {
    die("Connection to transaction database failed: " . $transactionConn->connect_error);
}

// Create the second database connection for professor data
$professorConn = new mysqli($professorServername, $professorUsername, $professorPassword, $professorDbname);

// Check the second connection
if ($professorConn->connect_error) {
    die("Connection to professor database failed: " . $professorConn->connect_error);
}

// ...

// Assuming you have the professor's id (professor_id) available in a variable
$professorId = $_GET['professor_id'];

// Fetch the professor's course information from the professor's database
$professorSql = "SELECT Course_Code, Course_Section FROM courses WHERE ProfID = '$professorId'";
$professorResult = $professorConn->query($professorSql);

if ($professorResult === false) {
    echo "Error: " . $professorConn->error;
} else {
    if ($professorResult->num_rows > 0) {
        $row = $professorResult->fetch_assoc();
        $professorCourseCode = $row['Course_Code'];
        $professorCourseSection = $row['Course_Section'];

        // Now, you can retrieve transactions from the transaction table based on the professor's course
        $transactionSql = "SELECT * FROM transactionstable WHERE courses = '$professorCourseCode $professorCourseSection'";
        $transactionResult = $transactionConn->query($transactionSql);

        if ($transactionResult === false) {
            echo "Error: " . $transactionConn->error;
        } else {
            $transactions = array();

            if ($transactionResult->num_rows > 0) {
                while ($transactionRow = $transactionResult->fetch_assoc()) {
                    // Add each transaction to the transactions array
                    $transactions[] = $transactionRow;
                }
            }

            // Close the database connections
            $professorConn->close();
            $transactionConn->close();

            // Prepare the response data
            $responseData = array(
                'professorId' => $professorId,
                'courseCode' => $professorCourseCode,
                'courseSection' => $professorCourseSection,
                'transactions' => $transactions
            );

            // Return the response data as JSON
            header('Content-Type: application/json');
            echo json_encode($responseData);
        }
    } else {
        echo "Professor course information not found.";
    }
}
?>
