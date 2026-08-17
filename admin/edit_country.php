<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {


    $country_id   = $_POST['c_id'];
    $country_name = mysqli_real_escape_string($conn, trim($_POST['country_name']));
    $status = $_POST['status'];

    $sql = "UPDATE countries SET country_name='$country_name', status='$status' WHERE id='$country_id'";

    if (mysqli_query($conn, $sql)) {
        
        header("Location: country_list.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Country</title>

    <?php include('inc/css.php'); ?>
</head>

<body>

<div class="container-scroller">

    <?php include('inc/nev.php'); ?>

    <div class="container-fluid page-body-wrapper">

        <?php include('inc/sidebar.php'); ?>

        <div class="main-panel">

            <div class="content-wrapper">

                <div class="card">

                    <div class="card-header">
                        <h3>Edit Country</h3>
                    </div>

                    <div class="card-body">

                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php } ?>
                        <?php 
                        
                        $c_id = $_GET['id'];
                        $getcountry=mysqli_query($conn,"SELECT * FROM countries WHERE id='$c_id'");
                        
                        $cDetail=mysqli_fetch_assoc($getcountry);
                        ?>
                        <form method="POST" >
                            <input type="hidden" name="c_id" value="<?= $cDetail['id']; ?>">
                            <div class="form-group">
                                <label class="form-label">Country Name</label>
                                <input type="text"
                                       name="country_name"
                                       class="form-control"
                                       placeholder="Enter Country Name"
                                       required value="<?= $cDetail['country_name']; ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>

                                <select name="status" class="form-select">

                                    <option value="1" <?= ($cDetail['status']=="1")?'selected':''; ?>>Active</option>
                                    <option value="0" <?= ($cDetail['status']=="0")?'selected':''; ?>>Inactive</option>

                                </select>

                            </div>

                            <button type="submit" name="update" class="btn btn-primary">
                                Update Country
                            </button>

                            <a href="country_list.php" class="btn btn-secondary">
                                Back
                            </a>

                        </form>

                    </div>

                </div>

            </div>

            <?php include('inc/footer.php'); ?>

        </div>

    </div>

</div>

<?php include('inc/js.php'); ?>

</body>
</html>