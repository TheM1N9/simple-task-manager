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

// Define variables and initialize with empty values
$title = $description = $due_date = "";
$title_err = $description_err = $due_date_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate description
    $description = trim($_POST["description"]);

    // Validate due date
    if (empty(trim($_POST["due_date"]))) {
        $due_date_err = "Please enter a due date.";
    } else {
        $due_date = trim($_POST["due_date"]);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($due_date_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO tasks (title, description, due_date, user_id) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_title, $param_description, $param_due_date, $param_user_id);

            // Set parameters
            $param_title = $title;
            $param_description = $description;
            $param_due_date = $due_date;
            $param_user_id = $_SESSION["id"]; // Get the user's ID from the session

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to task list page after adding task
                header("location: task_list.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add CSS styling -->
</head>
<body>
    <div class="wrapper">
        <h2>Add Task</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control">
                <span class="help-block"><?php echo $due_date_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Task">
            </div>
        </form>
    </div>
</body>
</html>
