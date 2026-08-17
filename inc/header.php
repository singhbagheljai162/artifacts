<header class="navbar">
        <div class="logo"><?php echo $setData['website_name']; ?></div>
        <nav class="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Shop</a>
            <a href="categories.php">Categories</a>
            <a href="#about">About</a>
            <a href="#blog">Blog</a>
            <a href="#contact">Contact</a>
        </nav>
        <div class="nav-icons">
            <i class="fa-solid fa-magnifying-glass"></i>
            <!-- Cart Icon with Dynamic Badge -->
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== ''){ ?> 
            <a href="cart.php" class="cart-icon-wrapper" title="View Vault Cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <?php 

                $cartqry=mysqli_query($conn, "SELECT *  FROM cart WHERE user_id = '".$_SESSION['user_id']."'"); 
                $cartCount = 0;
                if ($cartqry) {
                    $cartCount = mysqli_num_rows($cartqry);
                }
                ?>
                <span class="cart-count-badge"><?php echo $cartCount; ?></span>
            </a>
           
            <a href="wishlist.php" class="active-icon" title="Wishlist"><i class="fa-solid fa-heart"></i></a>
        <?php } ?>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== ''){ ?>
            <a href="profile.php" class="active-icon" title="Profile"><i class="fa-solid fa-user"></i></a>
        <?php }else{ ?>
            <a href="auth.php" class="active-icon" title="Account Access"><i class="fa-solid fa-user"></i></a>
        <?php } ?>
        </div>
    </header>