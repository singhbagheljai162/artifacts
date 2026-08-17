<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['save'])) {

    $city_name = mysqli_real_escape_string($conn, trim($_POST['city_name']));
    $status = $_POST['status'];
    $state_id = $_POST['state_id'];

    $sql = "INSERT INTO cities (state_id,city_name, status)
            VALUES ('$state_id','$city_name', '$status')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Country added successfully.";
        header("Location: city_list.php");
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
        <title>Add City</title>

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
                                        <h3>Add City</h3>
                                    </div>

                                    <div class="card-body">

                                        <?php if (isset($error)) { ?>
                                            <div class="alert alert-danger">
                                                <?= $error; ?>
                                            </div>
                                            <?php } ?>
                                                <form method="POST">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select name="country_id" class="form-select" required id="selectcountry">
                                                            <option value="">Select Country</option>
                                                            <?php 
                                                            $countryResult=mysqli_query($conn,"SELECT * FROM `countries`");
                                                                while($country = mysqli_fetch_assoc($countryResult)){ ?>
                                                                <option value="<?= $country['id']; ?>">
                                                                    <?= $country['country_name']; ?>
                                                                </option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="selectstate">State</label>
                                                        <select name="state_id" class="form-select" id="selectstate">
                                                        <option value ="" >Select State  </option>
                                                        </select>
                                                    </div>
                                                 
                                                    <div class="form-group">
                                                        <label class="form-label">City name</label>
                                                        <input name="city_name"  class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleSelectGender">Status</label>
                                                        <select name="status" class="form-select" id="exampleSelectStatus">
                                                        <option >Select Status  </option>
                                                        <<option value="1" <?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>> Active</option>

                                                        <option value="0"  <?php echo (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : ''; ?>> Inactive</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="save" class="btn btn-primary">
                                                        Save City
                                                    </button>
                                                    <a href="city_list.php" class="btn btn-secondary">
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