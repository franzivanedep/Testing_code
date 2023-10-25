<?php
session_start();

// Check if the user is already logged in (session is active)
if (isset($_SESSION['facultyID'])) {
    header("Location: /TIPTOOLROOmmalapitnadone/Professorpanel/prof.html"); // Redirect to the user's account page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $facultyID = $_POST['id_num']; // Faculty ID
    $enteredPassword = $_POST['password'];

    // Validate if the entered email is a valid Gmail address
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, '@tip.edu.ph') !== false) {
        // The email is valid and is a TIP Gmail address

        // Database connection details
        $servername = "localhost:3307";
        $username = "root";
        $db_password = "your_password"; // Replace with your actual MySQL password
        $dbname = "professor_db";

        // Create a new mysqli connection
        $conn = new mysqli($servername, $username, $db_password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query
        $sql = "SELECT id_num, password FROM professors WHERE email = ?";
        $stmt = $conn->prepare($sql);

        // Check if the query was prepared successfully
        if ($stmt) {
            // Binding parameters
            $stmt->bind_param("s", $email);

            // Execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $hashedPassword = $row['password'];

                    // Verify the entered password against the hashed password
                    if (password_verify($enteredPassword, $hashedPassword)) {
                        $_SESSION['facultyID'] = $row['id_num']; // Store faculty ID in the session
                        header("Location: /TIPTOOLROOmmalapitnadone/Professorpanel/prof.html"); // Redirect to the user's account page
                        exit();
                    } else {
                        // Invalid password; show a pop-up error message and redirect back
                        echo "<script>alert('Invalid password'); window.history.back();</script>";
                    }
                } else {
                    // User not found; show a pop-up error message and redirect back
                    echo "<script>alert('User not found'); window.history.back();</script>";
                }
            } else {
                // Error executing the SQL query
                echo "Error executing the query: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // Error preparing the SQL query
            echo "Error preparing the query: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // Invalid email address; show a pop-up error message and redirect back
        echo "<script>alert('Invalid email address. Please use a valid TIP Gmail address.'); window.history.back();</script>";
    }
}
?>
    