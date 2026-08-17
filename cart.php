<?php
include 'includes/config.php';


$cartqry=mysqli_query($conn, "SELECT cart.id AS cart_id,
cart.quantity,products.* FROM cart INNER JOIN products ON products.id=cart.product_id WHERE user_id = '".$_SESSION['user_id']."'");

$cartItems = [];
$subtotal = 0;

if ($cartqry && mysqli_num_rows($cartqry) > 0) {
    while ($row = mysqli_fetch_assoc($cartqry)) {
        $row['item_total']= floatval($row['price']) * intval($row['quantity']);
        $cartItems[] = $row;

        $subtotal += $row['item_total'];
    }
}


// Shipping logic: Free white-glove transport on orders over $1,000
$shippingThreshold = 1000;
$shippingCost = ($subtotal >= $shippingThreshold || $subtotal == 0) ? 0 : 150;
$grandTotal = $subtotal + $shippingCost;
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <p>Free worldwide insured shipping on historical artifacts over $1,000</p>
    </div>

    <!-- Header Navigation -->
    <?php include 'inc/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav class="breadcrumb">
            <a href="index.php">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="products.php">Catalog</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Acquisition Vault (Cart)</span>
        </nav>
    </div>

    <!-- MAIN CART SECTION -->
    <section class="section bg-cream cart-section">
        <div class="container">
            
            <div class="cart-header text-center">
                <h1 class="page-title">Your Acquisition Vault</h1>
                <p class="subtitle">Review reserved historical pieces before entering private checkout</p>
                <div class="divider mx-auto"></div>
            </div>

            <?php if (empty($cartItems)): ?>
                <!-- EMPTY CART STATE -->
                <div class="empty-cart-card text-center">
                    <div class="empty-icon"><i class="fa-solid fa-landmark"></i></div>
                    <h3>Your Vault is Currently Empty</h3>
                    <p>You have not reserved any historical artifacts yet. Explore our curated collections to begin your private collection.</p>
                    <a href="products.php" class="btn btn-primary btn-lg mt-20">
                        <i class="fa-solid fa-compass"></i> Explore Museum Artifacts
                    </a>
                </div>
            <?php else: ?>
                <!-- CART CONTENT LAYOUT -->
                <div class="cart-layout">
                    
                    <!-- LEFT COLUMN: CART ITEMS LIST -->
                    <div class="cart-items-wrapper">
                        <div class="cart-table-header">
                            <span class="col-product">Artifact</span>
                            <span class="col-price">Valuation</span>
                            <span class="col-qty">Quantity</span>
                            <span class="col-subtotal">Subtotal</span>
                            <span class="col-action"></span>
                        </div>

                        <div class="cart-items-list">
                            <?php foreach ($cartItems as $item): ?>
                                <?php 
                                    // Main Image fallback
                                    $imgSrc = !empty($item['main_image']) 
                                        ? SITE_URL . 'images/' . $item['main_image'] 
                                        : 'assets/images/placeholder-artifact.jpg';
                                ?>
                                <div class="cart-item-row" data-product-id="<?php echo $item['cart_id']; ?>">
                                    
                                    <!-- Artifact Image & Info -->
                                    <div class="col-product item-info-col">
                                        <div class="item-thumbnail" style="background-image: url('<?php echo $imgSrc; ?>');"></div>
                                        <div class="item-details">
                                            <span class="item-category"><?php echo htmlspecialchars($item['category_name'] ?? 'Artifact'); ?></span>
                                            <h4 class="item-title">
                                                <a href="product-detail.php?product_id=<?php echo $item['cart_id']; ?>">
                                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                                </a>
                                            </h4>
                                            <span class="item-era"><i class="fa-solid fa-landmark"></i> <?php echo htmlspecialchars($item['era'] ?? 'Historical Piece'); ?></span>
                                        </div>
                                    </div>

                                    <!-- Unit Price -->
                                    <div class="col-price item-price">
                                        $<?php echo number_format($item['price'], 2); ?>
                                    </div>

                                    <!-- Quantity Selector -->
                                    <div class="col-qty">
                                        <div class="quantity-selector"data-cart-id="<?php echo $item['cart_id']; ?>">
                                            <button type="button" class="qty-btn minus-btn" data-action="decrease">-</button>
                                            <input type="number" class="qty-input" value="<?php echo $item['quantity']; ?>" min="1" max="10" readonly>
                                            <button type="button" class="qty-btn plus-btn" data-action="increase">+</button>
                                        </div>
                                    </div>

                                    <!-- Item Subtotal -->
                                    <div class="col-subtotal item-subtotal">
                                        $<?php echo number_format($item['item_total'], 2); ?>
                                    </div>

                                    <!-- Remove Action -->
                                    <div class="col-action">
                                        <button class="remove-item-btn" title="Remove Artifact" data-cart-id="<?php echo $item['cart_id']; ?>">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="cart-actions-footer">
                            <a href="products.php" class="btn btn-outline">
                                <i class="fa-solid fa-arrow-left"></i> Continue Browsing
                            </a>
                            <button class="btn btn-text clear-cart-btn" id="clearCartBtn">
                                <i class="fa-solid fa-trash-can"></i> Clear Entire Vault Cart
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: ORDER SUMMARY SIDEBAR -->
                    <div class="cart-summary-wrapper">
                        <div class="summary-card">
                            <h3 class="summary-title">Acquisition Summary</h3>
                            <div class="summary-divider"></div>

                            <div class="summary-row">
                                <span>Artifacts Subtotal</span>
                                <span class="summary-val" id="cartSubtotal">$<?php echo number_format($subtotal, 2); ?></span>
                            </div>

                            <div class="summary-row">
                                <span>Insured White-Glove Shipping</span>
                                <span class="summary-val" id="cartShipping">
                                    <?php echo ($shippingCost == 0) ? '<strong class="text-gold">Complimentary</strong>' : '$' . number_format($shippingCost, 2); ?>
                                </span>
                            </div>

                            <div class="summary-row">
                                <span>Certificates & Appraisal</span>
                                <span class="summary-val text-gold">Included</span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row grand-total-row">
                                <strong>Total Investment</strong>
                                <strong class="grand-total-val" id="cartGrandTotal">$<?php echo number_format($grandTotal, 2); ?></strong>
                            </div>

                            <a href="checkout.php" class="btn btn-primary btn-full btn-lg checkout-btn mt-20">
                                <i class="fa-solid fa-shield-halved"></i> Proceed to Vault Checkout
                            </a>

                            <!-- Trust Guarantee Footer -->
                            <div class="summary-trust-badges">
                                <div class="trust-badge-item">
                                    <i class="fa-solid fa-certificate"></i>
                                    <span>Guaranteed Historical Authenticity</span>
                                </div>
                                <div class="trust-badge-item">
                                    <i class="fa-solid fa-truck-ramp-box"></i>
                                    <span>Climate-Controlled Courier Shipping</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>
    <!-- JavaScript Includes -->
    <?php include 'inc/script.php'; ?>

    <!-- CART INTERACTIVITY SCRIPT -->
    <script>
    $(document).ready(function() {

        // 1. Handle Quantity Adjustments (+ / -)
        $(document).on('click', '.qty-btn', function(e) {
            e.preventDefault();
            
            var $btn = $(this);
            var $row = $btn.closest('.cart-item-row');
            var $wrapper = $btn.closest('.quantity-selector');
            var cartId = $row.data('product-id');
            var $input = $row.find('.qty-input');
            var currentQty = parseInt($input.val()) || 1;
            var action = $btn.data('action');

            var newQty = currentQty;
            
            if (action === 'increase') {
                newQty = currentQty + 1;
            } else if (action === 'decrease' && currentQty > 1) {
                newQty = currentQty - 1;
            }

            if (newQty !== currentQty) {
                $.ajax({
                    url: 'api/update-cart.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        cart_id: cartId,
                        quantity: newQty,
                        action:action
                    }),
                    success: function(response) {
                        
                        if (response.success) {
                        
                            // Update line item subtotal
                            var $row = $wrapper.closest('.cart-item-row');
                            if ($row.length && response.item_subtotal) {
                                $row.find('.qty-input').val(newQty);
                                $row.find('.item-subtotal').text('$' + response.item_subtotal);
                            }
                            // Update grand total
                            if ($('#cartGrandTotal').length && response.cart_subtotal) {
                                $('#cartGrandTotal').text('$' + response.cart_subtotal);
                            }
                        } else {
                            alert(response.message || 'Could not update cart quantity.');
                            $input.val(currentQty); // Revert on error
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        $input.val(currentQty); // Revert on error
                    },
                    complete: function() {
                        // Re-enable buttons
                        $wrapper.find('.qty-btn').prop('disabled', false);
                    }
                });
            }
        });

        // 2. Handle Single Item Removal
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            var cartId = $(this).data('cart-id');
            var $row = $(this).closest('.cart-item-row');

            if (confirm("Are you sure you want to remove this artifact from your acquisition cart?")) {
                removeItemFromCart(cartId, 0, $row);
            }
        });

        // 3. Handle Clear Cart
        $('#clearCartBtn').on('click', function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to clear all reserved items from your vault cart?")) {
                $.ajax({
                    url: 'api/clear-cart.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({ action: 'clear' }),
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        } else {
                            alert(res.message || "Unable to clear cart.");
                        }
                    }
                });
            }
        });

        // Helper AJAX function to communicate with backend
        function removeItemFromCart(cartId, quantity, $row) {
            $.ajax({
                url: 'api/delete-cart.php',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    cart_id: cartId
                }),
                success: function(response) {
                    console.log("Remove Item Response:", response);
                    if (response.success) {
                        if (quantity === 0) {
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                if ($('.cart-item-row').length === 0) {
                                    location.reload(); // Reload to show empty cart state
                                }
                            });
                        } else {
                            $row.find('.cart-qty-input').val(quantity);
                            $row.find('.item-subtotal').text('$' + response.item_subtotal);
                        }

                        // Update global header badge and summary totals
                        if ($('.cart-count-badge').length) {
                            $('.cart-count-badge').text(response.cart_count);
                        }
                        $('#cartSubtotal').text('$' + response.cart_subtotal);
                        $('#cartGrandTotal').text('$' + response.cart_grand_total);
                        
                        if (response.shipping_cost === 0) {
                            $('#cartShipping').html('<strong class="text-gold">Complimentary</strong>');
                        } else {
                            $('#cartShipping').text('$' + response.shipping_cost);
                        }
                    } else {
                        alert(response.message || "Failed to update quantity.");
                    }
                },
                error: function() {
                    alert("A server error occurred while updating the cart.");
                }
            });
        }

    });
    
    </script>
</body>
</html>