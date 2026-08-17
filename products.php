<?php
include 'includes/config.php';

// Safe user session check using user_id
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$is_logged_in = ($user_id > 0);
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

    <!-- Page Header / Banner -->
    <section class="page-banner">
        <h1>The Royal Collection</h1>
        <p>Browse our complete catalog of museum-grade antiquities and artifacts</p>
    </section>

    <!-- Main Layout Container -->
    <div class="shop-container section bg-cream">
        
        <!-- Mobile Filter Toggle Button -->
        <button class="mobile-filter-btn" id="filterToggleBtn">
            <i class="fa-solid fa-sliders"></i> Filter Artifacts
        </button>

        <!-- LEFT SIDE: FILTER SIDEBAR -->
        <aside class="filter-sidebar" id="filterSidebar">
            <div class="filter-header">
                <h3><i class="fa-solid fa-filter"></i> Refine Search</h3>
                <button class="close-filter-btn" id="closeFilterBtn">&times;</button>
            </div>
            
            <!-- Search Filter -->
            <div class="filter-group">
                <h4>Search Keywords</h4>
                <div class="search-input-wrapper">
                    <input type="text" id="searchInput" placeholder="e.g. Dynasty, Gold, Sword...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="filter-group">
                <h4>Categories</h4>
                <label class="custom-checkbox">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    All Artifacts
                </label>
                <?php
                $cat_qr = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name ASC");
                if ($cat_qr) {
                    while ($cat = mysqli_fetch_assoc($cat_qr)) {
                        $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'checked' : '';
                        echo '<label class="custom-checkbox">
                                <input type="checkbox" ' . $selected . ' onclick="window.location.href=\'products.php?category_id=' . $cat['id'] . '\'">
                                <span class="checkmark"></span>
                                ' . htmlspecialchars($cat['category_name']) . '
                              </label>';
                    }
                }
                ?>
            </div>

            <!-- Price Range Filter -->
            <div class="filter-group">
                <h4>Price Range</h4>
                <div class="price-range">
                    <input type="range" min="100" max="10000" value="5000" id="priceRange">
                    <div class="price-labels">
                        <span>Max Price:</span>
                        <strong id="priceValue">$5,000</strong>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="filter-actions">
                <button class="btn btn-primary btn-full">Apply Filters</button>
                <a href="products.php" class="btn btn-outline btn-full btn-reset">Clear All</a>
            </div>
        </aside>

        <!-- RIGHT SIDE: MAIN PRODUCTS AREA -->
        <main class="products-content">
            <?php 
            $whr = "";
            $category_param = "";
            if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
                $cat_id = intval($_GET['category_id']);
                $whr .= " AND category_id = '$cat_id'";
                $category_param = "&category_id=" . $cat_id;
            }
            
            $prod_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE 1 $whr");
            $count_row = mysqli_fetch_assoc($prod_count);
            $par_page = 9;
            $total_page = max(1, ceil($count_row['total'] / $par_page));

            $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($page - 1) * $par_page;
            ?>
            
            <!-- TOP: SORTING OPTIONS BAR -->
            <div class="sorting-bar">
                <div class="result-count">
                    Showing <strong><?php echo $count_row['total'] > 0 ? $offset + 1 : 0; ?>–<?php echo min($page * $par_page, $count_row['total']); ?></strong> of <strong><?php echo $count_row['total']; ?></strong> historical pieces
                </div>
                
                <div class="sorting-controls">
                    <div class="sort-select-wrapper">
                        <label for="sort-by">Sort By:</label>
                        <select id="sort-by" class="sort-select">
                            <option value="featured">Featured Collection</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="newest">Latest Acquisitions</option>
                        </select>
                    </div>

                    <div class="view-options">
                        <button class="view-btn active" title="Grid View"><i class="fa-solid fa-border-all"></i></button>
                        <button class="view-btn" title="List View"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- PRODUCT GRID -->
            <div class="grid shop-product-grid">
                
                <?php 
                $pro = mysqli_query($conn, "SELECT products.*, categories.category_name 
                                           FROM products 
                                           INNER JOIN categories ON products.category_id = categories.id 
                                           WHERE 1 $whr 
                                           ORDER BY products.id DESC 
                                           LIMIT $offset, $par_page");

                if ($pro && mysqli_num_rows($pro) > 0) {
                    while ($row = mysqli_fetch_assoc($pro)) {
                        
                        $is_wishlisted = false;
                        if ($user_id > 0) {
                            $wishqr = mysqli_query($conn, "SELECT id FROM wishlist WHERE user_id = '$user_id' AND product_id = '" . $row['id'] . "'");
                            if ($wishqr && mysqli_num_rows($wishqr) > 0) {
                                $is_wishlisted = true;
                            }
                        }
                        ?>
                        <div class="card product-card">
                            <?php if (!empty($row['tag'])) { ?>
                                <div class="product-badge"><?php echo htmlspecialchars($row['tag']); ?></div>
                            <?php } ?>
                            
                            <!-- Wishlist Toggle Button -->
                            <button style="position: absolute;" class="wishlist-card-btn <?php echo $is_wishlisted ? 'active' : ''; ?>" 
                                    onclick="toggleWishlist(event, <?php echo $row['id']; ?>)" 
                                    title="Add to Watchlist" >
                                <i class="<?php echo $is_wishlisted ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                            </button>

                            <a href="product-detail.php?product_id=<?php echo $row['id']; ?>">
                                <div class="product-img placeholder-img" 
                                     style="background-image: url('<?php echo SITE_URL . 'images/' . $row['main_image']; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                </div>
                            </a>

                            <div class="product-info">
                                <span class="product-category"><?php echo htmlspecialchars($row['category_name']); ?></span>
                                <a href="product-detail.php?product_id=<?php echo $row['id']; ?>">
                                    <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
                                </a>
                                <p class="era-tag"><?php echo htmlspecialchars($row['era']); ?></p>
                                <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                                
                                <!-- Add to Cart Button -->
                                <button class="btn btn-primary btn-full add-to-cart-btn"  data-product-id="<?php echo $row['id']; ?>">
                                    <i class="fa-solid fa-cart-shopping"></i> Acquire Artifact
                                </button>
                            </div>
                        </div>
                    <?php 
                    }
                } else {
                    echo '<p class="no-products">No artifacts found in this collection.</p>';
                } 
                ?>

            </div>

            <!-- BOTTOM: PAGINATION -->
            <?php if ($total_page > 1) { ?>
            <div class="pagination-wrapper">
                <ul class="pagination">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo max(1, $page - 1) . $category_param; ?>" aria-label="Previous">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i . $category_param; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $total_page) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo min($total_page, $page + 1) . $category_param; ?>" aria-label="Next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php } ?>

        </main>

    </div>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>

    <!-- Scripts -->
    <?php include 'inc/script.php'; ?>
    
    <script>
        var IS_LOGGED_IN = <?php echo $is_logged_in ? 'true' : 'false'; ?>;

        // Price Range Display Update
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', (e) => {
                priceValue.textContent = `$${parseInt(e.target.value).toLocaleString()}`;
            });
        }

        // Mobile Filter Sidebar Toggle
        const filterToggleBtn = document.getElementById('filterToggleBtn');
        const closeFilterBtn = document.getElementById('closeFilterBtn');
        const filterSidebar = document.getElementById('filterSidebar');

        if (filterToggleBtn && filterSidebar) {
            filterToggleBtn.addEventListener('click', () => {
                filterSidebar.classList.add('open');
            });
        }

        if (closeFilterBtn && filterSidebar) {
            closeFilterBtn.addEventListener('click', () => {
                filterSidebar.classList.remove('open');
            });
        }

        // Wishlist Toggle Function
        function toggleWishlist(event, productId) {
            event.preventDefault();
            event.stopPropagation();

            if (!IS_LOGGED_IN) {
                alert("Please sign in to save items to your private Curator Watchlist.");
                window.location.href = "auth.php";
                return;
            }

            var $btn = $(event.currentTarget);
            var $icon = $btn.find('i');
            var isAdding = !$btn.hasClass('active');

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
                error: function(xhr, status, error) {
                    console.error("Wishlist Error:", error);
                    alert("A server error occurred. Please try again.");
                    $btn.toggleClass('active');
                    $icon.toggleClass('fa-solid fa-regular');
                }
            });
        }

        // jQuery Ready - Handlers
        $(document).ready(function() {

            // Single Add-To-Cart AJAX Handler for Listing Page
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
            if (!IS_LOGGED_IN) {
                alert("Please sign in to save items to your private Curator Watchlist.");
                window.location.href = "auth.php";
                return;
            }

                var $btn = $(this);
                var productId = $btn.data('product-id');
                var originalHtml = $btn.html();

                if (!productId) {
                    alert("Error: Missing Product ID.");
                    return;
                }

                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Securing...');

                $.ajax({
                    url: 'api/add-to-cart.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({ product_id: productId, quantity: 1 }),
                    success: function(response) {
                        if (response.success) {
                            if ($('.cart-count-badge').length) {
                                $('.cart-count-badge').text(response.cart_count);
                            }
                            $btn.html('<i class="fa-solid fa-check"></i> Added');
                            setTimeout(function() {
                                $btn.prop('disabled', false).html(originalHtml);
                            }, 2000);
                        } else {
                            alert("Cart Error: " + response.message);
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Unable to process request. Check browser console for details.");
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

        });
    </script>
</body>
</html>