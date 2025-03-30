<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "mychandu";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to check if the current session is valid
function check_active_session($conn) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_id'])) {
        return false;
    }
    
    $user_id = $_SESSION['user_id'];
    $session_id = $_SESSION['session_id'];
    
    $query = "SELECT * FROM user_sessions 
              WHERE user_id = '$user_id' 
              AND session_id = '$session_id' 
              AND is_active = 1";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 0) {
        // Session is no longer active
        session_destroy();
        return false;
    }
    
    return true;
}
?> 