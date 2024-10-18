<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PersonalNotes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' is provided
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the SQL statement to delete the note
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Note deleted successfully.";
    } else {
        echo "Error deleting note.";
    }

    $stmt->close();
} else {
    echo "No ID provided.";
}

$conn->close();
?>
