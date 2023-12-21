<?php
$servername = "localhost:3307";
$username = "root";
$password = ""; // Replace with your actual MySQL password
$dbname = "tiptoolroom_db";

$itemName = $_POST['itemName'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT category FROM items WHERE item_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $itemName);
$stmt->execute();
$stmt->bind_result($category);

if ($stmt->fetch()) {
    echo $category;
} else {
    echo "Category not found";
}

$stmt->close();
$conn->close();
?>
