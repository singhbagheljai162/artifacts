<?php
require_once "../includes/config.php";

if(isset($_POST['signup']))
{
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $status = $_POST['status'];

   // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare ("INSERT INTO users (full_name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssss",
        $full_name,
        $email,
        $hashedPassword,
        $fullname,
        $role,
        $status
    );

    if($stmt->execute())
    {
        echo "<script>alert('User created successfully.');</script>";
         header("Location: login.php");
         exit();
    }
    else
    {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Artifacts</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo SITE_URL;?>dist/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo SITE_URL;?>dist/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="<?php echo SITE_URL;?>dist/assets/images/logo.svg">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" method="POST">
                    <div class="form-group">
                    <input type="text" name="fullname" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                    </div>

                  <div class="form-group">
                    <select name="role" class="form-select form-select-lg" id="exampleFormControlSelect2">
                      <option>Role</option>
                      <option value="admin">Admin</option>
                      <option vale="editor">Editor</option>
                      <option vale="user">User</option>
                    </select>
                  </div>

                   <div class="form-group">
                    <select name ="status" class="form-select form-select-lg" id="exampleFormControlSelect2">
                      <option>Status</option>
                      <option value="active">Active</option>
                      <option vale="inactive">Inactive</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input name ="password" type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  
                  <div class="mt-3 d-grid gap-2">
                    <button name="signup" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" >SIGN UP</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="login.php" class="text-primary">Login</a>
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
    <script src="<?php echo SITE_URL;?>dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo SITE_URL;?>dist/assets/js/off-canvas.js"></script>
    <script src="<?php echo SITE_URL;?>dist/assets/js/misc.js"></script>
    <script src="<?php echo SITE_URL;?>dist/assets/js/settings.js"></script>
    <script src="<?php echo SITE_URL;?>dist/assets/js/todolist.js"></script>
    <script src="<?php echo SITE_URL;?>dist/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>
</html>