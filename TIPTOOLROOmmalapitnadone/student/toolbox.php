<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TIP - TOOL BOX</title>
    <!-- Favicon-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap CSS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-tO1jOwNW3AZe8bDWZI8cZQGJZyZGfTyg5fZvUm/VF5ir6noFQa0CCdpMrgMWBbez8aLdEf+m6eU7Hs2AJJLBwQ==" crossorigin="anonymous"></script>

    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/imageCSS.css">
    <link rel="stylesheet" href="css/cartStyles.css">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="ecommerce.php">TIP Tool Room</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="ecommerce.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Items</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Items</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Computer Equipments</a></li>
                                <li><a class="dropdown-item" href="circuits.html">Electrical Equipments</a></li>
                                <li><a class="dropdown-item" href="#!">Hand Tools</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                  session_start(); // Start the session
                  
                  //==========================================
                  
                  if (!isset($_SESSION['studentID'])) {
                      // Redirect to login.html
                      header("Location: login.html");
                      exit();
                  }
                  
                
                
                
                ?>
                    <!-- Checkout -->
                    <form class="d-flex" action="toolbox.html" method="get">
                        <button class="btn btn-outline-dark" type="submit">
                            <img src="images/toolbox-solid.svg" class="toolbox_logo" alt="" srcset="">
                            Tool Box
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                    <!-- Checkout END -->
                </div>
            </div>
        </nav>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">TOOL BOX</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Review and manage your items</p>
                </div>
            </div>
        </header>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- Shopping cart items -->
                                <div id="cartItems">
                                    <!-- Cart item 1 -->
                                    <div class="cart-item">
                                        <!-- Add more cart items here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- Professors dropdown -->
                                <div class="dropdown mb-3">
                                    <h3>Summary</h3>
			 					<!-- Replace the summary section with two drop-down menus -->
			 					<div class="form-group">
    <label for="Professors">Professors:</label>
            <select class="form-control" id="professors">
            <?php
                  session_start(); // Start the session
                  
                
                  
                $servername = "localhost:3307";
                $username = "root";
                $db_password = ""; // Replace with your actual MySQL password
                $dbname = "tiptoolroom_db";

                $conn = new mysqli($servername, $username, $db_password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id_num, first_name, last_name FROM professors";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id_num = $row["id_num"];
                        $fullName = $row["first_name"] . " " . $row["last_name"];
                        echo '<option value="' . $id_num . '">' . $fullName . '</option>';
                    }
                } else {
                    echo "No professors found";
                }
                $conn->close();

                ?>
              
            </select>
        </div>
        <div class="form-group">
            <label for="courses">Courses:</label>
            <select class="form-control" id="courses">
                <!-- Options will be populated dynamically with JavaScript -->
            </select>
        </div>

        <script>
                let selectedCourseCode = ''; // Default values
                    let selectedCourseSection = ''; // Default values


           document.addEventListener("DOMContentLoaded", function () {
    const professorsDropdown = document.getElementById("professors");
    const coursesDropdown = document.getElementById("courses");
    

    professorsDropdown.addEventListener("change", function () {
        const selectedProfessor = professorsDropdown.value;

        if (selectedProfessor) {
            // Make an AJAX request to fetch courses based on the selected professor
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "PHP/acourses.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Clear existing options
                    coursesDropdown.innerHTML = '';

                    if (response.length > 0) {
                        response.forEach(function (course) {
    const option = document.createElement("option");
    option.value = course.CID;
    option.text = course.Course_Code + ' ' + course.Course_Section;
    option.dataset.courseCode = course.Course_Code; // Make sure this is correctly set
    option.dataset.courseSection = course.Course_Section; // Make sure this is correctly set
    coursesDropdown.appendChild(option);
});


                    } else {
                        const option = document.createElement("option");
                        option.text = "No courses found";
                        coursesDropdown.appendChild(option);
                    }
                }
            };

            xhr.send("professor=" + selectedProfessor);
        } else {
            coursesDropdown.innerHTML = '<option value="">Select a professor first</option>';
        }
    });

 // Inside the coursesDropdown change event listener
