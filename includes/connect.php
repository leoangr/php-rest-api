<?php 
require_once __DIR__ . '/../helper/router-check.php';
require_once __DIR__ . '/../helper/env-connect.php';

$server = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

$conn = new mysqli($server, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>