<?php
// Set response header to JSON
header('Content-Type: application/json; charset=utf-8');

// Include database configuration (Checks parent directory first)
if (file_exists('../includes/config.php')) {
    require_once '../includes/config.php';
} elseif (file_exists('includes/config.php')) {
    require_once 'includes/config.php';
} else {
    echo json_encode(['success' => false, 'message' => 'Configuration file missing.']);
    exit;
}

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Parse JSON request body
$raw_input = file_get_contents('php://input');
$data = json_decode($raw_input, true);

// Fallback if request was sent as standard form-data
if (!$data) {
    $data = $_POST;
}

$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$quantity   = isset($data['quantity']) ? intval($data['quantity']) : 1;

// Input Validation
if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID specified.']);
    exit;
}

if ($quantity <= 0) {
    $quantity = 1;
}

// Fetch Product Details & Verify Existence
$product = null;
$stmt = $conn->prepare("SELECT id, product_name, price, stock FROM products WHERE id = ? LIMIT 1");

if ($stmt) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    // Fallback if prepared statements are disabled or columns differ
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id' LIMIT 1");
    if ($query) {
        $product = mysqli_fetch_assoc($query);
    }
}

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Artifact not found in catalog.']);
    exit;
}

// Check Stock Limits (Defaults to 999 if no stock column exists)
$available_stock = isset($product['stock']) ? intval($product['stock']) : 999;

$cardsql =mysqli_query($conn, "SELECT * FROM cart WHERE product_id = '$product_id' AND user_id = '".intval($_SESSION['user_id'])."'");
$existing_cart_item = mysqli_fetch_assoc($cardsql);

// Calculate requested quantity against existing quantity in cart
$current_cart_qty = $existing_cart_item ? intval($existing_cart_item['quantity']) : 0;
$new_total_qty   = $current_cart_qty + $quantity;

if ($new_total_qty > $available_stock) {
    $remaining_allowed = $available_stock - $current_cart_qty;
    if ($remaining_allowed <= 0) {
        $msg = "All available units of this artifact are already in your cart.";
    } else {
        $msg = "Only " . $remaining_allowed . " more unit(s) available in stock.";
    }
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

// Update Session Cart
$_SESSION['cart'][$product_id] = $new_total_qty;

// Sync to Database for Logged-In Users (If 'cart' table exists)
if (isset($_SESSION['user_id']) && intval($_SESSION['user_id']) > 0) {
    $user_id = intval($_SESSION['user_id']);
    
    $cart_table_check = mysqli_query($conn, "SHOW TABLES LIKE 'cart'");
    if ($cart_table_check && mysqli_num_rows($cart_table_check) > 0) {
        $check_existing = mysqli_query($conn, "SELECT id FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if ($check_existing && mysqli_num_rows($check_existing) > 0) {
            mysqli_query($conn, "UPDATE cart SET quantity = '$new_total_qty' WHERE user_id = '$user_id' AND product_id = '$product_id'");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$new_total_qty')");
        }
    }
}

// Calculate Total Cart Items Count
$total_cart_count = 0;
foreach ($_SESSION['cart'] as $item_qty) {
    $total_cart_count += intval($item_qty);
}

// Return JSON Success Response
echo json_encode([
    'success'     => true,
    'message'     => 'Artifact added to cart successfully.',
    'cart_count'  => $total_cart_count,
    'product_id'  => $product_id,
    'quantity'    => $new_total_qty
]);
exit;