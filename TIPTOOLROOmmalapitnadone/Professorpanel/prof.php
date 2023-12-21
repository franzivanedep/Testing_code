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
    <link rel="stylesheet" href=" css\new.css">
</head>

<body>
    <header>
        <h1>Professor's Transactions</h1>
        <h2>Welcome, <?php echo $_SESSION['facultyName']; ?></h2>
        <button id="addCoursesButton" class="customButton" onclick="redirectToCoursesPage()">Add Courses</button>
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
            const professorID = localStorage.getItem('facultyID');

            if (!professorID) {
                console.error('Professor ID not found in localStorage.');
                return;
            }

            const transactionsByStudentAndStime = {};

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
                        console.error('Error: ' + data.error);
                        transactionsList.html('<li>Error fetching transactions.</li>');
                    } else if (data.transactions.length === 0) {
                        transactionsList.html('<li>No transactions found.</li>');
                    } else {
                        data.transactions.forEach(function (transaction) {
                            const key = `${transaction.studentname}-${transaction.stime}`;
                            if (!transactionsByStudentAndStime[key]) {
                                transactionsByStudentAndStime[key] = {
                                    studentName: transaction.studentname,
                                    course: transaction.courses,
                                    studentID: transaction.studentID,
                                    stime: transaction.stime,
                                    transactions: [{
                                        ID: transaction.ID,
                                        item: transaction.item,
                                        quantity: transaction.quantity,
                                        status: transaction.status
                                    }],
                                };
                            } else {
                                transactionsByStudentAndStime[key].transactions.push({
                                    ID: transaction.ID,
                                    item: transaction.item,
                                    quantity: transaction.quantity,
                                    status: transaction.status
                                });
                            }
                        });

                        const transactionHTML = Object.values(transactionsByStudentAndStime).map(function (studentCourseGroup) {
                            const studentName = studentCourseGroup.studentName;
                            const course = studentCourseGroup.course;
                            const studentID = studentCourseGroup.studentID;
                            const stime = studentCourseGroup.stime;

                            const date = new Date();
                            const timeParts = stime.split(':');
                            date.setHours(timeParts[0]);
                            date.setMinutes(timeParts[1]);
                            date.setSeconds(timeParts[2]);

                            if (isNaN(date.getTime())) {
                                console.error(`Invalid date for student ${studentName}: ${stime}`);
                                return ''; // Don't display this transaction
                            }

                            const itemsHTML = studentCourseGroup.transactions.map(function (transaction) {
                                return `Item: ${transaction.item} - Quantity: ${transaction.quantity}`;
                            }).join('<br>');

                            const formattedDate = date.toLocaleDateString();
                            const formattedTime = date.toLocaleTimeString();

                            const confirmButton = `<button class="confirmAllButton" data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}" data-stime="${stime}">Confirm All</button>`;
                            const rejectAllButton = `<button class="rejectAllButton" data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}" data-stime="${stime}">Reject All</button>`;

                            const hasConfirmedStatus = studentCourseGroup.transactions.some(function (transaction) {
                                return transaction.status === 2;
                            });

                            if (!hasConfirmedStatus) {
                                return `
                                    <li data-student-name="${studentName}" data-course="${course}" data-student-id="${studentID}" data-stime="${stime}">
                                        Student: ${studentName} - Course: ${course} - Student ID: ${studentID} - Date: ${formattedDate} Time: ${formattedTime}<br>
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

                        transactionsList.on('click', 'li', function () {
                            const studentName = $(this).data('studentname');
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

            function markTransactionAsConfirmed(studentName, course, studentID) {
                filterAndDisplayTransactions();
            }

            $('#toggleDisplayButton').on('click', function () {
                displayConfirmed = !displayConfirmed;
                filterAndDisplayTransactions();
            });

            $('#transactionsList').on('click', '.confirmAllButton', function () {
    const studentName = $(this).data('student-name');
    const course = $(this).data('course');
    const studentID = $(this).data('student-id');
    const stime = $(this).data('stime');
    
    const key = `${studentName}-${studentID}-${course}-${stime}`;
    const studentCourseGroup = transactionsByStudentAndStime[key];
    
    const transactionsToConfirm = studentCourseGroup && studentCourseGroup.transactions ? studentCourseGroup.transactions : [];
    
    // Retrieve transaction IDs from transactionsToConfirm
    const transactionIds = transactionsToConfirm.map(transaction => transaction.ID);
    
    // Pass transactionIds and other relevant information to the confirmTransactions function
    confirmTransactions(transactionIds, studentName, course, studentID, stime);
    
    alert('Transactions confirmed successfully.');
});



function confirmTransactions(transactionIds, studentName, course, studentID, stime) {
    console.log(transactionIds); // Add this line

    $.ajax({
        url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirm_transact.php',
        method: 'POST',
        data: {
            professorName: '<?php echo $_SESSION['facultyName']; ?>',
            stime: stime,
            // Add other relevant data...
            studentName: studentName,
            course: course,
            studentID: studentID,
            transactionIds: transactionIds.join(','), // Convert array to comma-separated string
        },
        contentType: 'application/x-www-form-urlencoded',
        success: function (response) {
            // Update the status for the confirmed transactions
            transactionIds.forEach(function (id) {
                const key = `${studentName}-${studentID}-${course}-${stime}`;
                const transaction = transactionsByStudentAndStime[key].transactions.find(t => t.ID === id);
                if (transaction) {
                    transaction.status = 2; // Assuming 2 is the status for confirmed transactions
                }
            });

            // Handle the response from the server
            console.log(response); // Log the server response for debugging
        },
        error: function (error) {
            console.log('Error: ' + JSON.stringify(error));
        }
    });
}



            $('#transactionsList').on('click', '.rejectAllButton', function () {
                const studentName = $(this).data('student-name');
                const course = $(this).data('course');
                const studentID = $(this).data('student-id');
                const stime = $(this).data('stime');
                const key = `${studentName}-${studentID}-${course}-${stime}`;
                const studentCourseGroup = transactionsByStudentAndStime[key];

                const transactionsToReject = studentCourseGroup && studentCourseGroup.transactions ? studentCourseGroup.transactions : [];

                rejectAllTransactions(transactionsToReject, studentName, course, studentID);
            });

            function rejectAllTransactions(transactionsToReject, studentName, course, studentID) {
                const transactionIds = transactionsToReject.map(transaction => transaction.ID);

                $.ajax({
                    url: '/path/to/your/reject_all_script.php',
                    method: 'POST',
                    data: {
                        transactionIds: transactionIds,
                        professorId: professorID,
                        professorName: '<?php echo $_SESSION['facultyName']; ?>',
                        studentID: studentID,
                    },
                    success: function (response) {
                        // Handle the response from the server
                    }
                });
            }

            function filterAndDisplayTransactions() {
                // Implement your logic to filter and display transactions
            }

            function redirectToCoursesPage() {
                window.location.href = '/TIPTOOLROOmmalapitnadone/student/courses.html';
            }
        });
    </script>
</body>

</html>
