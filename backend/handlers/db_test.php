<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = "localhost";
$db_user = "root";
$db_pass = "3132Num###";

try {
    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully to MySQL!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
