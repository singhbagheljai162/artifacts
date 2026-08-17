<?php
include 'includes/config.php';
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$is_logged_in = ($user_id > 0);

// Sanitize incoming product_id
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Fetch Product Details
$pro = mysqli_query($conn, "SELECT products.*, categories.category_name 
                            FROM products 
                            INNER JOIN categories ON products.category_id = categories.id 
                            WHERE products.id = $product_id");

if (!$pro || mysqli_num_rows($pro) === 0) {
    header("Location: products.php");
    exit;
}

$product = mysqli_fetch_assoc($pro);

// Check if item is already in user's wishlist
$is_wishlisted = false;
if (isset($_SESSION['user_id']) && $product_id > 0) {
    $userId = intval($_SESSION['user_id']);
    $wishCheck = mysqli_query($conn, "SELECT id FROM wishlist WHERE user_id = $userId AND product_id = $product_id");
    if ($wishCheck && mysqli_num_rows($wishCheck) > 0) {
        $is_wishlisted = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <p>Free worldwide shipping on historical artifacts over $1,000</p>
    </div>

    <!-- Navbar -->
    <?php include 'inc/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav class="breadcrumb">
            <a href="index.php">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="products.php?category_id=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a>
            <i class="fa-solid fa-chevron-right"></i>
            <span><?php echo htmlspecialchars($product['product_name']); ?></span>
        </nav>
    </div>

    <!-- PRODUCT DETAIL SECTION -->
    <section class="section bg-cream product-detail-section">
        <div class="product-detail-container">
            
            <!-- LEFT: GALLERY -->
            <div class="product-gallery">
                <div class="main-image-wrapper">
                    <span class="product-badge">Royal Provenance</span>
                    <div class="main-image placeholder-img" id="mainImageDisplay" style="background-image: url('<?php echo SITE_URL.'images/'.$product['main_image']; ?>');">
                        <div class="image-label">Primary View</div>
                    </div>
                </div>
                <div class="thumbnail-list">
                    <div class="thumb active" onclick="switchImage(this, '<?php echo SITE_URL.'images/'.$product['main_image']; ?>', 'Primary View')">
                        <div class="placeholder-img" style="background-image: url('<?php echo SITE_URL.'images/'.$product['main_image']; ?>');"></div>
                    </div>

                    <?php 
                    $images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $product_id");
                    if ($images) {
                        while($img = mysqli_fetch_assoc($images)){
                        ?>
                        <div class="thumb" onclick="switchImage(this, '<?php echo SITE_URL.'images/'.$img['image']; ?>', 'Detail View')">
                            <div class="placeholder-img" style="background-image: url('<?php echo SITE_URL.'images/'.$img['image']; ?>');"></div>
                        </div>
                        <?php 
                        } 
                    }
                    ?>
                </div>
            </div>

            <!-- RIGHT: INFO & ACTIONS -->
            <div class="product-summary">
                <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>

                <div class="meta-row">
                    <span class="era-badge"><i class="fa-solid fa-landmark"></i> <?php echo htmlspecialchars($product['era']); ?></span>
                    <span class="stock-status"><i class="fa-solid fa-check"></i> Single Piece Available</span>
                </div>

                <div class="price-container">
                    <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                    <span class="vat-note">Includes Certificate of Authenticity & Insurance</span>
                </div>

                <p class="short-description">
                    <?php echo htmlspecialchars($product['short_description']); ?>
                </p>

                <!-- Fast Specs Table -->
                <div class="fast-specs">
                    <div class="spec-item">
                        <span class="spec-label">Period:</span>
                        <span class="spec-val"><?php echo htmlspecialchars($product['era']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Origin:</span>
                        <span class="spec-val"><?php echo htmlspecialchars($product['origin']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Material:</span>
                        <span class="spec-val"><?php echo htmlspecialchars($product['material']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Dimensions:</span>
                        <span class="spec-val"><?php echo htmlspecialchars($product['dimensions']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Cert. ID:</span>
                        <span class="spec-val"><?php echo htmlspecialchars($product['certificate_id']); ?></span>
                    </div>
                </div>

                <!-- ACTION CONTROLS -->
                <div class="purchase-actions">
                    <div class="quantity-selector">
                        <button type="button" class="qty-btn minus-btn">-</button>
                        <input type="number" id="itemQty" value="1" min="1" max="10" readonly>
                        <button type="button" class="qty-btn plus-btn">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-primary btn-add-cart add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                        <i class="fa-solid fa-bag-shopping"></i> Acquire Artifact
                    </button>

                    <!-- Wishlist/Watchlist Button -->
                    <button class="btn btn-outline btn-icon-only wishlist-card-btn <?php echo $is_wishlisted ? 'active' : ''; ?>" 
                            data-product-id="<?php echo $product['id']; ?>" 
                            title="Add to Private Vault">
                        <i class="<?php echo $is_wishlisted ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                    </button>
                </div>

                <!-- Trust Highlights -->
                <div class="trust-highlights">
                    <div class="trust-item">
                        <i class="fa-solid fa-certificate"></i>
                        <div>
                            <strong>Guaranteed Authentic</strong>
                            <p>Verified by independent historians</p>
                        </div>
                    </div>
                    <div class="trust-item">
                        <i class="fa-solid fa-truck-fast"></i>
                        <div>
                            <strong>Insured Transport</strong>
                            <p>Custom wooden crate & climate care</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- LOWER SECTION: TABS -->
        <div class="product-tabs-wrapper">
            <div class="tab-headers">
                <button class="tab-btn active" onclick="openTab(event, 'narrative')">Historical Narrative</button>
                <button class="tab-btn" onclick="openTab(event, 'provenance')">Provenance & Authentication</button>
                <button class="tab-btn" onclick="openTab(event, 'care')">Preservation & Care</button>
                <button class="tab-btn" onclick="openTab(event, 'shipping')">Shipping & Insurance</button>
            </div>

            <!-- Tab 1: Narrative -->
            <div id="narrative" class="tab-content active">
                <h3>The Yongle Porcelain Legacy</h3>
                <p>During the reign of the Yongle Emperor (1402–1424), the Imperial kilns at Jingdezhen reached unprecedented heights in technical perfection and artistic expression. This vase showcases the distinctive deep "Heaping and Piling" effect characteristic of imported Sumatran cobalt blue dye used during this golden age.</p>
                <p>The central body displays delicate peony scrolls, symbolizing royalty and prosperity, bounded by classic key-fret borders along the neck and base rim.</p>
            </div>

            <!-- Tab 2: Provenance -->
            <div id="provenance" class="tab-content">
                <h3>Documented Chain of Ownership</h3>
                <ul class="provenance-list">
                    <li><strong>1924–1968:</strong> Private Collection of Baron Von Metternich, Vienna.</li>
                    <li><strong>1968–2002:</strong> Acquired via Sotheby’s London (Sale #4812, Lot 104).</li>
                    <li><strong>2002–2025:</strong> Held in a private Swiss museum vault.</li>
                    <li><strong>2026:</strong> Consigned directly to Heritage Artifacts. Thermoluminescence tested for accurate age verification.</li>
                </ul>
            </div>

            <!-- Tab 3: Care -->
            <div id="care" class="tab-content">
                <h3>Conservation Guidelines</h3>
                <p>To ensure this piece endures for future generations:</p>
                <ul>
                    <li>Maintain ambient temperature between 18°C–22°C (64°F–72°F).</li>
                    <li>Keep relative humidity steady at 45%–55%.</li>
                    <li>Dust exclusively with an ultra-soft goat hair brush; avoid chemical cleaners or water immersion.</li>
                </ul>
            </div>

            <!-- Tab 4: Shipping -->
            <div id="shipping" class="tab-content">
                <h3>Museum-Grade Transit</h3>
                <p>All high-value antiquities are dispatched inside a vacuum-sealed, impact-absorbent wooden crate. Shipments are fully insured for total appraisal value and accompanied by a dedicated courier tracking agent.</p>
            </div>
        </div>
    </section>

    <!-- RELATED ARTIFACTS -->
    <?php
    $category_id = $product['category_id'];
    $related = mysqli_query($conn, "SELECT products.*, categories.category_name 
                                    FROM products 
                                    INNER JOIN categories ON products.category_id = categories.id 
                                    WHERE products.category_id = '$category_id' AND products.id != '$product_id' 
                                    LIMIT 4");
    ?>
    <section class="section bg-beige text-center">
        <div class="section-header">
            <h2>Complementary Discoveries</h2>
            <div class="divider mx-auto"></div>
        </div>
        <div class="grid product-grid">
            <?php
            if ($related) {
                while($row = mysqli_fetch_assoc($related)) {
                    $images = explode(',', $row['main_image']);
                    $image = $images[0];
                ?>
                <div class="card product-card">
                    <div class="product-img">
                        <img src="admin/uploads/products/<?php echo $image; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="width:100%;height:250px;object-fit:cover;">
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?php echo htmlspecialchars($row['category_name']); ?></span>
                        <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
                        <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                        <a href="product-detail.php?product_id=<?php echo $row['id']; ?>" class="btn btn-outline btn-full">View Piece</a>
                    </div>
                </div>
                <?php 
                } 
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>
    <!-- Script Includes -->
    <?php include 'inc/script.php'; ?>

    <script>

        // Global Login Status
        var IS_LOGGED_IN = <?php echo $is_logged_in ? 'true' : 'false'; ?>;

        // Image Thumbnail Switcher
        function switchImage(thumbElem, imgUrl, labelText) {
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            thumbElem.classList.add('active');
            
            const mainDisplay = document.getElementById('mainImageDisplay');
            mainDisplay.style.backgroundImage = `url('${imgUrl}')`;
            mainDisplay.innerHTML = `<div class="image-label">${labelText}</div>`;
        }

        // Tab Navigation
        function openTab(evt, tabId) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            
            document.getElementById(tabId).classList.add('active');
            evt.currentTarget.classList.add('active');
        }

        // --- jQuery Interactivity ---
        $(document).ready(function() {

            // 1. Quantity Adjuster (+ / -)
            $(document).on('click', '.qty-btn', function() {
                var $input = $('#itemQty');
                var currentVal = parseInt($input.val()) || 1;

                if ($(this).hasClass('plus-btn')) {
                    if (currentVal < 10) $input.val(currentVal + 1);
                } else if ($(this).hasClass('minus-btn')) {
                    if (currentVal > 1) $input.val(currentVal - 1);
                }
            });

            // 2. Single Add to Cart Handler with Full Diagnostics

            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();

                if (!IS_LOGGED_IN) {
                    alert("Please sign in to save items to your private Curator Watchlist.");
                    window.location.href = "auth.php";
                    return;
                }
                
                var btn = $(this);
                var productId = btn.data('product-id');
                var quantity = parseInt($('#itemQty').val()) || 1;
                var originalHtml = btn.html();

                console.log("Add to Cart Clicked:", { productId: productId, quantity: quantity });

                if (!productId || productId === 0) {
                    alert("Error: Product ID is missing from the button. Check data-product-id attribute.");
                    return;
                }

                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Securing...');

                $.ajax({
                    url: 'api/add-to-cart.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({ product_id: productId, quantity: quantity }),
                    success: function(response) {
                        console.log("Server Response:", response);
                        
                        if (response.success) {
                            if ($('.cart-count-badge').length) {
                                $('.cart-count-badge').text(response.cart_count);
                            }
                            
                            $btn.html('<i class="fa-solid fa-check"></i> Added to Vault');
                            
                            setTimeout(function() {
                                $btn.prop('disabled', false).html(originalHtml);
                            }, 2000);
                        } else {
                            alert("Cart Error: " + response.message);
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error Details:", xhr.responseText);
                        alert("API Error: Unable to reach api/add-to-cart.php. Press F12 -> Console to inspect.");
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // 3. Wishlist / Watchlist Handler
            $(document).on('click', '.wishlist-card-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (!IS_LOGGED_IN) {
                    alert("Please sign in to save items to your private Curator Watchlist.");
                    window.location.href = "auth.php";
                    return;
                }

                var $btn = $(this);
                var productId = $btn.data('product-id');
                var $icon = $btn.find('i');
                var isAdding = !$btn.hasClass('active');

                // Toggle UI state
                $btn.toggleClass('active');
                $icon.toggleClass('fa-solid fa-regular');

                $.ajax({
                    url: 'api/toggle-watchlist.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({ product_id: productId, action: isAdding ? 'add' : 'remove' }),
                    success: function(response) {
                        if (!response.success) {
                            alert(response.message || "Unable to update watchlist.");
                            $btn.toggleClass('active');
                            $icon.toggleClass('fa-solid fa-regular');
                        }
                    },
                    error: function() {
                        alert("Server error. Action reverted.");
                        $btn.toggleClass('active');
                        $icon.toggleClass('fa-solid fa-regular');
                    }
                });
            });

        });
    </script>
</body>
</html>