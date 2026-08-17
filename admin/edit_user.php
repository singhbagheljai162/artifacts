<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$get_userdata = mysqli_fetch_assoc($result);


if (isset($_POST['update'])) {

    $user_id   = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $gender    = $_POST['gender'];
    $role      = $_POST['role'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];
    $address   = $_POST['address'];
    $status    = $_POST['status'];

    $sql = "UPDATE users SET
            full_name='$full_name',
            email='$email',
            phone='$phone',
            gender='$gender',
            role='$role',
            city='$city',
            state='$state',
            country='$country',
            pincode='$pincode',
            address='$address',
            status='$status'
            WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: users_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users List</title>
    <!-- plugins:css -->
    <?php include ('inc/css.php'); ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include ('inc/nev.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <?php include ('inc/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Form elements </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit User</h4>
                    <form class="forms-sample" method="POST">
                     <input type="hidden" name="user_id" value="<?php echo $get_userdata['id']; ?>">
                   
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Full Name</label>
                        <input type="full_name" class="form-control" id="exampleInputfull_name3" name="full_name" value="<?php echo $get_userdata['full_name'] ?>"placeholder="Full Name">
                      </div>
                       <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control" id="exampleInputemail" name="email" value="<?php echo $get_userdata['email'] ?>"placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Phone</label>
                        <input type="test" class="form-control" id="exampleInputPassword4" name="phone" value="<?php echo $get_userdata['phone'] ?>"placeholder="Phone">
                      </div>
                      
                      <div class="form-group">
                        <label for="selectcountry">Country</label>
                        <select name="country" class="form-select" id="selectcountry">
                          <option value ="" >Select Country  </option>
                          
                        <?php
                              $country = mysqli_query($conn,"SELECT * FROM countries WHERE status='Active'");
                              while($row=mysqli_fetch_assoc($country)){
                        ?>
                          <option value="<?= $row['id']; ?>" <?php echo (isset($get_userdata['country']) && $get_userdata['country'] == $row['id']) ? 'selected' : ''; ?>> <?= $row['country_name']; ?></option>
                          <?php 
                              } 
                            ?>
                        </select>
                      </div>

                       <div class="form-group">
                        <label for="selectstate">State</label>
                        <select name="state" class="form-select" id="selectstate">
                           <option value ="" >Select State  </option>
                          <?php
                          $state = mysqli_query($conn, "SELECT * FROM states WHERE country_id ='".$get_userdata['country']."'");
                          while($row = mysqli_fetch_assoc($state)){
                          ?>
                           <option value="<?= $row['id']; ?>" <?php echo (isset($get_userdata['state']) && $get_userdata['state'] == $row['id']) ? 'selected' : ''; ?>> <?= $row['state_name']; ?></option>
                          
                        <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="selectcity">City</label>
                        <select name="city" class="form-select" id="selectcity">
                          <option value ="" >Select City  </option>
                            <?php
                                $state = mysqli_query($conn, "SELECT * FROM cities WHERE state_id='".$get_userdata['state']."'");
                                while($row = mysqli_fetch_assoc($state)){
                            ?>
                          <option value="<?= $row['id']; ?>" <?php echo (isset($get_userdata['city']) && $get_userdata['city'] == $row['id']) ? 'selected' : ''; ?>> <?= $row['city_name']; ?></option>
                           <?php } ?>
                        </select>
                      </div>

                        <div class="form-group">
                        <label for="exampleInputPassword4">Pin-Code</label>
                        <input type="text" class="form-control"
                         name="pincode"value="<?php echo $get_userdata['pincode']; ?>"
                         placeholder="Pincode">
                        </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Gender</label>
                        <select name="gender" class="form-select" id="exampleSelectGender">
                          <option >Select Gender  </option>
                          <option value="Male" <?php echo ($get_userdata['gender']=='Male')? "Selected":"";?>>Male</option>
                          <option  value="Female" <?php echo ($get_userdata['gender']=='Female')? "Selected":"";?>>Female</option>
                          <option  value="Other" <?php echo ($get_userdata['gender']=='Other')? "Selected":"";?>>Other</option>
                        </select>
                      </div>
                     
                          <div class="form-group">
                        <label for="exampleSelectGender">Role</label>
                        <select name="role" class="form-select" id="exampleSelectRole">
                          <option >Select Role </option>
                          <option value="Admin" <?php echo ($get_userdata['role']=='Admin')? "Selected":"";?>>Admin</option>
                          <option  value="Customer" <?php echo ($get_userdata['role']=='Customer')? "Selected":"";?>>Customer</option>
                        </select>
                      <div class="form-group">
                        <label for="exampleTextarea1">Address</label>
                        <textarea class="form-control" id="exampleTextarea1" name="address" rows="4"><?php echo $get_userdata['address'] ?></textarea>
                      </div>
                       
                      <div class="form-group">
                        <label for="exampleSelectGender">Status</label>
                        <select name="status" class="form-select" id="exampleSelectStatus">
                          <option >Select Status  </option>
                          <option value="1" <?php echo ($get_userdata['status']=='1')? "Selected":"";?>>Active</option>
                          <option  value="0" <?php echo ($get_userdata['status']=='0')? "Selected":"";?>>Inactive</option>
                        </select>
                      </div>
                      <button type="submit" name="update" class="btn btn-gradient-primary me-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
       <?php include('inc/footer.php'); ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
<?php include('inc/js.php'); ?>

    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>