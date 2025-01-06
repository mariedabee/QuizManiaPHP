<?php
$servername = "localhost";
$username = "root";  // Default MySQL user for XAMPP
$password = "";      // Default is empty
$dbname = "QuizApp"; // The name of your database

// Function to establish a database connection
function getDbConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
