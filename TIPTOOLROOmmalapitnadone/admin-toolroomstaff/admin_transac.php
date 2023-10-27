<!-- Admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's Dashboard</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <header>
        <h1>Admin's Dashboard</h1>
    </header>
    <main>
        <section id="confirmedTransactions">
            <h2>Confirmed Transactions:</h2>
            <ul id="confirmedTransactionsList"></ul>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load confirmed transactions on page load
            loadConfirmedTransactions();
        });

        function loadConfirmedTransactions() {
            $.ajax({
                url: '/TIPTOOLROOmmalapitnadone/student/PHP/confirm_transact.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const confirmedTransactionsList = $('#confirmedTransactionsList');
                    confirmedTransactionsList.empty(); // Clear the list

                    if (data.error) {
                        confirmedTransactionsList.html('<li>Error fetching confirmed transactions.</li>');
                    } else if (data.transactions.length === 0) {
                        confirmedTransactionsList.html('<li>No confirmed transactions found.</li>');
                    } else {
                        data.transactions.forEach(function (transaction) {
                            const li = `<li>
                                Student: ${transaction.student_name}
                                - Course: ${transaction.courses}
                                - Date: ${transaction.transaction_date}
                                - Item: ${transaction.item}
                                - Quantity: ${transaction.quantity}
                                - Professor: ${transaction.professor_name}
                            </li>`;
                            confirmedTransactionsList.append(li);
                        });
                    }
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                }
            });
        }
    </script>
</body>
</html>
