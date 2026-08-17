<?php
require_once "../includes/config.php";


if(isset($_POST['add']))
{
    $errors = [];

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $role = trim($_POST['role']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $pincode = trim($_POST['pincode']);
    $address = trim($_POST['address']);
    $status = trim($_POST['status']);

    $image = "";

    // Image Upload
    $profile_image = "";

if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0){

    $allowed = ['jpg','jpeg','png','gif'];

    $file_name = $_FILES['profile_image']['name'];
    $tmp_name  = $_FILES['profile_image']['tmp_name'];

    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if(in_array($extension, $allowed)){

        $new_name = time().rand(1000,9999).".".$extension;

        move_uploaded_file($tmp_name, "../images/user/".$new_name);

        $profile_image = $new_name;

    }else{
        $errors[] = "Only JPG, JPEG, PNG and GIF files are allowed.";
    }
}

    // Validation
    if(empty($full_name)){
        $errors[] = "Full Name is required.";
    }

    if(empty($email)){
        $errors[] = "Email is required.";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid Email Address.";
    }

    if(empty($phone)){
        $errors[] = "Phone Number is required.";
    }elseif(!preg_match("/^[0-9]{10}$/", $phone)){
        $errors[] = "Phone Number must be 10 digits.";
    }

    if(empty($gender)){
        $errors[] = "Please select Gender.";
    }

    if(empty($role)){
        $errors[] = "Please select Role.";
    }

    if(empty($city)){
        $errors[] = "City is required.";
    }

    if(empty($state)){
        $errors[] = "State is required.";
    }

    if(empty($country)){
        $errors[] = "Country is required.";
    }

    if(empty($pincode)){
        $errors[] = "Pincode is required.";
    }elseif(!preg_match("/^[0-9]{6}$/", $pincode)){
        $errors[] = "Pincode must be 6 digits.";
    }

    if(empty($address)){
        $errors[] = "Address is required.";
    }

    if($status === ""){
        $errors[] = "Please select Status.";
    }

    // Insert Record
    if(count($errors) == 0){

      $sql = "INSERT INTO users
            (full_name, email, phone, gender, role, city, state, country, pincode, address, status, profile_image)
            VALUES
            ('$full_name', '$email', '$phone', '$gender', '$role', '$city', '$state', '$country', '$pincode', '$address', '$status', '$profile_image')";

            if(mysqli_query($conn, $sql)){
               header("Location: users_list.php");
                exit();
                 } else {
               die(mysqli_error($conn));
                }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add User</title>
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
                    <h4 class="card-title">Add User</h4>
                    
                   <form class="forms-sample" method="POST" enctype="multipart/form-data">
                    <?php if(!empty($errors)){ ?>
                      <div class="alert alert-danger">
                          <ul class="mb-0">
                              <?php foreach($errors as $error){ ?>
                                  <li><?php echo $error; ?></li>
                              <?php } ?>
                          </ul>
                      </div>
                      <?php } ?>
                    
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Full Name</label>
                        <input type="text" class="form-control" id="exampleInputfull_name3" name="full_name" value="<?php echo isset($_POST['full_name'])? $_POST['full_name']:""; ?>"placeholder="Full Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Email</label>
                        <input type="email" class="form-control" id="exampleInputfull_name3" name="email" value="<?php echo isset($_POST['email'])? $_POST['email']:""; ?>"placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Phone</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" name="phone" value="<?php echo isset($_POST['phone'])? $_POST['phone']:""; ?>"placeholder="Phone">
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Gender</label>
                        <select name="gender" class="form-select" id="exampleSelectGender">
                          <option value="">Select Gender</option>

                          <option value="Male"  <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>> Male</option>

                          <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>> Female </option>

                          <option value="Other"<?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>> Other </option>

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Role</label>
                        <select name="role" class="form-select" id="exampleSelectGender">
                          <option value="">Select Role</option>

                          <option value="Admin"  <?php echo (isset($_POST['role']) && $_POST['role'] == 'Admin') ? 'selected' : ''; ?>> Admin</option>

                          <option value="Customer" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Customre') ? 'selected' : ''; ?>> Customer </option>

                        </select>
                      </div> 

                       <div class="form-group">
                        <label for="selectcountry">Country</label>
                        <select name="country" class="form-select" id="selectcountry">
                          <option value ="" >Select Country  </option>
                          
                        <?php
                              $country = mysqli_query($conn,"SELECT * FROM countries WHERE status='Active'");
                              while($row=mysqli_fetch_assoc($country)){
                        ?>
                          <option value="<?= $row['id']; ?>"<?php echo (isset($_POST['country']) && $_POST['country'] == $row) ? $row['id'] : ''; ?>> <?= $row['country_name']; ?></option>
                          <?php 
                              } 
                            ?>
                        </select>
                      </div>

                       <div class="form-group">
                        <label for="selectstate">State</label>
                        <select name="state" class="form-select" id="selectstate">
                          <option value ="" >Select State  </option>
                          
                        
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="selectcity">City</label>
                        <select name="city" class="form-select" id="selectcity">
                          <option value ="" >Select City  </option>
                          
                        </select>
                      </div>


                         <div class="form-group">
                        <label for="exampleInputPassword4">Pincode</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" name="pincode" value="<?php echo  isset($_POST['pincode'])? $_POST['pincode']:""; ?>" placeholder="Pincode">
                      </div>
                             <div class="form-group">
                             <label>User Image</label>
                             <input type="file" name="profile_image" class="form-control">
                             </div>
                     
                      <div class="form-group">
                        <label for="exampleTextarea1">Address</label>
                        <textarea class="form-control" id="exampleTextarea1" name="address" rows="4"><?php echo isset($_POST['address'])? $_POST['address']:"";  ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Status</label>
                        <select name="status" class="form-select" id="exampleSelectStatus">
                          <option value ="" >Select Status  </option>
                          <<option value="1"<?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>> Active</option>

                          <option value="0"<?php echo (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : ''; ?>> Inactive</option>
                        </select>
                      </div>
                      <button type="submit" name="add" class="btn btn-gradient-primary me-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include('inc/footer.php'); ?>
              </div>
            </div>
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