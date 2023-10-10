<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $id_num = $_POST['id_num'];
    $phone = $_POST['phone'];
    $program = $_POST['program'];
    $password = $_POST['password'];

    $_SESSION['name'] = $fname . ' ' . $lname;
    $_SESSION['email'] = $email;
    $_SESSION['studentID'] = $id_num;
    $_SESSION['phoneNo'] = $phone;
    $_SESSION['program'] = $program;
    $_SESSION['password'] = $password;

    $servername = "localhost:3307";
    $username = "root";
    $db_password = "your_password"; // Replace with your actual MySQL password
    $dbname = "student_db";
 
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first_name = "";
    $last_name = "";

    if ($_SESSION['name']) {
        list($first_name, $last_name) = explode(' ', $_SESSION['name']);
    }

    $sql = "INSERT INTO student (id_num, first_name, last_name, program, email, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $_SESSION['studentID'], $first_name, $last_name, $_SESSION['program'], $_SESSION['email'], $_SESSION['password']);


    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: student\myaccount.html");
    exit();
}
?>
