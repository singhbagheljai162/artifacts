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

$cartId = isset($input['cart_id']) ? intval($input['cart_id']) : 0;

if ($cartId <= 0) {
    $response['message'] = 'Invalid cart ID provided.';
    echo json_encode($response);
    exit;
}else{
    $product = mysqli_query($conn, "SELECT * FROM cart WHERE id = '$cartId'");
    $productData = mysqli_fetch_assoc($product);
    if (!$productData) {
        $response['message'] = 'Artifact not found.';
        echo json_encode($response);
        exit;
    }else{
        mysqli_query($conn,"DELETE FROM cart WHERE id='$cartId' ");
        $response['success'] = true;
        $response['message'] = 'Artifact removed from cart successfully.';
    }

}

echo json_encode($response);
exit;