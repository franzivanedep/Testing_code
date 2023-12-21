<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "tiptoolroom_db";

$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

if ($transactionConn->connect_error) {
    die("Connection to the transaction database failed: " . $transactionConn->connect_error);
}

$sql = "SELECT studentname, studentID, courses, sdate, stime, item, status, confirmed_by, quantity FROM tiptoolroom_db.transactionstable ORDER BY sdate, stime";
$result = $transactionConn->query($sql);

if ($result) {
    $currentDateTime = null;

    while ($row = $result->fetch_assoc()) {
        $dateTime = $row["stime"];
        $date = $row["sdate"];

        if ($dateTime !== $currentDateTime) {
            if ($currentDateTime !== null) {
                echo "</div>";
            }

            echo "<div class='transaction-group' data-time='" . $dateTime . "'>";
            echo "<h2>Date: " . $date . " - Time: " . $dateTime . "</h2>";
            $currentDateTime = $dateTime;
        }

        echo "<div class='transaction-container'>";
        echo "<h3>Name: " . $row["studentname"] . "</h3>";
        echo "<p>Student ID: " . $row["studentID"] . "</p>";
        echo "<p>Course: " . $row["courses"] . "</p>";
        echo "<p>Confirmed By: " . $row["confirmed_by"] . "</p>";
        echo "<p>Item List:</p><ul>";
        echo "<li>Item: " . $row["item"] . " - Quantity: " . $row["quantity"] . "</li>";
        echo "</ul>";

        echo "<div class='button-container'>";
        echo "<button class='confirm-button' data-student='" . $row["studentname"] . "' data-student-id='" . $row["studentID"] . "' data-course='" . $row["courses"] . "' data-sdate='" . $date . "' data-time='" . $dateTime . "'>Ready</button>";
        echo "<button class='prepare-button' data-student='" . $row["studentname"] . "' data-student-id='" . $row["studentID"] . "' data-course='" . $row["courses"] . "' data-sdate='" . $date . "' data-time='" . $dateTime . "'>Prepare</button>";
        echo "<button class='reject-button' data-student='" . $row["studentname"] . "' data-student-id='" . $row["studentID"] . "' data-course='" . $row["courses"] . "' data-sdate='" . $date . "' data-time='" . $dateTime . "'>Reject</button>";
        echo "<button class='return-button' data-student='" . $row["studentname"] . "' data-student-id='" . $row["studentID"] . "' data-course='" . $row["courses"] . "' data-sdate='" . $date . "' data-time='" . $dateTime . "'>Already Return</button>";

        echo "</div>";

        echo "</div>";
    }

    echo "</div>";

    $result->close();
} else {
    echo "Error retrieving confirmed transactions: " . $transactionConn->error;
}

$transactionConn->close();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".confirm-button").click(function () {
            var studentName = $(this).data("student");
            var studentID = $(this).data("student-id");
            var courses = $(this).data("course");
            var sdate = $(this).data("sdate");
            var time = $(this).data("time");

            updateStatus(studentName, studentID, courses, sdate, time, 2, "Transaction approved successfully!");
        });

        $(".prepare-button").click(function () {
            var studentName = $(this).data("student");
            var studentID = $(this).data("student-id");
            var courses = $(this).data("course");
            var sdate = $(this).data("sdate");
            var time = $(this).data("time");

            updateStatus(studentName, studentID, courses, sdate, time, 4, "Transaction set to preparing status!");
        });

        $(".reject-button").click(function () {
            var studentName = $(this).data("student");
            var studentID = $(this).data("student-id");
            var courses = $(this).data("course");
            var sdate = $(this).data("sdate");
            var time = $(this).data("time");

            updateStatus(studentName, studentID, courses, sdate, time, 3, "Transaction rejected!");
        });

        $(".return-button").click(function () {
            var studentName = $(this).data("student");
            var studentID = $(this).data("student-id");
            var courses = $(this).data("course");
            var sdate = $(this).data("sdate");
            var time = $(this).data("time");

            updateStatus(studentName, studentID, courses, sdate, time, 5, "Transaction marked as already returned!");
        });

        function updateStatus(studentName, studentID, courses, sdate, time, status, successMessage) {
            $.ajax({
                type: "POST",
                url: "/TIPTOOLROOmmalapitnadone/student/PHP/approve.php",
                data: {
                    student: studentName,
                    studentID: studentID,
                    course: courses,
                    date: sdate,
                    time: time,
                    status: status,
                },
                success: function (response) {
                    if (response === "success") {
                        alert(successMessage);
                        // Assuming you have a way to identify the time group in the DOM,
                        // you can update the status of all transactions within that group.
                        var timeGroup = $('.transaction-group[data-time="' + time + '"]');
                        timeGroup.find('.transaction-container').each(function () {
                            // Update status or perform other actions as needed.
                        });
                    } else {
                        alert(".");
                    }
                },
                
            });
        }
    });
</script>
