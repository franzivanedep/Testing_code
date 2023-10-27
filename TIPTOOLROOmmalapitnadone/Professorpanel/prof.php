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
                    const transactionHTML = data.transactions.map(function (transaction) {
                        return `<li>Student: ${transaction.studentname} - Course: ${transaction.courses} - Date: ${transaction.sdate} - Item: ${transaction.item} - Quantity: ${transaction.quantity} 
                        <button class="confirmButton" data-transaction-id="${transaction.ID}">Confirm</button>
                        <button class="rejectButton" data-transaction-id="${transaction.id}">Reject</button></li>`;
                    }).join('');

                    transactionsList.html(transactionHTML);
                }
            },
            error: function (error) {
                console.log('Error: ' + JSON.stringify(error));
            }
        });

        // Handle confirm button click
        $(document).on('click', '.confirmButton', function () {
    const transactionId = $(this).data('transaction-id');

    // Ensure that transactionId is set correctly
    if (transactionId !== undefined && transactionId !== "") {
        $.ajax({
            url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirm_transact.php',
            method: 'POST',
            data: {
                transactionId: transactionId,  // Make sure transactionId is set
                professorId: '<?php echo $_SESSION['facultyID']; ?>'
            },
            success: function (response) {
                // Handle the response from the server
            }
        });
    } else {
        console.log('transactionId is undefined or empty. Check your HTML data attributes.');
    }
});


        // Handle reject button click
        $(document).on('click', '.rejectButton', function () {
            const transactionId = $(this).data('transaction-id');

            $.ajax({
                url: '/path/to/your/reject_script.php',
                method: 'POST',
                data: {
                    transactionId: transactionId,
                    professorId: '<?php echo $_SESSION['facultyID']; ?>'
                },
                success: function (response) {
       // Handle the response from the server
       console.log(response); // Log the response for debugging
       // You can update the UI or display a success message here
   }

            });
        });
    });
    

    function redirectToCoursesPage() {
        // Redirect to the "courses.html" page
        window.location.href = '/TIPTOOLROOmmalapitnadone/student/courses.html';
    }
</script>

</body>
</html>
