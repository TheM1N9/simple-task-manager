<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Check if task ID parameter exists
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Prepare an update statement
    $sql = "UPDATE tasks SET is_done = 1 WHERE id = ? AND user_id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ii", $param_id, $param_user_id);

        // Set parameters
        $param_id = trim($_GET["id"]);
        $param_user_id = $_SESSION["id"];

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to task list page after updating task
            header("location: task_list.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
?>
