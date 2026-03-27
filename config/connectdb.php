<?php 
// ensuring to set character to handle special characters
$charset = 'utf8mb4';

// checking if running locally (XAMPP) or on university server
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1' || $_SERVER['SERVER_PORT'] == '8000') {
    // localhost via xampp default
    $db_host = 'localhost';
    $db_name = 'astoncv';
    $username = 'root';
    $password = '';
} else {
    // university server (credentials in credentials.php to prevent unauthorized access) 
    require_once 'credentials.php'; 
    
    $db_host = $livedb_host;
    $db_name = $livedb_name;
    $username = $liveusername;
    $password = $livepassword;
}

try {
    // establish a pdo connection for security
    $db = new PDO("mysql:dbname=$db_name;host=$db_host;charset=$charset", $username, $password); 
    // to catch any database crashes
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    echo("Failed to connect to the database.<br>");
    echo($ex->getMessage());
    exit;
}
?>