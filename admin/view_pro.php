<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: pro_list.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Product not found.");
}

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>

    <?php include('inc/css.php'); ?>
</head>

<body>

<div class="container-scroller">

    <!-- Navbar -->
    <?php include('inc/nev.php'); ?>

    <div class="container-fluid page-body-wrapper">

        <!-- Sidebar -->
        <?php include('inc/sidebar.php'); ?>

        <div class="main-panel">

            <div class="content-wrapper">

                <div class="page-header">
                    <h3 class="page-title">Product Details</h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                View Product
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="row">

                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">Product Information</h4>

                                <div class="row">

                                    <div class="col-md-4 text-center">

                                        <?php
                                        if (!empty($user['main_image']) && file_exists("../images/" . $user['main_image'])) {
                                        ?>
                                            <img src="../images/<?php echo $user['main_image']; ?>"
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

                                    <div class="col-md-8">

                                        <table class="table table-bordered">

                                            <tr>
                                                <th width="35%">Category ID</th>
                                                <td><?php echo $user['category_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Product Name</th>
                                                <td><?php echo $user['product_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Product Code</th>
                                                <td><?php echo $user['product_code']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td>₹<?php echo $user['price']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td><?php echo $user['discount']; ?>%</td>
                                            </tr>
                                            <tr>
                                                <th>Stock</th>
                                                <td><?php echo $user['stock']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Material</th>
                                                <td><?php echo $user['material']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Origin</th>
                                                <td><?php echo $user['origin']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <td><?php echo $user['description']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php
                                                    echo ($user['status'] == 'Active')
                                                        ? '<span class="badge badge-success">Active</span>'
                                                        : '<span class="badge badge-danger">Inactive</span>';
                                                    ?>
                                                </td>
                                            </tr>

                                        </table>

                                        <a href="pro_list.php" class="btn btn-secondary">
                                            Back
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php include('inc/footer.php'); ?>

        </div>

    </div>

</div>

<!-- JS -->
<?php include('inc/js.php'); ?>

</body>
</html>