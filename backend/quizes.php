<?php
// Assuming a valid MySQL connection ($connection) is already established

// Get and sanitize user inputs
$category = isset($_GET['category']) ? mysqli_real_escape_string($connection, $_GET['category']) : '';
$difficulty = isset($_GET['difficulty']) ? mysqli_real_escape_string($connection, $_GET['difficulty']) : '';
$numQuizzes = isset($_GET['numQuizzes']) ? intval($_GET['numQuizzes']) : 5;
$multipleChoice = isset($_GET['multipleChoice']) ? 1 : 0;
$trueFalse = isset($_GET['trueFalse']) ? 1 : 0;
$multipleSelections = isset($_GET['multipleSelections']) ? 1 : 0;

// Start building the SQL query
$query = "SELECT * FROM quizzes WHERE 1=1";

// Apply filters to the query if they are set
if ($category) {
    $query .= " AND category = '$category'";
}
if ($difficulty) {
    $query .= " AND difficulty = '$difficulty'";
}
if ($multipleChoice) {
    $query .= " AND style = 'multipleChoice'";
}
if ($trueFalse) {
    $query .= " AND style = 'trueFalse'";
}
if ($multipleSelections) {
    $query .= " AND style = 'multipleSelections'";
}

// Add a limit to the number of quizzes
$query .= " LIMIT " . $numQuizzes;

// Execute the query
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    while ($quiz = mysqli_fetch_assoc($result)) {
        echo "<li class='list-group-item'>{$quiz['question']} - {$quiz['category']} - {$quiz['difficulty']}</li>";
    }
} else {
    echo "<li class='list-group-item'>No quizzes found matching your criteria.</li>";
}
?>
