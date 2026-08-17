<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>

    <?php include('inc/css.php'); ?>

    <!-- DataTables CSS -->
    
</head>

<body>

<div class="container-scroller">

    <?php include('inc/nev.php'); ?>

    <div class="container-fluid page-body-wrapper">

        <?php include('inc/sidebar.php'); ?>

        <div class="main-panel">

            <div class="content-wrapper">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h3>Products List</h3>

                    <a href="add_pro.php" class="btn btn-primary">
                        Add Product
                    </a>

                </div>

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="myDataTable" class="table table-bordered table-striped">

                                <thead class="table-dark">

                                    <tr>
                                        <th>ID</th>
                                        <th>Order ID</th>
                                        <th>Product Code</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Stock</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php
                                $sql = "SELECT products.*,categories.category_name FROM `products` INNER JOIN `categories` WHERE products.category_id=categories.id ORDER BY id ASC";
                                $result = mysqli_query($conn, $sql);
                                
                                while($row = mysqli_fetch_assoc($result)){ ?>

                                    <tr>

                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['product_name']; ?></td>
                                        <td><?= $row['product_code']; ?></td>
                                        <td><?= $row['price']; ?></td>
                                        <td><?= $row['discount']; ?></td>
                                        <td><?= $row['stock']; ?></td>
                                        <td>
                                            <img src="<?php echo SITE_URL . 'images/' . $row['main_image']; ?>"
                                                width="70"
                                                height="70"
                                                style="object-fit:cover;">
                                        </td>
                                        <td>

                                            <?php if($row['status']==='Active'){ ?>

                                                <span class="badge bg-success">Active</span>

                                            <?php }else{ ?>

                                                <span class="badge bg-danger">Inactive</span>

                                            <?php } ?>

                                        </td>

                                        <td><?= $row['created_at']; ?></td>

                                        <td>

                                            <a href="view_pro.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                                View
                                            </a>
                                               <a href="edit_pro.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="delete_pro.php?id=<?= $row['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Delete this user?');">
                                                Delete
                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>

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