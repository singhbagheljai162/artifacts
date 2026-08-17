<?php
include 'includes/config.php';
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

    <!-- Hero Banner -->

    <section class="hero" id="home">
        
        <!-- Slide 1 -->
         <!-- Add php loop for "SELECT * FROM `banners` with button_text and button_link " -->
        <?php $banners = mysqli_query($conn, "SELECT * FROM banners");
        while($banner = mysqli_fetch_assoc($banners)) {
            
           $iBan= SITE_URL .'banners/'. $banner['image']; 
            ?>
        <div class="slide active" style="background-image: url('<?php echo $iBan; ?>');">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1><?php echo $banner['title']; ?></h1>
                <p><?php echo $banner['subtitle']; ?></p>
                <a href="<?php echo SITE_URL .$banner['button_link']; ?>" class="btn btn-primary"><?php echo $banner['button_text']; ?></a>
            </div>
        </div>
        <?php } ?>

        <!-- Slider Controls -->
        <button class="slider-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>

        <!-- Slider Dots -->
        <div class="slider-dots">
            <?php $banners = mysqli_query($conn, "SELECT * FROM banners");
            $dotIndex = 0;
            while($banner = mysqli_fetch_assoc($banners)) { ?>

            <span class="dot <?php echo $dotIndex === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $dotIndex; ?>)"></span>

            <?php $dotIndex++; } ?>
        </div>
    </section>

    <!-- Categories -->
    <section class="section bg-beige" id="categories">
        <div class="section-header">
            <h2>Explore by Category</h2>
            <div class="divider"></div>
        </div>
        <div class="grid categories-grid">
            <!-- 8 Category Cards -->
            <?php $cat=mysqli_query($conn, "SELECT * FROM categories"); 

            while($row=mysqli_fetch_assoc($cat))
            {   

            ?>
            <div class="card category-card"><h3><?php echo $row['category_name']; ?></h3></div>
            <?php } ?>
        </div>
    </section>

    <!-- Featured Artifacts -->
    <section class="section bg-cream" id="shop">
        <div class="section-header">
            <h2>Featured Artifacts</h2>
            <div class="divider"></div>
        </div>
        <div class="grid product-grid">
            <div class="card product-card">
                <div class="product-img placeholder-img"></div>
                <div class="product-info">
                    <h4>Ming Dynasty Vase</h4>
                    <p class="price">$4,500</p>
                    <button class="btn btn-outline">Add to Cart</button>
                </div>
            </div>
            <div class="card product-card">
                <div class="product-img placeholder-img"></div>
                <div class="product-info">
                    <h4>Roman Bronze Coin</h4>
                    <p class="price">$850</p>
                    <button class="btn btn-outline">Add to Cart</button>
                </div>
            </div>
            <div class="card product-card">
                <div class="product-img placeholder-img"></div>
                <div class="product-info">
                    <h4>Victorian Pocket Watch</h4>
                    <p class="price">$1,200</p>
                    <button class="btn btn-outline">Add to Cart</button>
                </div>
            </div>
            <div class="card product-card">
                <div class="product-img placeholder-img"></div>
                <div class="product-info">
                    <h4>Ottoman Dagger</h4>
                    <p class="price">$2,100</p>
                    <button class="btn btn-outline">Add to Cart</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section bg-beige text-center">
        <div class="section-header">
            <h2>The Heritage Promise</h2>
            <div class="divider mx-auto"></div>
        </div>
        <div class="grid features-grid">
            <div class="card feature-card">
                <i class="fa-solid fa-certificate"></i>
                <h4>Authenticity Guaranteed</h4>
                <p>Every piece comes with a museum-certified certificate of authenticity.</p>
            </div>
            <div class="card feature-card">
                <i class="fa-solid fa-globe"></i>
                <h4>Global Sourcing</h4>
                <p>Ethically acquired artifacts from private collections worldwide.</p>
            </div>
            <div class="card feature-card">
                <i class="fa-solid fa-shield-halved"></i>
                <h4>Secure Delivery</h4>
                <p>Fully insured, climate-controlled shipping for delicate historical items.</p>
            </div>
            <div class="card feature-card">
                <i class="fa-solid fa-landmark"></i>
                <h4>Museum Quality</h4>
                <p>Only the finest preserved pieces make it into our curated catalog.</p>
            </div>
        </div>
    </section>

    <!-- About Artifacts (Image + Text) -->
    <section class="section bg-cream" id="about">
        <div class="about-container">
            <div class="about-image placeholder-img"></div>
            <div class="about-text">
                <h2>A Legacy of History</h2>
                <div class="divider-left"></div>
                <p>Our collection represents centuries of human triumph, artistry, and culture. We believe that owning an artifact is not merely about possession, but about becoming a steward of history. Each piece in our gallery has been carefully evaluated by leading historians and conservators to ensure its legacy endures for generations to come.</p>
                <a href="#about" class="btn btn-primary">Read Our Story</a>
            </div>
        </div>
    </section>

    <!-- Special Offer Banner -->
    <section class="special-offer">
        <div class="offer-content">
            <h2>The Antiquity Collection</h2>
            
            <input type="text" id="server-time" value="">
            <p>Enjoy 10% off your first historical acquisition. Exclusive to new collectors.</p>
            <button class="btn btn-primary show-time" onclick="updateServerTime()">Claim Offer</button>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="section bg-beige text-center">
        <h2>Join the Curators Club</h2>
        <p class="newsletter-text">Subscribe to receive exclusive access to newly acquired collections and historical insights.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Enter your email address" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </section>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>
    <?php include 'inc/script.php'; ?>
    <script>
        // Display server time in the special offer section
        function updateServerTime() {
               // const now = new Date();
               // $('.server-time').text('Server Time: ' + now.toLocaleString()); 
               $.ajax({
                url: 'api/server-time.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Server Time Response:', response);
                        if (response.success) {
                            $('#server-time').val('Server Time: ' + response.server_t);
                        } else {
                            console.error('Error fetching server time:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                })
            }

        </script>
</body>
</html>