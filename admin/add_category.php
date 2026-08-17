<?php
require_once "../includes/config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if(isset($_POST['add']))
{
   $errors = [];
    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);
    $status = trim($_POST['status']);
    $image = "";

      if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

          $allowed = ['jpg','jpeg','png','gif'];

          $file_name = $_FILES['image']['name'];
          $tmp_name  = $_FILES['image']['tmp_name'];

          $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

          if(in_array($extension,$allowed)){

              $new_name = time().rand(1000,9999).".".$extension;

              move_uploaded_file($tmp_name,"../images/".$new_name);

              $image = $new_name;

          }else{
              $errors[] = "Only JPG, JPEG, PNG and GIF files are allowed.";
          }
      }
    // Category name
    if(empty($category_name)){
        $errors[] = "Category name is required.";
    }

    // Description
    if(empty($description)){
        $errors[] = "Description is required.";
    }

     // Description
    if(empty($status)){
        $errors[] = "Status is required.";
    }
    

    

    // Insert only if no errors
    if(count($errors) == 0){

        $sql = "INSERT INTO categories
        (category_name, image, description, status)
        VALUES
        ('$category_name','$image','$description','$status')";

        if(mysqli_query($conn,$sql)){
            header("Location: category_list.php");
            exit();
        }else{
            $errors[] = mysqli_error($conn);
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
    <title>Add Category</title>
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
                    <h4 class="card-title">Add Category</h4>
                    
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
                        <label for="exampleInputEmployee_id1">Category Name</label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="category_name" value="<?php echo isset($_POST['category_name'])? $_POST['category_name']:"";?>" placeholder="Category Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Description</label>
                        <textarea class="form-control" id="exampleInputPassword4" rows="4" name="description" value="" placeholder="Description">
                            <?php echo isset($_POST['description'])? $_POST['description']:""; ?>
                        </textarea>
                      </div>  
                      <div class="form-group">
                        <label>Catagory Image</label>
                        <input type="file" name="image" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Status</label>
                        <select name="status" class="form-select" id="exampleSelectStatus">
                          <option >Select Status  </option>
                          <<option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Active') ? 'selected' : ''; ?>> Active</option>

                          <option value="Inactive"  <?php echo (isset($_POST['status']) && $_POST['status'] == 'Inactive') ? 'selected' : ''; ?>> Inactive</option>
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
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="../../assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>