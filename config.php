<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Default username is often 'root' for local development
define('DB_PASSWORD', ''); // Default password is often empty for local development
define('DB_NAME', 'task_manager');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>
