<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $studentID = $_POST['id_num']; // Student ID
    $enteredPassword = $_POST['password'];

    // Validate if the entered email is a valid Gmail address
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, '@tip.edu.ph') !== false) {
        // The email is valid and is a TIP Gmail address

        // Database connection details
        $servername = "localhost:3307";
        $username = "root";
        $db_password = "your_password"; // Replace with your actual MySQL password
        $dbname = "student_db";

        // Create a new mysqli connection
        $conn = new mysqli($servername, $username, $db_password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query
        $sql = "SELECT id_num, password, first_name, last_name, program FROM student WHERE email = ?";
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
                        // Store user's details in the session
                        $_SESSION['studentID'] = $row['id_num'];
                        $_SESSION['name'] = $row['first_name'] . ' ' . $row['last_name'];
                        $_SESSION['program'] = $row['program'];
                        $_SESSION['email'] = $email;
                    
                        // Redirect to myaccount.php
                        header("Location: \TIPTOOLROOmmalapitnadone\student\myaccount.php");
                        exit();
                    } else {
                        // Invalid password; send an error response
                        echo json_encode(array("success" => false, "message" => "Invalid password"));
                    }
                } else {
                    // User not found; send an error response
                    echo json_encode(array("success" => false, "message" => "User not found"));
                }
            } else {
                // Error executing the SQL query
                echo json_encode(array("success" => false, "message" => "Error executing the query: " . $stmt->error));
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // Error preparing the SQL query
            echo json_encode(array("success" => false, "message" => "Error preparing the query: " . $conn->error));
        }

        // Close the database connection
        $conn->close();
    } else {
        // Invalid email address; send an error response
        echo json_encode(array("success" => false, "message" => "Invalid email address. Please use a valid TIP Gmail address."));
    }
}

?>
