<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM `settings` WHERE id='1'";
$result = mysqli_query($conn, $sql);
$get_setting = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $website_name = trim($_POST['website_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = $_POST['address'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $twitter = $_POST['twitter'];
    $youtube = $_POST['youtube'];

    $logo = $get_setting['logo'];
    $favicon = $get_setting['favicon'];

    if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){

        $allowed = ['jpg','jpeg','png','gif'];

        $extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

        if(in_array($extension,$allowed)){

            $new_name = time().rand(1000,9999).".".$extension;

            move_uploaded_file($_FILES['logo']['tmp_name'],"../images/setting/".$new_name);

            $logo = $new_name;
        }
    }

    if(isset($_FILES['favicon']) && $_FILES['favicon']['error']==0){

        $allowed = ['jpg','jpeg','png','gif'];

        $extension = strtolower(pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION));

        if(in_array($extension,$allowed)){

            $new_name = time().rand(1000,9999).".".$extension;

            move_uploaded_file($_FILES['favicon']['tmp_name'],"../images/setting/".$new_name);

            $favicon = $new_name;
        }
    }

    if (!$get_setting) {
        $sql = "INSERT INTO `settings` (id, website_name, email, phone, address, facebook, instagram, twitter, youtube, logo, favicon) VALUES ('1', '$website_name', '$email', '$phone', '$address', '$facebook', '$instagram', '$twitter', '$youtube', '$logo', '$favicon')";
        
    }else {
       $sql = "UPDATE settings SET
            website_name='$website_name',
            email='$email',
            phone='$phone',
            address='$address',
            facebook='$facebook',
            instagram='$instagram',
            twitter='$twitter',
            youtube='$youtube',
            logo='$logo',
            favicon='$favicon'
            WHERE id='1'";
           ;
    }

    

    if( mysqli_query($conn,$sql)){
        header("Location: category_list.php");
        exit();
    }else{
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Category List</title>
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
                    <h4 class="card-title">Website Settings</h4>
                   <form class="forms-sample" method="POST" enctype="multipart/form-data">

                      <div class="form-group">
                        <label for="exampleInputFull Name3">Website Name</label>
                       <input type="text" class="form-control"  id="exampleInputemail" name="website_name" value="<?php echo (isset($get_setting['website_name']))?$get_setting['website_name']:''; ?>"placeholder="Category Name">
                      </div>
                       <div class="form-group">
                        <label for="exampleInputEmail">email</label>
                        <input type="email" class="form-control" id="exampleInputemail" name="email" value="<?php echo (isset($get_setting['email']))?$get_setting['email']:''; ?>"placeholder="email">
                      </div>  
                      <div class="form-group">
                        <label for="exampleInputEmail">Website Logo</label>
                        <input type="file" class="form-control" id="exampleInputemail" name="logo" placeholder="Add Website Logo">
                        <img width="150" src="../images/setting/<?php echo (isset($get_setting['logo']))?$get_setting['logo']:''; ?>">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail">Website favicon</label>
                        <input type="file" class="form-control" id="exampleInputemail" name="favicon" placeholder="Add Website favicon">
                        <img width="150" src="../images/setting/<?php echo (isset($get_setting['favicon']))?$get_setting['favicon']:''; ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail">phone</label>
                        <input type="tel" class="form-control" id="exampleInputemail" name="phone" value="<?php echo (isset($get_setting['phone']))?$get_setting['phone']:''; ?>"placeholder="phone">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputdescription">Address</label>
                       <textarea class="form-control"name="address" rows="4"><?php echo (isset($get_setting['address']))?$get_setting['address']:''; ?></textarea>
                      </div> 

                      
                      <div class="form-group">
                        <label for="exampleInputEmail">facebook</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="facebook" value="<?php echo (isset($get_setting['facebook']))?$get_setting['facebook']:''; ?>"placeholder="facebook">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail">instagram</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="instagram" value="<?php echo (isset($get_setting['instagram']))?$get_setting['instagram']:''; ?>"placeholder="instagram">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail">twitter</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="twitter" value="<?php echo (isset($get_setting['twitter']))?$get_setting['twitter']:''; ?>"placeholder="twitter">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail">youtube</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="youtube" value="<?php echo (isset($get_setting['youtube']))?$get_setting['youtube']:''; ?>"placeholder="youtube">
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