<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$ban_id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM `banners` WHERE id='$ban_id'");
$get_bandata = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $id = $_POST['user_id'];
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $button_text = trim($_POST['button_text']);
    $button_link = trim($_POST['button_link']);
    $status = $_POST['status'];

    $image = $get_bandata['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error']==0){

        $allowed = ['jpg','jpeg','png','gif'];

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(in_array($extension,$allowed)){

            $new_name = time().rand(1000,9999).".".$extension;

            move_uploaded_file($_FILES['image']['tmp_name'],"../banners/".$new_name);

            $image = $new_name;
        }
    }

    $sql = "UPDATE banners SET
            title='$title',
            subtitle='$subtitle',
            image='$image',
            button_text='$button_text',
            button_link='$button_link',
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
                    <h4 class="card-title">Banner Details</h4>
                   
                  </div>
                  <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 text-center">

                        <?php
                        if(!empty($get_bandata['image']) && file_exists("../banners/".$get_bandata['image'])){
                        ?>
                        <img src="../banners/<?php echo $get_bandata['image']; ?>"
                        class="img-fluid rounded"
                        width="400">
                        <?php
                        } else {
                        ?>
                         <img src="../banners/no-image.png"
                        class="img-fluid rounded"
                        width="00">
                        <?php
                        }
                        ?>

                        </div>

                        <div class="col-md-8">

                            <table class="table table-bordered">

                                <tr>
                                    <th>Title</th>
                                    <td><?php echo $get_bandata['title']; ?></td>
                                </tr>

                                <tr>
                                    <th>Subtitle</th>
                                    <td><?php echo $get_bandata['subtitle']; ?></td>
                                </tr>

                                <tr>
                                    <th>Button_text</th>
                                    <td><?php echo $get_bandata['button_text']; ?></td>
                                </tr>
                                   <tr>
                                    <th>Button_link</th>
                                     <td>
                                            <a href="<?= $get_bandata['button_link']; ?>"
                                            class="btn btn-link btn-fw"
                                            target="_blank">
                                                <?= $get_bandata['button_text']; ?>
                                            </a>
                                        </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php
                                        if($get_bandata['status']==1){
                                            echo '<span class="badge badge-success">Active</span>';
                                        }else{
                                            echo '<span class="badge badge-danger">Inactive</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </table>

                            <a href="ban_list.php" class="btn btn-secondary">
                                Back
                            </a>

                        </div>

                    </div>

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