<?php
require_once "../includes/config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {

    $errors = [];
    $category_id = trim($_POST['category_id']); // Better rename field to category_id
    $product_name = trim($_POST['product_name']);
    $product_code = trim($_POST['product_code']);
    $price = trim($_POST['price']);
    $discount = trim($_POST['discount']);
    $stock = trim($_POST['stock']);
    $material = trim($_POST['material']);
    $origin = trim($_POST['origin']);
    $description = trim($_POST['description']);
    $status = trim($_POST['status']);

    $main_image = "";
    $allowed = ['jpg','jpeg','png','gif'];
    // Image Upload
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {

        

        $file_name = $_FILES['main_image']['name'];
        $tmp_name = $_FILES['main_image']['tmp_name'];

        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($extension, $allowed)) {

            $new_name = time() . rand(1000,9999) . "." . $extension;

            move_uploaded_file($tmp_name, "../images/" . $new_name);

            $main_image = $new_name;

        } else {
            $errors[] = "Only JPG, JPEG, PNG and GIF files are allowed.";
        }
    }

    // upload multiple images
    if (isset($_FILES['all_images']) && !empty($_FILES['all_images']['name'][0])) {
        $all_images = $_FILES['all_images'];
        $uploaded_images = [];

        for ($i = 0; $i < count($all_images['name']); $i++) {
            if ($all_images['error'][$i] == 0) {
                $file_name = $all_images['name'][$i];
                $tmp_name = $all_images['tmp_name'][$i];
                $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (in_array($extension, $allowed)) {
                    $new_name = time() . rand(1000,9999) . "." . $extension;
                    move_uploaded_file($tmp_name, "../images/" . $new_name);
                    $uploaded_images[] = $new_name;
                } else {
                    $errors[] = "Only JPG, JPEG, PNG and GIF files are allowed for all images.";
                }
            }
        }

        // Convert array of uploaded images to a comma-separated string
        if (!empty($uploaded_images)) {
            $all_images_str = implode(',', $uploaded_images);
        } else {
            $all_images_str = '';
        }
    } else {
        $all_images_str = '';
    }

    // Validation
    if (empty($category_id)) $errors[] = "Category is required.";
    if (empty($product_name)) $errors[] = "Product name is required.";
    if (empty($product_code)) $errors[] = "Product code is required.";
    if (empty($price)) $errors[] = "Price is required.";
    if (empty($stock)) $errors[] = "Stock is required.";
    if (empty($status)) $errors[] = "Status is required.";

    if (count($errors) == 0) {

        $sql = "INSERT INTO  `products`
        (category_id, product_name, product_code, price, discount, stock, material, origin, description, main_image, status)
        VALUES
        ('$category_id','$product_name','$product_code','$price','$discount','$stock','$material','$origin','$description','$main_image','$status')";

        $myqr=mysqli_query($conn,$sql);

        if ($myqr){
            //insert multiple images into product_images table
            if (!empty($all_images_str)) {
                $product_id = mysqli_insert_id($conn);
                $images = explode(',', $all_images_str);
                foreach ($images as $image) {
                    $sql_images = "INSERT INTO `product_images` (product_id, image) VALUES ('$product_id', '$image')";
                    mysqli_query($conn, $sql_images);
                }
            }

            header("Location: pro_list.php");
            exit();
        } else {
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
    <title>Add Product</title>
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
                    <h4 class="card-title">Add Product</h4>
                    
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
                        <label for="exampleSelectGender">Category</label>
                        <select required name="category_id" class="form-select" id="exampleSelectStatus">
                          <option >Select Category  </option>

                          <?php 
                          
                          $cat=mysqli_query($conn,"SELECT * FROM `categories` WHERE status='Active'");

                          while ($iCat = mysqli_fetch_assoc($cat)) {
                           
                          ?>
                          <option value="<?php echo $iCat['id']?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $iCat['id']) ? 'selected' : ''; ?>> <?php echo $iCat['category_name']?></option>
                        <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmployee_id1">Product Name</label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="product_name" value="<?php echo isset($_POST['product_name'])? $_POST['product_name']:"";?>" placeholder="Product Name">
                      </div>
                         <div class="form-group">
                        <label for="exampleInputEmployee_id1">Product Code </label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="product_code" value="<?php echo isset($_POST['product_code'])? $_POST['product_code']:"";?>" placeholder="Product Code ">
                      </div>
                         <div class="form-group">
                        <label for="exampleInputEmployee_id1">Price</label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="price" value="<?php echo isset($_POST['price'])? $_POST['price']:"";?>" placeholder="Price">
                      </div>
                         <div class="form-group">
                        <label for="exampleInputEmployee_id1">Discount</label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="discount" value="<?php echo isset($_POST['discount'])? $_POST['discount']:"";?>" placeholder="Discount">
                      </div>
                         <div class="form-group">
                        <label for="exampleInputEmployee_id1">Stock</label>
                        <input required type="text" class="form-control" id="exampleInputProduct_id1" name="stock" value="<?php echo isset($_POST['stock'])? $_POST['stock']:"";?>" placeholder="Stock">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Material</label>
                        <input type="text" class="form-control" id="exampleInputfull_name3" name="material" value="<?php echo isset($_POST['material'])? $_POST['material']:""; ?>"placeholder="Material">
                      </div>
                        <div class="form-group">
                        <label for="exampleInputFull Name3">Origin</label>
                        <input type="text" class="form-control" id="exampleInputfull_name3" name="origin" value="<?php echo isset($_POST['origin'])? $_POST['origin']:""; ?>"placeholder="Origin">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Description</label>
                        <textarea class="form-control" id="exampleInputPassword4" rows="4" name="description" value="" placeholder="Description"><?php echo isset($_POST['description'])? $_POST['description']:""; ?></textarea>
                      </div>  
                      <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" name="main_image" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Product All Image</label>
                        <input type="file" name="all_images[]" class="form-control" multiple>
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