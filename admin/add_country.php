<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['save'])) {

    $country_name = mysqli_real_escape_string($conn, trim($_POST['country_name']));
    $status = $_POST['status'];

    $sql = "INSERT INTO countries (country_name, status)
            VALUES ('$country_name', '$status')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Country added successfully.";
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
    <title>Add Country</title>

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
                        <h3>Add Country</h3>
                    </div>

                    <div class="card-body">

                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php } ?>

                        <form method="POST">

                            <div class="form-group">
                                <label class="form-label">Country Name</label>
                                <input type="text"
                                       name="country_name"
                                       class="form-control"
                                       placeholder="Enter Country Name"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>

                                <select name="status" class="form-select">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>

                            </div>

                            <button type="submit" name="save" class="btn btn-primary">
                                Save Country
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