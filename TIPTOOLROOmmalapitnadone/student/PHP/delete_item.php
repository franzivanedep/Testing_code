<?php
$servername = "localhost:3307";
$username = "root";
$password = "your_password"; // Replace with your actual MySQL password
$dbname = "tiptoolroom_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); // Ensure $item_id is an integer

    // Check if $item_id is a valid integer
    if ($item_id > 0) {
        // Delete the item from the database
        $sql = "DELETE FROM items WHERE id_num = ?"; // Use 'id_num' instead of 'id'
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Error handling for prepare
            echo "Error: " . $conn->error;
        } else {
            $stmt->bind_param("i", $item_id);

            if ($stmt->execute()) {
                // Item deleted successfully
                echo "Item deleted successfully.";
                echo "<script>
                        alert('Item deleted successfully.');
                        window.location.href = '/TIPTOOLROOmmalapitnadone/admin-toolroomstaff/admin.php'; // Redirect back to admin.php
                      </script>";
                exit;
            } else {
                // Error handling for execute
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "Invalid item ID.";
    }
} else {
    echo "Item ID not provided.";
}

// Close the database connection
$conn->close();
?>
