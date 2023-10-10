<?php
// include database connection file
include_once("config.php");

// Get id from URL to delete that user
$id_num = $_GET['id_num'];

// Delete user row from table based on given id
$result = mysqli_query($mysqli, "DELETE FROM users WHERE id_num=$id_num");

// After delete redirect to Home, so that latest user list will be displayed.
header("Location:index.php");
?>
