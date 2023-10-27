<?php
session_start();

if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = '';
    $_SESSION['email'] = '';
    $_SESSION['facultyID'] = '';
    $_SESSION['department'] = '';
    $_SESSION['program'] = '';
    $_SESSION['password'] = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $id_num = $_POST['id_num'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $password = $_POST['password'];

    $_SESSION['name'] = $fname . ' ' . $lname;
    $_SESSION['email'] = $email;
    $_SESSION['facultyID'] = $id_num;
    $_SESSION['department'] = $department;
    $_SESSION['program'] = $program;

    // Hash the user's password
    $plainPassword = $_POST['password']; // Get the plain password from the user
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT); // Hash the password

// Store $hashedPassword in the database along with other user details


    $servername = "localhost:3307";
    $username = "root";
    $db_password = "your_password"; // Replace with your actual MySQL password
    $dbname = "professor_db";
 
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first_name = "";
    $last_name = "";

    if ($_SESSION['name']) {
        list($first_name, $last_name) = explode(' ', $_SESSION['name']);
    }

    $sql = "INSERT INTO professors (id_num, first_name, last_name, department, email, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $_SESSION['facultyID'], $first_name, $last_name, $_SESSION['program'], $_SESSION['email'], $hashedPassword); // Use hashed password

    if ($stmt->execute()) {
        $_SESSION['facultyName'] = $_SESSION['name'];

        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: \TIPTOOLROOmmalapitnadone\Professorpanel\prof.php?name=" . urlencode("$fname $lname"));
    exit();
}
?>
