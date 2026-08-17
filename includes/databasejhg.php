<?php
require_once 'config.php';

// Create Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set Character Encoding
$conn->set_charset("utf8");
?>