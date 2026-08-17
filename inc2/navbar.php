<?php
// Ensure session is started once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'includes/config.php';
?>
<header class="top-header">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="<?php echo SITE_URL; ?>images/setting/<?= htmlspecialchars($setData['logo'] ?? 'logo.png'); ?>" alt="Logo">
            </a>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="shop.php">Artifacts</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="nav-icons">
            <a href="#"><i class="fa fa-search"></i></a>
            <a href="#"><i class="fa fa-heart"></i></a>
            <a href="#"><i class="fa fa-shopping-cart"></i></a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="welcome-text">
                    Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?>
                </span>
                <a href="logout.php" 
                   onclick="return confirm('Are you sure you want to logout?');" 
                   class="logout-btn">
                    Logout
                </a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>