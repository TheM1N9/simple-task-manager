<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add CSS styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .page-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .link {
            color: #007bff;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        p {
            margin-bottom: 10px;
        }

        .quote-container {
            margin-top: 50px;
            text-align: center;
        }

        .quote {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>What would you like to do?</p>
        <a href="add_task.php" class="btn">Add New Task</a>
        <p>or</p>
        <a href="task_list.php" class="link">View Task List</a>
        <p>or</p>
        <a href="logout.php" class="link" style="color:red;">Logout</a>

        <div class="quote-container">
            <p class="quote">"The way to get started is to quit talking and begin doing." - Walt Disney</p>
            <p class="quote">"Success is not final, failure is not fatal: It is the courage to continue that counts." - Winston Churchill</p>
            <p class="quote">"You are never too old to set another goal or to dream a new dream." - C.S. Lewis</p>
            <!-- Add more quotes here -->
        </div>
    </div>
</body>
</html>

