<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TIP - Reservation Homepage</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-tO1jOwNW3AZe8bDWZI8cZQGJZyZGfTyg5fZvUm/VF5ir6noFQa0CCdpMrgMWBbez8aLdEf+m6eU7Hs2AJJLBwQ==" crossorigin="anonymous"></script>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/imageCSS.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container-fluid">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="ecommerce.html">TIP Tool Room</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="ecommerce.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="myaccount.html">Account</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Items</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Items</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="computer.html">Computer Equipments</a></li>
                            <li><a class="dropdown-item" href="circuits.html">Electrical Equipments</a></li>
                            <li><a class="dropdown-item" href="handtools.html">Hand Tools</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- ========================= Checkout ========================= -->
<form class="d-flex" action="toolbox.html" method="get">
    <button class="btn btn-outline-dark" type="submit">
        <img src="images/toolbox-solid.svg" class="toolbox_logo" alt="" srcset="">
        Tool Box
        <span id="cartItemCount" class="badge bg-dark text-white ms-1 rounded-pill">0</span>
    </button>
</form>
<!-- ========================= Checkout END ========================= -->

            </div>
        </div>
    </nav>
    
        </div>
    </header>

    <?php
$servername = "localhost:3307";
$username = "root";
$db_password = "your_password"; // Replace with your actual MySQL password
$dbname = "item_db";

// Create a database connection
$conn = new mysqli($servername, $username, $db_password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch items from the database for the "Electrical Equipments" category
$categoryToDisplay = "Hand tools"; // Set the category to display
$sql = "SELECT * FROM items WHERE category = '$categoryToDisplay'";
$result = $conn->query($sql);

// Check if items were found
if ($result->num_rows > 0) {
    echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center'>"; // Use Bootstrap grid classes
    while ($row = $result->fetch_assoc()) {
        // Render each item with the appropriate CSS class
        echo "<div class='col mb-4'>";
        echo "<div class='card h-100'>";
        echo "<img class='card-img-top product-image' src='https://via.placeholder.com/300' alt='Product Image' />";
        echo "<div class='card-body p-3'>";
        echo "<h5 class='card-title fw-bolder'>" . $row["name"] . "</h5>";
        echo "<button class='btn btn-outline-dark add-to-cart' data-item-id='" . $row["id_num"] . "'>Add to Toolbox</button>";
        echo "</div></div></div>";
    }
    echo "</div>"; // Close the row
} else {
    echo "<p>No items found in the 'Electrical Equipments' category.</p>";
}

// Close the database connection
$conn->close();
?>

    </div>
        
        </div>
    </section>

    <div class="text-center mt-5">
        <nav id="pagination" aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li id="previousPage" class="page-item disabled">
                    <a class="page-link previous-button" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item page-number" id="page1"><a class="page-link" href="#">1</a></li>
                <li class="page-item page-number" id="page2"><a class="page-link" href="#">2</a></li>
                <li class="page-item page-number" id="page3"><a class="page-link" href="#">3</a></li>

                <li class="page-item" id="nextPage">
                    <a class="page-link next-button" href="#">Next</a>
                </li>
                
            </ul>
        </nav>
    </div>
    
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-M6E1eWk5vxiKMZLDu0AI+3tAOxatFC0CEt+3+0H8/2MqmFJF7DAjtR8UOQVjR7wXXx3mzlq1MDzt3nsMltxiUw==" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </section>
    <footer class="py-5 bg-dark">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-white-50">TIP Tool Room - ADEP Corp &copy; 2023</div>
        </div>
    </footer>
    </div>
    <script>
        $(document).ready(function () {
            updateCartItemCount();

            $(".add-to-cart").click(function () {
                var itemId = $(this).data("item-id");
                var itemName = $(this).closest(".card").find(".fw-bolder").text();
                var itemImage = $(this).closest(".card").find(".card-img-top").attr("src");

                var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
                var item = { id: itemId, name: itemName, image: itemImage, quantity: 1 };
                cartItems.push(item);
                localStorage.setItem("cartItems", JSON.stringify(cartItems));

                alert("Item with ID " + itemId + " added to cart!");
                updateCartItemCount();
            });

            function updateCartItemCount() {
                var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
                var cartItemCount = cartItems.length;
                $("#cartItemCount").text(cartItemCount);
            }
        });
    </script>
    <script>
$(document).ready(function () {
    var currentPage = 1;
    var totalPages = 3;

    $(".next-button").click(function (e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            // Remove active class from current page
            $("#page" + currentPage).removeClass("active");

            // Increment current page
            currentPage++;

            // Add active class to the next page
            $("#page" + currentPage).addClass("active");
        }
    });
});
</script>
    <!-- ...existing code... -->

<script>
    $(document).ready(function () {
        // Initialize variables
        var itemsPerPage = 4;
        var currentPage = 1;
        var totalItems = $(".col").length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        // Show/hide items based on current page
        function showItems() {
            var startIndex = (currentPage - 1) * itemsPerPage;
            var endIndex = startIndex + itemsPerPage;

            $(".col").hide().slice(startIndex, endIndex).show();
        }

        // Update navigation buttons
        function updateNavigation() {
            if (currentPage === 1) {
                $("#previousPage").addClass("disabled");
            } else {
                $("#previousPage").removeClass("disabled");
            }

            if (currentPage === totalPages) {
                $("#nextPage").addClass("disabled");
            } else {
                $("#nextPage").removeClass("disabled");
            }
        }

        // Show initial items and update navigation
        showItems();
        updateNavigation();

        // Previous button click event
        $("#previousPage").click(function (e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                showItems();
                updateNavigation();
            }
        });

        // Next button click event
        $("#nextPage").click(function (e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                showItems();
                updateNavigation();
            }
        });

        // ...existing code...
    });
</script>
<script>
$(document).ready(function () {
    var currentPage = 1;
    var totalPages = 3;

    $(".next-button").click(function (e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            // Remove active class from current page
            $("#page" + currentPage).removeClass("active");

            // Increment current page
            currentPage++;

            // Add active class to the next page
            $("#page" + currentPage).addClass("active");
        }
    });
});
</script>
<script>

$(document).ready(function () {
    var currentPage = 1;
    var totalPages = 3;

    $(".next-button").click(function (e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            // Remove active class from current page
            $("#page" + currentPage).removeClass("active");

            // Increment current page
            currentPage++;

            // Add active class to the next page
            $("#page" + currentPage).addClass("active");
        }
    });
});

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function () {
        var currentPage = 1;
        var totalPages = 3;

        $(".next-button").click(function (e) {
            e.preventDefault();

            if (currentPage < totalPages) {
                // Remove active class from current page
                $("#page" + currentPage).removeClass("active");

                // Increment current page
                currentPage++;

                // Add active class to the next page
                $("#page" + currentPage).addClass("active");
            }
        });

        $(".previous-button").click(function (e) {
            e.preventDefault();

            if (currentPage > 1) {
                // Remove active class from current page
                $("#page" + currentPage).removeClass("active");

                // Decrement current page
                currentPage--;

                // Add active class to the previous page
                $("#page" + currentPage).addClass("active");
            }
        });
    });
  </script>




<!-- ...existing code... -->

    
    
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="js/scripts.js"></script>


</body>
</html>
