<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: users_list.php");
    exit();
}

$user_id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");

if (mysqli_num_rows($result) == 0) {
    header("Location: users_list.php");
    exit();
}

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>

    <?php include('inc/css.php'); ?>
</head>

<body>

<div class="container-scroller">

    <?php include('inc/nev.php'); ?>

    <div class="container-fluid page-body-wrapper">

        <?php include('inc/sidebar.php'); ?>

        <div class="main-panel">

            <div class="content-wrapper">

                <div class="page-header">
                    <h3 class="page-title">User Details</h3>
                </div>

                <div class="row">

                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">User Information</h4>

                                <div class="row">

                                    <!-- User Image -->
                                    <div class="col-md-4 text-center">

                                        <?php
                                        if (!empty($user['image']) && file_exists("../images/user/" . $user['image'])) {
                                        ?>

                                            <img src="../images/user/<?php echo $user['image']; ?>"
                                                class="img-fluid rounded"
                                                width="220">

                                        <?php
                                        } else {
                                        ?>

                                            <img src="../images/no-image.png"
                                                class="img-fluid rounded"
                                                width="220">

                                        <?php
                                        }
                                        ?>

                                    </div>

                                    <!-- User Details -->
                                    <div class="col-md-8">

                                        <table class="table table-bordered">

                                            <tr>
                                                <th width="30%">Full Name</th>
                                                <td><?php echo $user['full_name']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $user['email']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Phone</th>
                                                <td><?php echo $user['phone']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Gender</th>
                                                <td><?php echo $user['gender']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $user['address']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>City</th>
                                                <td><?php echo $user['city']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>State</th>
                                                <td><?php echo $user['state']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Country</th>
                                                <td><?php echo $user['country']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Pincode</th>
                                                <td><?php echo $user['pincode']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>Role</th>
                                                <td>
                                                    <?php
                                                    if ($user['role'] == 1) {
                                                        echo '<span class="badge badge-success">Admin</span>';
                                                    } else {
                                                        echo '<span class="badge badge-info">Customer</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php
                                                    if ($user['status'] == 1) {
                                                        echo '<span class="badge badge-success">Active</span>';
                                                    } else {
                                                        echo '<span class="badge badge-danger">Inactive</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Created At</th>
                                                <td><?php echo $user['created_at']; ?></td>
                                            </tr>

                                        </table>

                                        <a href="users_list.php" class="btn btn-secondary">
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

        </div>

    </div>

</div>

<?php include('inc/js.php'); ?>

</body>
</html>