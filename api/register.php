<?php
header('Content-Type: application/json; charset=utf-8');

// Include config file
if (file_exists('../includes/config.php')) {
    require_once '../includes/config.php';
} elseif (file_exists('includes/config.php')) {
    require_once 'includes/config.php';
} else {
    echo json_encode(['success' => false, 'message' => 'Configuration file missing.']);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Parse incoming payload
$raw_input = file_get_contents('php://input');
$data = json_decode($raw_input, true);
if (!$data) {
    $data = $_POST;
}

$first_name = isset($data['first_name']) ? mysqli_real_escape_string($conn, trim($data['first_name'])) : '';
$last_name  = isset($data['last_name'])  ? mysqli_real_escape_string($conn, trim($data['last_name']))  : '';
$email      = isset($data['email'])      ? mysqli_real_escape_string($conn, trim($data['email']))      : '';
$password   = isset($data['password'])   ? trim($data['password'])                                     : '';
$interest   = isset($data['interest'])   ? mysqli_real_escape_string($conn, trim($data['interest']))   : '';

if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

$full_name = $first_name . " " . $last_name;

// Check existing account
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if ($check && mysqli_num_rows($check) > 0) {
    echo json_encode(['success' => false, 'message' => 'Email address already exists.']);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (full_name, email, password, role, status) VALUES ('$full_name', '$email', '$hashed_password', 'Customer', 'Active')";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Please sign in.'
    ]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'An error occurred during account creation.']);
    exit;
}