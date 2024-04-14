<?php
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables for tasks
$tasks = [];

// Get tasks for the logged-in user
$user_id = $_SESSION["id"];
$sql = "SELECT id, title, description, due_date, is_done FROM tasks WHERE user_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $title, $description, $due_date, $is_done);
            while ($stmt->fetch()) {
                $tasks[] = [
                    "id" => $id,
                    "title" => $title,
                    "description" => $description,
                    "due_date" => $due_date,
                    "is_done" => $is_done
                ];
            }
        }
    }
    $stmt->close();
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="wrapper">
        <h2>Task List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task["title"]; ?></td>
                        <td><?php echo $task["description"]; ?></td>
                        <td><?php echo $task["due_date"]; ?></td>
                        <td><?php echo $task["is_done"] ? 'Done' : 'Not Done'; ?></td>
                        <td>
                            <?php if (!$task["is_done"]): ?>
                                <a href="mark_done.php?id=<?php echo $task["id"]; ?>">Mark Done</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="add_task.php">Add New Task</a></p>
        <p><a href="logout.php" style="color:red;">Logout</a></p>
    </div>
</body>
</html>
