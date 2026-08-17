<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM `categories` WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$get_prodata = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $id = $_POST['cat_id'];
    $category_name = trim($_POST['category_name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    $image = $get_prodata['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error']==0){

        $allowed = ['jpg','jpeg','png','gif'];

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(in_array($extension,$allowed)){

            $new_name = time().rand(1000,9999).".".$extension;

            move_uploaded_file($_FILES['image']['tmp_name'],"../images/".$new_name);

            $image = $new_name;
        }
    }

    $sql = "UPDATE categories SET
            category_name='$category_name',
            image='$image',
            description='$description',
            status='$status'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
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
                    <h4 class="card-title">Edit Category</h4>
                   <form class="forms-sample" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="cat_id" value="<?php echo $get_prodata['id']; ?>">
                   
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Category Name</label>
                       <input type="text" class="form-control"  id="exampleInputemail" name="category_name" value="<?php echo $get_prodata['category_name']; ?>"placeholder="Category Name">
                      </div> 
                      <div class="form-group">
                        <label for="exampleInputEmail">Add Category Image</label>
                        <input type="file" class="form-control" id="exampleInputemail" name="image" value=""placeholder="Add Category Image">

                        <img width="150" src="<?php echo SITE_URL.'images/'.$get_prodata['image'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputdescription">Description</label>
                       <textarea class="form-control"name="description" rows="4"><?php echo $get_prodata['description']; ?></textarea>
                      </div> 
                      <div class="form-group">
                          <label for="exampleSelectStatus">Status</label>
                          <select name="status" class="form-select" id="exampleSelectStatus">
                              <option value="">Select Status</option>
                              <option value="Active"
                                  <?php echo ($get_prodata['status'] == 'Active') ? 'selected' : ''; ?>>
                                  Active
                              </option>
                              <option value="Inactive"
                                  <?php echo ($get_prodata['status'] == 'Inactive') ? 'selected' : ''; ?>>
                                  Inactive
                              </option>
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