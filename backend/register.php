<?php
require 'config.php'; // Include database configuration

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $conn = getDbConnection();

    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $birthdate = $_POST['birthdate']; // Get the birthdate from the form

    // Validate if password and confirm password match
    if ($pass !== $confirm_pass) {
        echo "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $sql = "SELECT * FROM users WHERE username='$user' OR email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Username or Email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert data into the database
            $insert_sql = "INSERT INTO users (username, email, password, birthdate) 
                           VALUES ('$user', '$email', '$hashed_password', '$birthdate')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "Registration successful!";
                // Optionally redirect to login page after successful registration
                //header("Location: login.php");
                exit;
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    }

    // Close the database connection
    $conn->close();
}
?>
