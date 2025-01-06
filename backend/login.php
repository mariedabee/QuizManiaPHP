<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  // Enable error reporting for debugging

session_start();
require 'config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Establish database connection
$conn = getDbConnection();

$username = $_POST['username'];
$password = $_POST['password'];

    // Validate input (both fields are required)
    if (empty($username) || empty($password)) {
        echo "Both fields are required.";
        exit;
    }

    // Use prepared statements to securely query the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if ($stmt === false) {
        echo "Error preparing query: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $username); // Bind the username to the prepared statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login: Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Login successful! Welcome, " . htmlspecialchars($user['username']) . ".";
            // Optionally redirect to another page after login
            // header("Location: dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();  // Close prepared statement
    $conn->close();  // Close database connection
}
?>
