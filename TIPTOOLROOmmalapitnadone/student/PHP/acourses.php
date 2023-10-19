<?php
$servername = "localhost:3307";
$username = "root";
$db_password = ""; // Replace with your actual MySQL password
$dbname = "professor_db";

$conn = new mysqli($servername, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_num = $_POST['professor'];

$sql = "SELECT CID, Course_Code FROM courses WHERE profID = $id_num";
$result = $conn->query($sql);

$courses = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $course = array(
            "CID" => $row["CID"],
            "Course_Code" => $row["Course_Code"]
        );
        $courses[] = $course;
    }
}

$conn->close();

echo json_encode($courses);
?>
