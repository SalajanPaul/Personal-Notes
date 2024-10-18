<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personalnotes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notes from the database
$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each note
    while ($row = $result->fetch_assoc()) {
        echo "<div class='note'>";
        echo "<h5>" . $row["title"] . "</h5>";
        echo "<p>" . $row["content"] . "</p>";
        echo "<small>Created At: " . $row["created_at"] . "</small>";
        echo "<button class='btn btn-danger btn-sm delete-note' data-id='" . $row['id'] . "'>Delete</button>";
        echo "</div><hr>";
    }
} else {
    echo "No notes found.";
}

$conn->close();
?>
