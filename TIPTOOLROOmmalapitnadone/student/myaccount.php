<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TIP - Reservation Homepage</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/imageCSS.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .container-fluid {
            padding: 0;
        }
    
        .navbar-brand {
            font-size: 1.5rem;
        }
    
        .container_2 {
            background-color: #343a40;
            height: 18vw;
            display: flex;
            align-items: center;
        }
    
        .img_container_profile {
            margin-left: 35px;
        }
    
        .img_profile {
            height: 130px;
            width: 130px;
            border-radius: 50%;
            object-fit: cover;
        }
    
        .info_block {
            margin-left: 20px;
            font-size: large;
            color: white;
        }
    
        .menu_container {
            position: relative;
            height: 60px;
            width: 330px;
            top: 40px;
            text-align: top;
            margin-left: auto;
            text-align: right;
            margin-top: -200px;
        }
    
        .button-container {
            text-align: top;
            display: flex;
            justify-content: ;
            align-items: center;
            margin-right: 5px;
        }
    
        .borrow-button,
        .logout-button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border-radius: 0.5rem;
            border: none;
            color: #000;
            background-color: #ffc107;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: top;
        }
    
        .borrow-button:hover,
        .logout-button:hover {
            background-color: #ffca2a;
            color: #000;
        }
    
        .borrow-button:focus,
        .logout-button:focus {
            outline: none;
            box-shadow: 0 0 0 2px black;
        }
    
        .borrow-button {
            text-align: top;
            margin-right: 5px;
        }
    
        .logout-button {
            text-align: top;
            margin-right: 0;
            background-color: #ffc107;
        }
    
        .Notif-button {
            background-color: transparent;
        }
    
        .Notif-button img {
            height: 25px;
            width: 25px;
        }
    
        .container_3 {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
    
        .block1 {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    
        .borrow_history,
        .borrow_status {
            font-size: large;
            font-weight: bold;
            margin-top: 5px;
        }
    
        .data-container {
            overflow: auto;
            background-color: #eee;
            height: 280px;
            margin-top: 10px;
            padding: 5px;
            border-radius: 5px;
        }
    
        .data-container table {
            width: 100%;
            border-collapse: collapse;
        }
    
        .data-container table th,
        .data-container table td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
    
        .data-container table th {
            background-color: #f2f2f2;
        }
    
        .data-container table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    
    
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="#">TIP tool Room</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content-->
    <div class="container-fluid">
        <div class="container_2">
            <div class="img_container_profile">
                <img class="img_profile" src="https://via.placeholder.com/150" alt="Profile Picture" />
            </div>
            <div class="info_block">
            <div>Name: <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?></div>
            <div>Student ID: <?php echo isset($_SESSION['studentID']) ? $_SESSION['studentID'] : ''; ?></div>
            <div>Program: <?php echo isset($_SESSION['program']) ? $_SESSION['program'] : ''; ?></div>
            </div>
            
            
            <div class="menu_container">
                <div class="button-container">
                    <a href="\TIPTOOLROOmmalapitnadone\student\ecommerce.php" class="borrow-button">Borrow</a>
                    <a href="login.html" class="logout-button">Logout</a>
                </div>
                
            </div>
        </div>
        <div class="container_3">
            <div class="block1">
                <div class="borrow_history">Borrowing History</div>
                <div class="data-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Date Borrowed</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-05-01</td>
                                <td>2023-05-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-04-15</td>
                                <td>2023-05-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-04-01</td>
                                <td>2023-04-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-03-15</td>
                                <td>2023-04-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-03-01</td>
                                <td>2023-03-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-02-15</td>
                                <td>2023-03-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-02-01</td>
                                <td>2023-02-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-01-15</td>
                                <td>2023-02-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-01-01</td>
                                <td>2023-01-15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- ... Your previous code ... -->

        <div class="container_3">
            <!-- ... Your previous code ... -->

            <div class="block1">
                <div class="borrow_status">Borrowing Status</div>
                <div class="data-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Date Borrowed</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody id="statusTableBody">
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-05-01</td>
                                <td>2023-05-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-04-15</td>
                                <td>2023-05-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-04-01</td>
                                <td>2023-04-15</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-03-15</td>
                                <td>2023-04-01</td>
                            </tr>
                            <tr>
                                <td>Arlegui</td>
                                <td>2023-03-01</td>
                                <td>2023-03-15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tableBody = document.getElementById('statusTableBody');
            tableBody.addEventListener('click', function (event) {
                var target = event.target;
                if (target.tagName === 'TD') {
                    var row = target.parentElement;
                    // Retrieve the data from the clicked row
                    var campus = row.cells[0].innerText;
                    var dateBorrowed = row.cells[1].innerText;
                    var dueDate = row.cells[2].innerText;

                    // Example action: Open a new page with the row data
                    window.location.href = 'status.html?campus=' + encodeURIComponent(campus) +
                        '&dateBorrowed=' + encodeURIComponent(dateBorrowed) +
                        '&dueDate=' + encodeURIComponent(dueDate);
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var userNameElement = document.getElementById('userName');
    var studentIDElement = document.getElementById('studentID');
    var programElement = document.getElementById('program');
    
    // Check if session variables are set
    var userName = "<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>";
    var studentID = "<?php echo isset($_SESSION['studentID']) ? $_SESSION['studentID'] : '' ?>";
    var program = "<?php echo isset($_SESSION['program']) ? $_SESSION['program'] : '' ?>";
    
    // Update the content of the elements
    if (userNameElement) {
        userNameElement.textContent = "Name: " + userName;
    }
    if (studentIDElement) {
        studentIDElement.textContent = studentID;
    }
    if (programElement) {
        programElement.textContent = program;
    }
});

    </script>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
