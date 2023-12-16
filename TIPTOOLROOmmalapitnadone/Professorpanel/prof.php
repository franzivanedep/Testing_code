<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request
    $studentID = $_POST['studentID'];
    $requestDetails = $_POST['requestDetails'];

    // Your logic for creating a new transaction or updating an existing one here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor's Transactions</title>
    <link rel="stylesheet" href="css/professrstyle.css">
</head>
<body>
    <header>
        <h1>Professor's Transactions</h1>
        <h2>Welcome, <?php echo $_SESSION['facultyName']; ?></h2>
        <button id="addCoursesButton" onclick="redirectToCoursesPage()">Add Courses</button>
    </header>

    <main>
        <section id="transactions">
            <h2>Transactions:</h2>
            <button id="toggleDisplayButton">Toggle Display of Confirmed Transactions</button>
            <ul id="transactionsList"></ul>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Your JavaScript logic for retrieving and displaying transactions
            // Retrieve the faculty ID from localStorage
            const professorID = localStorage.getItem('facultyID');

            if (!professorID) {
                // Handle the case where professorID is not available
                console.error('Professor ID not found in localStorage.');
                return;
            }

            // Create an object to store transactions grouped by student name and course
            const transactionsByStudentAndCourse = {};

            // Make an AJAX request to get the professor's transactions
            $.ajax({
                url: '/TIPTOOLROOmmalapitnadone/student/PHP/get_transact.php',
                method: 'GET',
                data: {
                    professor_id: professorID
                },
                dataType: 'json',
                success: function (data) {
                    const transactionsList = $('#transactionsList');

                    if (data.error) {
                        // Handle the case where an error occurred
                        console.error('Error: ' + data.error);
                        transactionsList.html('<li>Error fetching transactions.</li>');
                    } else if (data.transactions.length === 0) {
                        transactionsList.html('<li>No transactions found.</li>');
                    } else {
                        // Group transactions by student name and course
                        data.transactions.forEach(function (transaction) {
                            const key = `${transaction.studentname}-${transaction.courses}`;
                            if (!transactionsByStudentAndCourse[key]) {
                                transactionsByStudentAndCourse[key] = {
                                    studentName: transaction.studentname,
                                    course: transaction.courses,
                                    studentID: transaction.studentID,
                                    transactions: [],
                                };
                            }
                            transactionsByStudentAndCourse[key].transactions.push(transaction);
                        });

                        // Render the grouped transactions with confirm and reject all buttons for each student
                        const transactionHTML = Object.values(transactionsByStudentAndCourse).map(function (studentCourseGroup) {
                            const studentName = studentCourseGroup.studentName;
                            const course = studentCourseGroup.course;
                            const studentID = studentCourseGroup.studentID;
                            const itemsHTML = studentCourseGroup.transactions.map(function (transaction) {
                                return `Item: ${transaction.item} - Quantity: ${transaction.quantity}`;
                            }).join('<br>');

                            // Display the date on the same line
                            const date = new Date(studentCourseGroup.transactions[0].sdate);
                            const formattedDate = date.toLocaleDateString();

                            // Add confirm and reject all buttons for each student
                            const confirmButton = `<button class="confirmAllButton" data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}">Confirm All</button>`;
                            const rejectAllButton = `<button class="rejectAllButton" data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}">Reject All</button>`;

                            // Check if any of the transactions have status 2 (confirmed by admin)
                            const hasConfirmedStatus = studentCourseGroup.transactions.some(function (transaction) {
                                return transaction.status === 2;
                            });

                            if (!hasConfirmedStatus) {
                                // Display transactions only if none of them have status 2
                                return `
                                    <li data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}">
                                        Student: ${studentName} - Course: ${course} - Student ID: ${studentID} - Date: ${formattedDate}<br>
                                        ${itemsHTML}<br>
                                        ${confirmButton}<br>
                                        ${rejectAllButton}
                                    </li>
                                `;
                            } else {
                                return ''; // Don't display transactions with status 2
                            }
                        }).join('');

                        transactionsList.html(transactionHTML);

                        // Add a click event handler for the transactions to mark them as confirmed
                        transactionsList.on('click', 'li', function () {
                            const studentName = $(this).data('student-name');
                            const course = $(this).data('course');
                            const studentID = $(this).data('student-id');

                            markTransactionAsConfirmed(studentName, course, studentID);
                        });
                    }
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                }
            });

            // ...
            
            // Function to mark a transaction as confirmed
            function markTransactionAsConfirmed(studentName, course, studentID) {
                // Implement your logic to mark the transaction as confirmed
                // You can use the data in transactionsByStudentAndCourse or make an AJAX request to the server
                // After marking as confirmed, call filterAndDisplayTransactions to update the display
                filterAndDisplayTransactions();
            }

            // Event handler for the toggle display button
            $('#toggleDisplayButton').on('click', function () {
                displayConfirmed = !displayConfirmed;
                filterAndDisplayTransactions();
            });

            // Handle confirm all button click
            $(document).on('click', '.confirmAllButton', function () {
                const studentName = $(this).data('student-name');
                const course = $(this).data('course');
                const studentID = $(this).data('student-id');

                // Get all transactions for the student and course
                const transactionsToConfirm = transactionsByStudentAndCourse[`${studentName}-${course}`].transactions;

                // Confirm all transactions for the student and course
                confirmTransactions(transactionsToConfirm, studentName, course, studentID);

                // Mark transactions as confirmed and update the display
                markTransactionAsConfirmed(studentName, course, studentID);

                // Show an alert
                alert('Transactions confirmed successfully.');
            });

            // Function to confirm transactions
            function confirmTransactions(transactionsToConfirm, studentName, course, studentID) {
                // Send AJAX request to confirm transactions
                const transactionIds = transactionsToConfirm.map(transaction => transaction.ID);

                $.ajax({
                    url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirm_transact.php',
                    method: 'POST',
                    data: {
                        transactionIds: transactionIds,
                        professorId: professorID,
                        professorName: '<?php echo $_SESSION['facultyName']; ?>', // Include professor's name
                        studentID: studentID, // Include studentID
                    },
                    success: function (response) {
                        // Handle the response from the server
                    }
                });
            }

            // Handle reject all button click
            $(document).on('click', '.rejectAllButton', function () {
                const studentName = $(this).data('student-name');
                const course = $(this).data('course');
                const studentID = $(this).data('student-id');

                // Get all transactions for the student and course
                const transactionsToReject = transactionsByStudentAndCourse[`${studentName}-${course}`].transactions;

                // Reject all transactions for the student and course
                rejectAllTransactions(transactionsToReject, studentName, course, studentID);
            });

            // Function to reject all transactions for a student and course
            function rejectAllTransactions(transactionsToReject, studentName, course, studentID) {
                // Send AJAX request to reject all transactions
                const transactionIds = transactionsToReject.map(transaction => transaction.ID);

                $.ajax({
                    url: '/path/to/your/reject_all_script.php',
                    method: 'POST',
                    data: {
                        transactionIds: transactionIds,
                        professorId: professorID,
                        professorName: '<?php echo $_SESSION['facultyName']; ?>', // Include professor's name
                        studentID: studentID, // Include studentID
                    },
                    success: function (response) {
                        // Handle the response from the server
                    }
                });
            }
        });

        function redirectToCoursesPage() {
            // Redirect to the "courses.html" page
            window.location.href = '/TIPTOOLROOmmalapitnadone/student/courses.html';
        }
    </script>
</body>
</html>
