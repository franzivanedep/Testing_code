<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "tiptoolroom_db";

$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

if ($transactionConn->connect_error) {
    die("Connection to the transaction database failed: " . $transactionConn->connect_error);
}

$sql = "SELECT studentname, studentID, courses, sdate, item, confirmed_by, quantity FROM tiptoolroom_db.transactionstable WHERE status = '1'";
$result = $transactionConn->query($sql);

if ($result) {
    $transactionsGrouped = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $key = $row["studentname"] . $row["courses"] . $row["sdate"];

            if (!isset($transactionsGrouped[$key])) {
                $transactionsGrouped[$key] = [
                    "studentname" => $row["studentname"],
                    "studentID" => $row["studentID"], // Added studentID
                    "courses" => $row["courses"],
                    "sdate" => $row["sdate"],
                    "transactions" => [],
                    "confirmed_by" => $row["confirmed_by"],
                ];
            }

            $transactionsGrouped[$key]["transactions"][] = [
                "item" => $row["item"],
                "quantity" => $row["quantity"],
            ];
        }

        $html = '';

        foreach ($transactionsGrouped as $transaction) {
            $html .= "<h2>Name: " . $transaction["studentname"] . "</h2>";
            $html .= "<p>Student ID: " . $transaction["studentID"] . "</p>"; // Display studentID

            $html .= "<p>Course: " . $transaction["courses"] . "</p>";
            $html .= "<p>Date: " . $transaction["sdate"] . "</p>";
            $html .= "<p>Confirmed By: " . $transaction["confirmed_by"] . "</p>";
            $html .= "<p>Item List:</p><ul>";

            foreach ($transaction["transactions"] as $transactionItem) {
                $html .= "<li>Item: " . $transactionItem["item"] . " - Quantity: " . $transactionItem["quantity"] . "</li>";
            }

            $html .= "</ul>";

            // Add Confirm and Reject buttons for each transaction
            $html .= "<button class='confirm-button' data-student='" . $transaction["studentname"] . "' data-course='" . $transaction["courses"] . "' data-sdate='" . $transaction["sdate"] . "' data-student-id='" . $transaction["studentID"] . "'>Approve</button>";
            $html .= "<button class='reject-button' data-student='" . $transaction["studentname"] . "' data-course='" . $transaction["courses"] . "' data-sdate='" . $transaction["sdate"] . "' data-student-id='" . $transaction["studentID"] . "'>Reject</button>";
        }

        echo $html;
    } else {
        echo "No confirmed transactions found.";
    }

    $result->close();
} else {
    echo "Error retrieving confirmed transactions: " . $transactionConn->error;
}
$transactionConn->close();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery library -->
<script>
    $(document).ready(function () {
        $(".confirm-button").click(function () {
            var studentName = $(this).data("student");
            var studentID = $(this).data("student-id"); // Added studentID
            var courses = $(this).data("course");
            var sdate = $(this).data("sdate");

            // Send an AJAX request to update the status
            $.ajax({
                type: "POST",
                url: "/TIPTOOLROOmmalapitnadone/student/PHP/approve.php", // Create this file to handle the update
                data: {
                    student: studentName,
                    studentID: studentID, // Include studentID
                    course: courses,
                    date: sdate,
                    status: 2, // Set the status to 2 for "Approved"
                },
                success: function (response) {
                    if (response === "success") {
                        alert("Transaction approved successfully!");
                        location.reload(); // Reload the page to update the displayed data
                    } else {
                        alert("Failed to approve transaction. Please try again.");
                    }
                },
            });
        });
    });
</script>
