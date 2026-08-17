<?php
header('Content-Type: application/json; charset=utf-8');

// Include config file
require_once "../includes/config.php";

// Verify User Authentication
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please sign in to manage your watchlist.']);
    exit;
}

// Parse JSON payload
$raw_input = file_get_contents('php://input');
$data = json_decode($raw_input, true);

if (!$data) {
    $data = $_POST;
}

$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$action     = isset($data['action']) ? trim($data['action']) : '';

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product selected.']);
    exit;
}

// Detect Table Name (watchlist vs wishlist)
$table_name = 'wishlist';
$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'wishlist'");
if (!$table_check || mysqli_num_rows($table_check) === 0) {
    $table_check_wishlist = mysqli_query($conn, "SHOW TABLES LIKE 'wishlist'");
    if ($table_check_wishlist && mysqli_num_rows($table_check_wishlist) > 0) {
        $table_name = 'wishlist';
    }
}

// Check if item is already in table
$check_qr = mysqli_query($conn, "SELECT id FROM {$table_name} WHERE user_id = '$user_id' AND product_id = '$product_id'");
$exists = ($check_qr && mysqli_num_rows($check_qr) > 0);

if ($action === 'add' || (!$exists && empty($action))) {
    if (!$exists) {
        $insert = mysqli_query($conn, "INSERT INTO {$table_name} (user_id, product_id) VALUES ('$user_id', '$product_id')");
        if (!$insert) {
            echo json_encode(['success' => false, 'message' => 'Failed to add item to watchlist.']);
            exit;
        }
    }
    echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Item added to watchlist.']);
    exit;
} else {
    if ($exists) {
        $delete = mysqli_query($conn, "DELETE FROM {$table_name} WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (!$delete) {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item from watchlist.']);
            exit;
        }
    }
    echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Item removed from watchlist.']);
    exit;
}