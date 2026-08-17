<?php
require_once "config.php";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND status='Active'");
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $result = $stmt->get_result();

if($result->num_rows == 1)
{
    $user = $result->fetch_assoc();

    if(password_verify($password, $user['password']))
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: admin/dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Password.";
    }
}
else
{
    $error = "Invalid Username.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="dist/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="dist/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="dist/assets/images/logo.svg">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form name="login" class="pt-3" method="POST">
                    <?php if(isset($error)){ echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
                  <div class="form-group">
                    <input type="text" name="username" placeholder="Username" class="form-control form-control-lg" id="username" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" name="login" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                  </div>
                  <div class="mb-2 d-grid gap-2">
                    <button name="login" type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="registration.php" class="text-primary">Create</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="dist/assets/js/off-canvas.js"></script>
    <script src="dist/assets/js/misc.js"></script>
    <script src="dist/assets/js/settings.js"></script>
    <script src="dist/assets/js/todolist.js"></script>
    <script src="dist/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>
</html>