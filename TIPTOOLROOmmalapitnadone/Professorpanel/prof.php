<?php
session_start();
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
        <ul id="transactionsList"></ul>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
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
                                transactions: [],
                            };
                        }
                        transactionsByStudentAndCourse[key].transactions.push(transaction);
                    });

                    // Render the grouped transactions with confirm and reject all buttons for each student
                    const transactionHTML = Object.values(transactionsByStudentAndCourse).map(function (studentCourseGroup) {
    const studentName = studentCourseGroup.studentName;
    const course = studentCourseGroup.course;
    const itemsHTML = studentCourseGroup.transactions.map(function (transaction) {
        return `Item: ${transaction.item} - Quantity: ${transaction.quantity}`;
    }).join('<br>');

    // Display the date on the same line
    const date = new Date(studentCourseGroup.transactions[0].sdate);
    const formattedDate = date.toLocaleDateString();
    
    // Add confirm and reject all buttons for each student
    const confirmButton = `<button class="confirmAllButton" data-student-name="${studentName}" data-course="${course}">Confirm All</button>`;
    const rejectAllButton = `<button class="rejectAllButton" data-student-name="${studentName}" data-course="${course}">Reject All</button>`;

    return `
        <li>Student: ${studentName} - Course: ${course} - Date: ${formattedDate}<br>${itemsHTML}<br>${confirmButton}<br>${rejectAllButton}</li>
    `;
}).join('');

                    transactionsList.html(transactionHTML);
                }
            },
            error: function (error) {
                console.log('Error: ' + JSON.stringify(error));
            }
        });

        // Handle confirm all button click
        $(document).on('click', '.confirmAllButton', function () {
            const studentName = $(this).data('student-name');
            const course = $(this).data('course');

            // Get all transactions for the student and course
            const transactionsToConfirm = transactionsByStudentAndCourse[`${studentName}-${course}`].transactions;

            // Confirm all transactions for the student and course
            confirmTransactions(transactionsToConfirm, studentName, course);
        });

        // Function to confirm transactions
        function confirmTransactions(transactionsToConfirm, studentName, course) {
            // Send AJAX request to confirm transactions
            const transactionIds = transactionsToConfirm.map(transaction => transaction.ID);

            $.ajax({
                url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirm_transact.php',
                method: 'POST',
                data: {
                    transactionIds: transactionIds,
                    professorId: professorID,
                    professorName: '<?php echo $_SESSION['facultyName']; ?>', // Include professor's name
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

            // Get all transactions for the student and course
            const transactionsToReject = transactionsByStudentAndCourse[`${studentName}-${course}`].transactions;

            // Reject all transactions for the student and course
            rejectAllTransactions(transactionsToReject, studentName, course);
        });

        // Function to reject all transactions for a student and course
        function rejectAllTransactions(transactionsToReject, studentName, course) {
            // Send AJAX request to reject all transactions
            const transactionIds = transactionsToReject.map(transaction => transaction.ID);

            $.ajax({
                url: '/path/to/your/reject_all_script.php',
                method: 'POST',
                data: {
                    transactionIds: transactionIds,
                    professorId: professorID,
                    professorName: '<?php echo $_SESSION['facultyName']; ?>', // Include professor's name
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
