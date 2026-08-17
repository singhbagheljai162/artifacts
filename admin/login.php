<?php
require_once "../includes/config.php";

$error = "";

if (isset($_POST['login'])) {

  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND status = 'Active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
     
    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Password";
        }

    } else {
        $error = "Invalid Email";
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
    <?php include ('inc/css.php'); ?>
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
                    <?php if($error!=''){ echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
                   <div class="form-group">
                   <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
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
   <?php include('inc/js.php'); ?>
    <!-- endinject -->
  </body>
</html>