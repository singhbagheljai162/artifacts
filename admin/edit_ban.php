<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM `banners` WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$get_prodata = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $id = $_POST['user_id'];
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $button_text = trim($_POST['button_text']);
    $button_link = trim($_POST['button_link']);
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

    $sql = "UPDATE banners SET
            title='$title',
            subtitle='$subtitle',
            button_text='$button_text',
            button_link='$button_link',
            image='$image',
            status='$status'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
        header("Location: ban_list.php");
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
    <title>Banner List</title>
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
                    <h4 class="card-title">Edit Banner</h4>
                   <form class="forms-sample" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="user_id" value="<?php echo $get_prodata['id']; ?>">
                   
                      <div class="form-group">
                        <label for="exampleInputFull Name3">Title</label>
                       <input type="text" class="form-control"  id="exampleInputemail" name="title" value="<?php echo $get_prodata['title']; ?>"placeholder="Title">
                      </div>
                       <div class="form-group">
                        <label for="exampleInputEmail">Sub Title</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="subtitle" value="<?php echo $get_prodata['subtitle'] ?>"placeholder="Subtitle">
                      </div>
                            <div class="form-group">
                        <label for="exampleInputEmail">Button Text</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="button_text" value="<?php echo $get_prodata['button_text'] ?>"placeholder="Button Text">
                      </div>  
                        <div class="form-group">
                        <label for="exampleInputEmail">Button Link</label>
                        <input type="text" class="form-control" id="exampleInputemail" name="button_link" value="<?php echo $get_prodata['button_link'] ?>"placeholder="Button Link">
                      </div>   
                      <div class="form-group">
                        <label for="exampleInputEmail">Add Banner Image</label>
                        <input type="file" class="form-control" id="exampleInputemail" name="image" value="<?php echo $get_prodata['image'] ?>"placeholder="Add Banner Image">
                      </div>
                       <div class="form-group">
                            <label for="exampleSelectStatus">Status</label>
                            <select name="status" class="form-select" id="exampleSelectStatus">
                                <option value="">Select Status</option>
                                <option value="1"
                                    <?php echo ($get_prodata['status'] == 1) ? 'selected' : ''; ?>>
                                    Active
                                </option>
                                <option value="0"
                                    <?php echo ($get_prodata['status'] == 0) ? 'selected' : ''; ?>>
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