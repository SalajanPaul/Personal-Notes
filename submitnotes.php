<?php

$servername = "localhost"; // or your database server
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "personalnotes"; // the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    // Execute the statement
    if ($stmt->execute()) {
        // header("Location: index.html");
        echo json_encode(['success' => true, 'message' => 'New note created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>