<?php
// Return JSON response headers
header('Content-Type: application/json');

// Include global database configuration (relative to /api/ directory)
require_once '../includes/config.php';

// Default JSON response structure
$response = [
    'success' => false,
    'message' => ''
];

// Decode raw JSON POST input
$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);

if (!$input) {
    $response['message'] = 'Invalid JSON request payload.';
    echo json_encode($response);
    exit;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if ($user_id <= 0) {
    $response['message'] = 'User not found.';
    echo json_encode($response);
    exit;
}else{
    $cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
    $cartData = mysqli_fetch_assoc($cart);
    if (!$cartData) {
        $response['message'] = 'Artifact not found.';
        echo json_encode($response);
        exit;
    }else{
        mysqli_query($conn,"DELETE FROM cart WHERE user_id='$user_id' ");
        $response['success'] = true;
        $response['message'] = 'Artifact removed from cart successfully.';
    }

}

echo json_encode($response);
exit;