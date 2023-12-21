<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Request</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Tip Toom Room</h2>
        <ul>
            <li><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="admin.php"><i class="fas fa-toolbox"></i> Items</a></li>
            <li><a href="admin_transac.php"><i class="fas fa-clipboard-list"></i> Request</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Students</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
        </ul>
    </div>
    <!-- Main content -->
    <div class="content">
        <h1>Student Request</h1>
        <div id="confirmedTransactions">
            <div id="loadingIndicator" style="display: none;">Loading...</div>
            <ul id="transactionList"></ul>
            <div id="actionButtons">
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to get username from local storage
            function getUsername() {
                return localStorage.getItem("username");
            }

            // Disable buttons initially
            $('#confirmButton, #rejectButton').prop('disabled', true);

            // Function to update button states based on selection
            function updateButtonStates() {
                const selectedTransactions = $('.transaction-checkbox:checked').length > 0;
                $('#confirmButton, #rejectButton').prop('disabled', !selectedTransactions);
            }

            // Handle checkbox selection changes
            $(document).on('change', '.transaction-checkbox', function () {
                updateButtonStates();
            });

            // Make an AJAX request to fetch confirmed transactions
            $.ajax({
                url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirmtransfer.php',
                method: 'GET',
                dataType: 'html',
                beforeSend: function() {
                    // Display loading indicator
                    $('#loadingIndicator').show();
                },
                success: function (data) {
                    $('#transactionList').html(data);
                },
                complete: function () {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                }
            });

            // Example: Retrieve and log the username from local storage
            const storedUsername = getUsername();
            console.log("Stored username:", storedUsername);
        });
    </script>
</body>
</html>
