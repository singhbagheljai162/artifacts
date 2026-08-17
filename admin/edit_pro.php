<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pro_id = $_GET['id'];

$sql = "SELECT * FROM `products` WHERE id='$pro_id'";
$result = mysqli_query($conn, $sql);
$get_prodata = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $id = $_POST['user_id'];

    $category_id  = $_POST['category_id'];
    $product_name = trim($_POST['product_name']);
    $product_code = trim($_POST['product_code']);
    $price        = $_POST['price'];
    $discount     = $_POST['discount'];
    $stock        = $_POST['stock'];
    $material     = trim($_POST['material']);
    $origin       = trim($_POST['origin']);
    $description  = trim($_POST['description']);
    $status       = $_POST['status'];

    $main_image = $get_prodata['main_image'];

    if(isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0){

        $allowed = ['jpg','jpeg','png','gif'];

        $extension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));

        if(in_array($extension,$allowed)){

            $new_name = time().rand(1000,9999).".".$extension;

            move_uploaded_file($_FILES['main_image']['tmp_name'], "../images/".$new_name);

            $main_image = $new_name;
        }
    }

    $sql = "UPDATE products SET
            category_id='$category_id',
            product_name='$product_name',
            product_code='$product_code',
            price='$price',
            discount='$discount',
            stock='$stock',
            material='$material',
            origin='$origin',
            description='$description',
            main_image='$main_image',
            status='$status'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
        header("Location: pro_list.php");
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
    <title>Product List</title>
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
                    <h4 class="card-title">Edit Product</h4>
                   <form class="forms-sample" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="user_id" value="<?php echo $get_prodata['id']; ?>">
                   
                      <div class="form-group">
                        <label for="exampleSelectGender">Category</label>
                        <select required name="category_id" class="form-select" id="exampleSelectStatus">
                          <option >Select Category  </option>

                          <?php 
                          
                          $cat=mysqli_query($conn,"SELECT * FROM `categories`  WHERE status='Active'");

                          while ($iCat = mysqli_fetch_assoc($cat)) {
                           
                          ?>
                          <option value="<?php echo $iCat['id']?>" <?php echo ( $iCat['id'] == $get_prodata['category_id']) ? 'selected' : ''; ?>> <?php echo $iCat['category_name']?></option>
                        <?php } ?>
                        </select>
                      </div>

                       <div class="form-group">
                        <label for="exampleInputEmail">Product Name</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="product_name" value="<?php echo $get_prodata['product_name'] ?>"placeholder="Product Name">
                      </div>
                        <div class="form-group">
                        <label for="exampleInputEmail">Product Code</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="product_code" value="<?php echo $get_prodata['product_code'] ?>"placeholder="Product Name">
                      </div> 
                        <div class="form-group">
                        <label for="exampleInputEmail">Price</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="price" value="<?php echo $get_prodata['price'] ?>"placeholder="Product Name">
                      </div> 
                        <div class="form-group">
                        <label for="exampleInputEmail">Discount</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="discount" value="<?php echo $get_prodata['discount'] ?>"placeholder="Discount">
                      </div> 
                        <div class="form-group">
                        <label for="exampleInputEmail">Stock</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="stock" value="<?php echo $get_prodata['stock'] ?>"placeholder="Stock">
                      </div> 
                        <div class="form-group">
                        <label for="exampleInputEmail">Material</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="material" value="<?php echo $get_prodata['material'] ?>"placeholder="Material">
                      </div> 
                        <div class="form-group">
                        <label for="exampleInputEmail">Origin</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="origin" value="<?php echo $get_prodata['origin'] ?>"placeholder="Origin">
                      </div> 
                      <div class="form-group">
                        <label for="exampleInputEmail">Add Category Image</label>
                        <input type="file" class="form-control" id="exampleInputemail" name="main_image" value="<?php echo $get_prodata['main_image'] ?>"placeholder="Add Category Image">
                        <?php if(!empty($get_prodata['main_image'])){ ?>
                        <img src="../images/<?php echo $get_prodata['main_image']; ?>" width="120">
                      <?php } ?>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputdescription">Description</label>
                       <textarea class="form-control"name="description" rows="4"><?php echo $get_prodata['description']; ?></textarea>
                      </div> 
                      <div class="form-group">
                        <label for="exampleSelectGender">Status</label>
                        <select name="status" class="form-select" id="exampleSelectStatus">
                          <option >Select Status  </option>
                          <option value="Active" <?php echo ($get_prodata['status']=='Active')? "Selected":"";?>>Active</option>
                          <option  value="Inactive" <?php echo ($get_prodata['status']=='Inactive')? "Selected":"";?>>Inactive</option>
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