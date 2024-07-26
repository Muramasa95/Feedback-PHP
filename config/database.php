<?php 
    define('DB_HOST', 'host');
    define('DB_USER', 'user');
    define('DB_PASS', 'pass');
    define('DB_NAME', 'db');

    try {
        // Create conn
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // check conn
        if($conn->connect_error) {
            throw new Exception("connection failed: " . $conn->connect_error);
        }
        $_SESSION['conn'] = $conn;
    } catch (Exception $e) {
        echo 'Caught an exception: ' . $e->getMessage();
    }
?>