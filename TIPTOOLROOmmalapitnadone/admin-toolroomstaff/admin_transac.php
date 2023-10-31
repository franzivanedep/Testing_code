<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmed Transactions</title>
</head>
<body>
    <h1>Confirmed Transactions</h1>
    <div id="confirmedTransactions"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Make an AJAX request to fetch confirmed transactions
            $.ajax({
                url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirmtransfer.php',
                method: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('#confirmedTransactions').html(data);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                }
            });
        });
    </script>
</body>
</html>
