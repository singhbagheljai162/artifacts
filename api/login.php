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

$email    = isset($data['email']) ? mysqli_real_escape_string($conn, trim($data['email'])) : '';
$password = isset($data['password']) ? trim($data['password']) : '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please enter both email and password.']);
    exit;
}

// Fetch user matching role & status
$sql = "SELECT * FROM users WHERE email='$email' AND status='Active' AND role='Customer' LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email']     = $user['email'];
        $_SESSION['role']      = $user['role'];

        echo json_encode([
            'success'  => true,
            'message'  => 'Authentication successful. Redirecting to vault...',
            'redirect' => 'profile.php'
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password specified.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email not found or account inactive.']);
    exit;
}