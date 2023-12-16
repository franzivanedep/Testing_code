<?php
$servername = "localhost:3307";
$username = "root";
$db_password = ""; // Replace with your actual MySQL password
$dbname = "tiptoolroom_db";

$conn = new mysqli($servername, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_num = $_POST['professor'];

// Use a prepared statement to prevent SQL injection
$sql = "SELECT CID, Course_Code, Course_Section FROM courses WHERE profID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_num);
$stmt->execute();

$result = $stmt->get_result();

$courses = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $course = array(
            "CID" => $row["CID"],
            "Course_Code" => $row["Course_Code"],
            "Course_Section" => $row["Course_Section"]
        );
        $courses[] = $course;
    }
}

$conn->close();

echo json_encode($courses);
?>
