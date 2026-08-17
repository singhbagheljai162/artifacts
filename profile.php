<?php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>
<body>
    <?php
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    header("Location: auth.php?error=please_login");
    exit();
    }
    else{
           $result = mysqli_query($conn,"SELECT * FROM users WHERE id='".$_SESSION['user_id']."' AND status='Active' AND role='Customer'"); 
           $user = mysqli_fetch_assoc($result);
    }
    ?>
    <!-- Top Bar -->
    <div class="top-bar">
        <p>Free worldwide insured shipping on historical artifacts over $1,000</p>
    </div>

    <!-- Navbar -->
    <?php include 'inc/header.php'; ?>

    <!-- PROFILE HERO BANNER -->
    <section class="profile-hero">
        <div class="profile-hero-content">
            <div class="curator-avatar">
                <i class="fa-solid fa-user-tie"></i>
                <span class="status-badge" title="Verified Curator"><i class="fa-solid fa-shield-halved"></i></span>
            </div>
            <div class="curator-details">
                <div class="curator-rank"><i class="fa-solid fa-crown"></i> Senior Collector</div>
                <h1><?php echo $user['full_name']; ?></h1>
                <p class="curator-meta">Member since 2022 &bull; Vault ID: <strong>#HA-88402</strong></p>
            </div>
            <div class="profile-quick-stats">
                <div class="stat-box">
                    <span class="stat-number">4</span>
                    <span class="stat-label">Acquisitions</span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">4</span>
                    <span class="stat-label">Verified CoA</span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">12</span>
                    <span class="stat-label">Watchlist</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN DASHBOARD CONTENT -->
    <section class="section bg-cream profile-section">
        <div class="profile-container">
            
            <!-- LEFT NAVIGATION SIDEBAR -->
            <aside class="profile-sidebar">
                <div class="sidebar-header">
                    <h3>Curator Control</h3>
                </div>
                <nav class="profile-nav">
                    <button class="profile-nav-btn active" onclick="switchProfileTab('vault', this)">
                        <i class="fa-solid fa-box-archive"></i> Private Vault (Orders)
                    </button>
                    <button class="profile-nav-btn" onclick="switchProfileTab('certificates', this)">
                        <i class="fa-solid fa-certificate"></i> Authenticity Records
                    </button>
                    <button class="profile-nav-btn" onclick="switchProfileTab('watchlist', this)">
                        <i class="fa-solid fa-bookmark"></i> Curator Watchlist
                    </button>
                    <button class="profile-nav-btn" onclick="switchProfileTab('account', this)">
                        <i class="fa-solid fa-sliders"></i> Account & Delivery
                    </button>
                    <button class="profile-nav-btn" onclick="switchProfileTab('security', this)">
                        <i class="fa-solid fa-lock"></i> Security & 2FA
                    </button>
                </nav>

                <div class="sidebar-concierge-card">
                    <i class="fa-solid fa-headset"></i>
                    <h4>Private Concierge</h4>
                    <p>Direct assistance for high-value acquisitions and private sales.</p>
                    <a href="#" class="btn btn-outline btn-full btn-sm">Contact Senior Curator</a>
                </div>

                <a href="logout.php" class="logout-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out of Vault</a>
            </aside>

            <!-- RIGHT CONTENT AREA -->
            <main class="profile-content">
                
                <!-- TAB 1: PRIVATE VAULT (ACQUISITIONS) -->
                <div id="tab-vault" class="profile-tab-pane active-pane">
                    <div class="pane-header">
                        <div>
                            <h2>Acquired Artifacts</h2>
                            <p>Track delivery, provenance logs, and insured vault archives.</p>
                        </div>
                        <span class="badge-gold">4 Active Vault Records</span>
                    </div>

                    <div class="vault-grid">
                        <!-- Order Item 1 -->
                        <div class="vault-card">
                            <div class="vault-card-header">
                                <span class="order-id">Acquisition #HA-2026-991</span>
                                <span class="order-status status-delivered"><i class="fa-solid fa-circle-check"></i> In Private Vault</span>
                            </div>
                            <div class="vault-card-body">
                                <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=300&q=80" alt="Ming Dynasty Blue & White Ceramic Vase">
                                <div class="vault-card-info">
                                    <span class="product-category">Pottery & Ceramics</span>
                                    <h4>Ming Dynasty Porcelain Vessel</h4>
                                    <p class="era-tag">Circa 1420 AD &bull; Imperial Household Provenance</p>
                                    <p class="vault-price">$12,500</p>
                                </div>
                            </div>
                            <div class="vault-card-footer">
                                <button class="btn btn-outline btn-sm"><i class="fa-solid fa-truck-fast"></i> Tracking Info</button>
                                <button class="btn btn-primary btn-sm"><i class="fa-solid fa-file-pdf"></i> Download CoA</button>
                            </div>
                        </div>

                        <!-- Order Item 2 -->
                        <div class="vault-card">
                            <div class="vault-card-header">
                                <span class="order-id">Acquisition #HA-2025-410</span>
                                <span class="order-status status-delivered"><i class="fa-solid fa-circle-check"></i> In Private Vault</span>
                            </div>
                            <div class="vault-card-body">
                                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=300&q=80" alt="Ancient Greek Bronze Helmet">
                                <div class="vault-card-info">
                                    <span class="product-category">Statuary & Armor</span>
                                    <h4>Corinthian Bronze Helmet</h4>
                                    <p class="era-tag">Circa 500 BC &bull; Peloponnesian Provenance</p>
                                    <p class="vault-price">$18,900</p>
                                </div>
                            </div>
                            <div class="vault-card-footer">
                                <button class="btn btn-outline btn-sm"><i class="fa-solid fa-truck-fast"></i> Tracking Info</button>
                                <button class="btn btn-primary btn-sm"><i class="fa-solid fa-file-pdf"></i> Download CoA</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: CERTIFICATES OF AUTHENTICITY -->
                <div id="tab-certificates" class="profile-tab-pane">
                    <div class="pane-header">
                        <div>
                            <h2>Digital Certificates of Authenticity</h2>
                            <p>Blockchain-backed authenticity ledger and carbon-timestamped records.</p>
                        </div>
                    </div>

                    <div class="coa-list">
                        <div class="coa-card">
                            <div class="coa-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div class="coa-details">
                                <h4>Ming Dynasty Porcelain Vessel</h4>
                                <p>Certificate ID: <strong>CERT-2026-88319</strong></p>
                                <span class="coa-date">Verified on January 14, 2026 by Dr. H. Vance</span>
                            </div>
                            <a href="#" class="btn btn-outline btn-sm"><i class="fa-solid fa-download"></i> PDF Record</a>
                        </div>
                        <div class="coa-card">
                            <div class="coa-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div class="coa-details">
                                <h4>Corinthian Bronze Helmet</h4>
                                <p>Certificate ID: <strong>CERT-2025-11042</strong></p>
                                <span class="coa-date">Verified on November 02, 2025 by Prof. E. Thorne</span>
                            </div>
                            <a href="#" class="btn btn-outline btn-sm"><i class="fa-solid fa-download"></i> PDF Record</a>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: WATCHLIST -->
                <div id="tab-watchlist" class="profile-tab-pane">
                    <div class="pane-header">
                        <div>
                            <h2>Curator Watchlist</h2>
                            <p>Artifacts currently reserved or tracked for upcoming private auctions.</p>
                        </div>
                    </div>

                    <div class="watchlist-grid">
                        <div class="watchlist-card">
                            <img src="https://images.unsplash.com/photo-1608371945786-d47d3cdd31da?auto=format&fit=crop&w=300&q=80" alt="Roman Coin">
                            <div class="watchlist-info">
                                <h4>Julius Caesar Gold Aureus</h4>
                                <span class="product-category">Coins & Numismatics</span>
                                <p class="price">$8,400</p>
                                <div class="watchlist-actions">
                                    <a href="#" class="btn btn-primary btn-sm">Acquire Piece</a>
                                    <button class="btn-icon-danger" title="Remove"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: ACCOUNT & DELIVERY SETTINGS -->
                <div id="tab-account" class="profile-tab-pane">
                    <div class="pane-header">
                        <div>
                            <h2>Account & Security Details</h2>
                            <p>Manage confidential shipping destinations and collector preferences.</p>
                        </div>
                    </div>

                    <form class="profile-form" onsubmit="event.preventDefault(); alert('Profile updated successfully.');">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="profTitle">Honorific Title</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-crown"></i>
                                    <input type="text" id="profTitle" value="Lord">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profName">Full Name</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-user"></i>
                                    <input type="text" id="profName" value="Sterling Vance">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="profEmail">Private Email</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" id="profEmail" value="sterling@vance-holdings.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profPhone">Encrypted Phone</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="tel" id="profPhone" value="+44 20 7946 0912">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="profAddress">Primary Insured Shipping Vault Address</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" id="profAddress" value="74 Grosvenor Square, Mayfair, London W1K 3JH, UK">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Curator Profile</button>
                    </form>
                </div>

                <!-- TAB 5: SECURITY & 2FA -->
                <div id="tab-security" class="profile-tab-pane">
                    <div class="pane-header">
                        <div>
                            <h2>Vault Security & Authentication</h2>
                            <p>Multi-factor protection for high-value bidding and private purchases.</p>
                        </div>
                    </div>

                    <div class="security-box">
                        <div class="security-item">
                            <div>
                                <h4>Two-Factor Authentication (2FA)</h4>
                                <p>Requires a hardware key or authenticator app before authorizing bids over $10,000.</p>
                            </div>
                            <span class="status-badge-active"><i class="fa-solid fa-shield-check"></i> Enabled</span>
                        </div>
                        <hr class="divider">
                        <div class="security-item">
                            <div>
                                <h4>Private API / Certificate Key</h4>
                                <p>Used to sync your vault certificates with digital asset registries.</p>
                            </div>
                            <button class="btn btn-outline btn-sm">Regenerate Key</button>
                        </div>
                    </div>
                </div>

            </main>

        </div>
    </section>

    <!-- Footer -->
     <?php include 'inc/footer.php'; ?>

    <!-- Interactive Script -->
     <?php include 'inc/script.php'; ?>
    <script>
        function switchProfileTab(tabId, btnElement) {
            // Hide all tab panes
            const panes = document.querySelectorAll('.profile-tab-pane');
            panes.forEach(pane => pane.classList.remove('active-pane'));

            // Remove active class from all sidebar buttons
            const buttons = document.querySelectorAll('.profile-nav-btn');
            buttons.forEach(btn => btn.classList.remove('active'));

            // Show target tab pane
            document.getElementById('tab-' + tabId).classList.add('active-pane');
            
            // Add active class to clicked button
            btnElement.classList.add('active');
        }
    </script>
</body>
</html>