// Inside the coursesDropdown change event listener
coursesDropdown.addEventListener("change", function () {
    // Get the selected course
    const selectedCourseIndex = coursesDropdown.selectedIndex;
    const selectedCourseOption = coursesDropdown.options[selectedCourseIndex];
    const selectedCourseCode = selectedCourseOption.dataset.courseCode; // Get course_code
    const selectedCourseSection = selectedCourseOption.dataset.courseSection; // Get course_section

    // Update the selected course code and section in localStorage
    localStorage.setItem("selectedCourseCode", selectedCourseCode);
    localStorage.setItem("selectedCourseSection", selectedCourseSection);

    console.log("Selected Course Code:", selectedCourseCode);
    console.log("Selected Course Section:", selectedCourseSection);

    // Load cart items from local storage

    // Update the "Checkout" button's href with the generated URL
    updateCheckoutURL();
});


});


        </script>

        <a class="btn btn-primary" id="checkoutBtn" href="insert_transact.php?studentName=<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>&studentID=<?php echo isset($_SESSION['studentID']) ? $_SESSION['studentID'] : ''; ?>&Course_Code=<?php echo isset($_SESSION['Course_Code']) ? $_SESSION['Course_Code'] : ''; ?>&selectedItems=<?php echo isset($_SESSION['selectedItems']) ? json_encode($_SESSION['selectedItems']) : '[]'; ?>">Checkout</a>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5">
                <div class="small text-center text-white-50">TIP Tool Room - ADEP Corp &copy; 2023</div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-M6E1eWk5vxiKMZLDu0AI+3tAOxatFC0CEt+3+0H8/2MqmFJF7DAjtR8UOQVjR7wXXx3mzlq1MDzt3nsMltxiUw==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
    // Load cart items from local storage
    var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    // Display cart items
    for (var i = 0; i < cartItems.length; i++) {
        var item = cartItems[i];
        var cartItemHtml = '<div class="cart-item">' +
            '<div> <div style="display: flex; justify-content: space-between;"> <div style="font-weight:bold; font-size:x-large;">Item</div> <div style="position:relative; right:100px; font-weight:bold; font-size:x-large; ">Quantity</div> </div> </div>'+
            '<div class="d-flex justify-content-between">' +
            '<div class="cart-item-image-container">' +
            '<img class="cart-item-image" src="' + item.images + '" alt="..." />' +
            '</div>' +
            '<div class="flex-grow-1" style="margin:auto;" >' +
            '<h5 style="margin-left:10px;" class="cart-item-title">' + item.name + '</h5>' +
            '</div>' +
            '<div style="margin:auto;" class="quantity">' +
            '<input style="margin-right:10px; width:50px;" type="number" class="cart-item-quantity" value="' + item.quantity + '" min="1" />' +
            '</div>' +
            '<div style="margin:auto;">' +
            '<button class="btn btn-outline-dark remove-from-cart" data-item-id="' + item.id + '">Remove</button>' +
            '</div>' +
            '</div>' +
            '</div>';
        $("#cartItems").append(cartItemHtml);
    }

    // Update item quantity in cart
    $(document).on('change', '.cart-item-quantity', function() {
        var itemId = $(this).closest('.cart-item').find('.remove-from-cart').data('item-id');
        var quantity = parseInt($(this).val());
        for (var i = 0; i < cartItems.length; i++) {
            if (cartItems[i].id === itemId) {
                cartItems[i].quantity = quantity;
                break;
            }
        }
        localStorage.setItem("cartItems", JSON.stringify(cartItems));
    });

    // Remove item from cart
    $(document).on('click', '.remove-from-cart', function() {
        var itemId = $(this).data("item-id");
        cartItems = cartItems.filter(function (item) {
            return item.id !== itemId;
        });
        localStorage.setItem("cartItems", JSON.stringify(cartItems));
        $(this).closest(".cart-item").remove();
        alert("Item with ID " + itemId + " removed from cart!");
    });
});

// Create a function to generate the checkout URL
$(document).ready(function () {
    // Load cart items from local storage
    var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    console.log("Cart Items:", cartItems);

    // Display cart items
    for (var i = 0; i < cartItems.length; i++) {
        // ... (your existing code)
    }
    
    // Update the "Checkout" button's href with the generated URL
    $("#checkoutBtn").attr("href", generateCheckoutURL(cartItems));
    

    
});

// Create a function to generate the checkout URL
// Inside the document ready function
updateCheckoutURL();

// Create a function to update the "Checkout" button's href
function updateCheckoutURL() {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const studentName = encodeURIComponent(localStorage.getItem('name'));
    const studentID = localStorage.getItem('studentID');
    const selectedCourseCode = localStorage.getItem('selectedCourseCode');
    const selectedCourseSection = localStorage.getItem('selectedCourseSection');

    // Ensure these values are not empty
    if (!studentName || !studentID || !selectedCourseCode || !selectedCourseSection) {
        console.error("Required data missing.");
        return; // Handle this error as needed
    }

    const baseURL = "PHP/insert_transac.php";
    const selectedItems = JSON.stringify(cartItems);

    // Generate the URL with query parameters
    const checkoutURL = `${baseURL}?studentName=${studentName}&studentID=${studentID}&Course_Code=${selectedCourseCode}&Course_Section=${selectedCourseSection}&selectedItems=${selectedItems}`;

    console.log("Generated URL:", checkoutURL);

    // Update the "Checkout" button's href
    $("#checkoutBtn").attr("href", checkoutURL);
}



    </script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-tO1jOwNW3AZe8bDWZI8cZQGJZyZGfTyg5fZvUm/VF5ir6noFQa0CCdpMrgMWBbez8aLdEf+m6eU7Hs2AJJLBwQ==" crossorigin="anonymous"></script>

</body>

</html>
