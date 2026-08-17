<?php
include 'includes/config.php';

/* ---------------- SESSION CHECK ---------------- */
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '') {
    header("Location: profile.php");
    exit();
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

    <!-- Page Banner -->
    <section class="page-banner">
        <h1>Curators Club Portal</h1>
        <p>Access your private vault, track acquisitions, and receive exclusive preview invitations</p>
    </section>

    <!-- AUTHENTICATION SECTION -->
    <section class="section bg-cream auth-section">
        <div class="auth-container">
            
            <!-- LEFT PANEL: Collector Benefits -->
            <div class="auth-benefits-panel">
                <div class="benefits-content">
                    <i class="fa-solid fa-landmark-dome benefits-icon"></i>
                    <h2>Collector Privileges</h2>
                    <div class="divider-left"></div>
                    <p>Membership grants you access to an esteemed circle of historians, conservators, and private collectors worldwide.</p>
                    
                    <ul class="benefits-list">
                        <li>
                            <i class="fa-solid fa-gem"></i>
                            <div>
                                <strong>Private Catalog Previews</strong>
                                <span>24-hour priority access to new rare acquisitions.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-shield-halved"></i>
                            <div>
                                <strong>Vault Provenance Tracking</strong>
                                <span>Digital ledger of your certificates & authenticity records.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-user-tie"></i>
                            <div>
                                <strong>Concierge Authentication</strong>
                                <span>Direct consultations with our senior historians.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- RIGHT PANEL: Login / Register Form Box -->
            <div class="auth-form-card">
                
                <!-- Toggle Tab Header -->
                <div class="auth-tabs">
                    <button class="auth-tab-btn active" id="loginTabBtn" onclick="switchAuthTab('login')">Sign In</button>
                    <button class="auth-tab-btn" id="registerTabBtn" onclick="switchAuthTab('register')">Apply for Membership</button>
                </div>

                <!-- Alert Message Boxes -->
                <div id="loginAlert" style="display: none; padding: 12px; margin: 15px 0; border-radius: 4px; font-size: 14px;"></div>
                <div id="registerAlert" style="display: none; padding: 12px; margin: 15px 0; border-radius: 4px; font-size: 14px;"></div>

                <!-- SIGN IN FORM -->
                <form id="loginForm" class="auth-form active-form">
                    <div class="form-header">
                        <h3>Welcome Back</h3>
                        <p>Enter your credentials to access your account</p>
                    </div>

                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" name="email" id="loginEmail" placeholder="collector@heritage.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" id="loginPassword" placeholder="••••••••••••" required>
                            <i class="fa-regular fa-eye toggle-pwd" onclick="togglePasswordVisibility('loginPassword', this)"></i>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember_me" id="rememberMe">
                            <span class="checkmark"></span>
                            Remember my session
                        </label>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" id="loginBtn" class="btn btn-primary btn-full">
                        <i class="fa-solid fa-key"></i> Access Vault
                    </button>
                </form>

                <!-- REGISTRATION FORM -->
                <form id="registerForm" class="auth-form">
                    <div class="form-header">
                        <h3>Join the Curators Club</h3>
                        <p>Complete the application to request private member status</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="regFirstName">First Name</label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" name="first_name" id="regFirstName" placeholder="Lord / Lady / Dr." required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="regLastName">Last Name</label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" name="last_name" id="regLastName" placeholder="Sterling" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regEmail">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" name="email" id="regEmail" placeholder="sterling@heritage.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regInterest">Primary Interest</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-compass"></i>
                            <select name="interest" id="regInterest" class="luxury-select">
                                <option value="all">All Historical Categories</option>
                                <option value="statuary">Statuary & Sculptures</option>
                                <option value="weaponry">Royal Weaponry & Armor</option>
                                <option value="coins">Coins & Numismatics</option>
                                <option value="manuscripts">Rare Manuscripts</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regPassword">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" id="regPassword" placeholder="Minimum 8 characters" required>
                            <i class="fa-regular fa-eye toggle-pwd" onclick="togglePasswordVisibility('regPassword', this)"></i>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="terms" required>
                            <span class="checkmark"></span>
                            I agree to the <a href="#" class="inline-link">Terms of Authenticity</a> & <a href="#" class="inline-link">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" id="registerBtn" class="btn btn-primary btn-full">
                        <i class="fa-solid fa-paper-plane"></i> Submit Membership Request
                    </button>
                </form>

            </div>

        </div>
    </section>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>

    <!-- Interactive Script -->
    <?php include 'inc/script.php'; ?>
    <script>
        // Tab Switcher between Login and Register
        function switchAuthTab(tab) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTabBtn = document.getElementById('loginTabBtn');
            const registerTabBtn = document.getElementById('registerTabBtn');

            $('#loginAlert, #registerAlert').hide();

            if (tab === 'login') {
                loginForm.classList.add('active-form');
                registerForm.classList.remove('active-form');
                loginTabBtn.classList.add('active');
                registerTabBtn.classList.remove('active');
            } else {
                registerForm.classList.add('active-form');
                loginForm.classList.remove('active-form');
                registerTabBtn.classList.add('active');
                loginTabBtn.classList.remove('active');
            }
        }

        // Toggle Password Eye Icon
        function togglePasswordVisibility(inputId, iconElem) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                iconElem.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                iconElem.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Helper Function for Displaying Alerts
        function showAuthAlert(targetId, type, message) {
            var $alert = $(targetId);
            var isSuccess = (type === 'success');

            $alert.css({
                'background-color': isSuccess ? '#d4edda' : '#f8d7da',
                'color': isSuccess ? '#155724' : '#721c24',
                'border': '1px solid ' + (isSuccess ? '#c3e6cb' : '#f5c6cb')
            }).html(message).fadeIn();
        }

        // jQuery Ready - AJAX Form Handlers
        $(document).ready(function() {

            /* 1. LOGIN AJAX HANDLER */
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                var $btn = $('#loginBtn');
                var originalHtml = $btn.html();
                $('#loginAlert').hide();

                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Authenticating...');

                $.ajax({
                    url: 'api/login.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: $('#loginEmail').val().trim(),
                        password: $('#loginPassword').val().trim()
                    }),
                    success: function(response) {
                        if (response.success) {
                            showAuthAlert('#loginAlert', 'success', response.message);
                            setTimeout(function() {
                                window.location.href = response.redirect || 'profile.php';
                            }, 1200);
                        } else {
                            showAuthAlert('#loginAlert', 'error', response.message || 'Authentication failed.');
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Login Error:', xhr.responseText);
                        showAuthAlert('#loginAlert', 'error', 'A server error occurred. Please try again.');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            /* 2. REGISTER AJAX HANDLER */
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                var $btn = $('#registerBtn');
                var originalHtml = $btn.html();
                $('#registerAlert').hide();

                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Submitting...');

                $.ajax({
                    url: 'api/register.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        first_name: $('#regFirstName').val().trim(),
                        last_name: $('#regLastName').val().trim(),
                        email: $('#regEmail').val().trim(),
                        interest: $('#regInterest').val(),
                        password: $('#regPassword').val().trim()
                    }),
                    success: function(response) {
                        if (response.success) {
                            showAuthAlert('#registerAlert', 'success', response.message);
                            $('#registerForm')[0].reset();
                            setTimeout(function() {
                                switchAuthTab('login');
                            }, 2000);
                        } else {
                            showAuthAlert('#registerAlert', 'error', response.message || 'Registration failed.');
                        }
                        $btn.prop('disabled', false).html(originalHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error('Registration Error:', xhr.responseText);
                        showAuthAlert('#registerAlert', 'error', 'A server error occurred. Please try again.');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

        });
    </script>
</body>
</html>