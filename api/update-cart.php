<?php
// Return JSON response headers
header('Content-Type: application/json');

// Include global database configuration (relative to /api/ directory)
require_once '../includes/config.php';


// Default JSON response structure
$response = [
    'success' => false,
    'message' => '',
    'cart_count' => 0,
    'item_subtotal' => '0.00',
    'cart_subtotal' => '0.00',
    'shipping_cost' => 0,
    'cart_grand_total' => '0.00'
];

// Decode raw JSON POST input
$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);

if (!$input) {
    $response['message'] = 'Invalid JSON request payload.';
    echo json_encode($response);
    exit;
}

$action = isset($input['action']) ? trim($input['action']) : 'update';

// -------------------------------------------------------------
// 2. ACTION: UPDATE ITEM QUANTITY
// -------------------------------------------------------------
$cartId = isset($input['cart_id']) ? intval($input['cart_id']) : 0;
$quantity  = isset($input['quantity']) ? intval($input['quantity']) : 0;

if ($cartId <= 0) {
    $response['message'] = 'Invalid cart ID provided.';
    echo json_encode($response);
    exit;
}

// -------------------------------------------------------------
// 3. RECALCULATE CART TOTALS FROM DATABASE
// -------------------------------------------------------------
$cartCount = 0;
$subtotal = 0.0;
$requestedItemSubtotal = 0.0;



if (!empty($cartId)) {
    $query = "SELECT cart.id, products.price, products.stock, cart.quantity FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.id=$cartId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pId = intval($row['id']);
            $price = floatval($row['price']);
            $stock = intval($row['stock']);
            $qty = intval($row['quantity']);
            if ($action === 'increase') {
                // Ensure the quantity does not exceed stock
                $qty = min($quantity, $stock);
                // Update the cart quantity in the database
                mysqli_query($conn, "UPDATE cart SET quantity=$qty WHERE id=$pId");
            }else if ($action === 'decrease') {
                // Ensure the quantity does not go below 1
                $qty = max($quantity, 1);
                // Update the cart quantity in the database
                mysqli_query($conn, "UPDATE cart SET quantity=$qty WHERE id=$pId");
            }

            $itemTotal = $price * $qty;
            $subtotal += $itemTotal;
            $cartCount += $qty;

            if ($pId === $cartId) {
                $requestedItemSubtotal = $itemTotal;
            }
        }
    }
}


// -------------------------------------------------------------
// 4. SHIPPING & GRAND TOTAL CALCULATIONS
// -------------------------------------------------------------
// Free white-glove insured transport on orders of $1,000 or more
$shippingThreshold = 1000.0;
$shippingCost = ($subtotal >= $shippingThreshold || $subtotal == 0) ? 0 : 150;
$grandTotal = $subtotal + $shippingCost;

// -------------------------------------------------------------
// 5. RETURN JSON RESPONSE
// -------------------------------------------------------------

$cartQuery = mysqli_query($conn, "SELECT SUM(products.price*cart.quantity) AS sub_ttl FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id='" . intval($_SESSION['user_id']) . "'");
$newData = mysqli_fetch_array($cartQuery);

$response['success'] = true;
$response['cart_count'] = $cartCount;
$response['item_subtotal'] = number_format($requestedItemSubtotal, 2, '.', '');
$response['cart_subtotal'] = number_format($newData['sub_ttl'], 2, '.', '');
$response['shipping_cost'] = $shippingCost;
$response['cart_grand_total'] = number_format($grandTotal, 2, '.', '');

echo json_encode($response);
exit;