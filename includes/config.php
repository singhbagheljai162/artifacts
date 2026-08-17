<?php
// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Website Configuration
define('SITE_NAME', 'Artifact Store');
define('SITE_URL', 'http://localhost:8080/artifacts/');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'artifacts');
define('DB_USER', 'root');
define('DB_PASS', '');

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");