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
    <title>Banners List</title>

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

                    <h3>Banners List</h3>

                    <a href="add_ban.php" class="btn btn-primary">
                        Add Banner
                    </a>

                </div>

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="myDataTable" class="table table-bordered table-striped">

                                <thead class="table-dark">

                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Sub Title</th>
                                        <th>Button Text</th>
                                        <th>Button Link</th>
                                         <th>Image</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php
                                $sql = "SELECT * FROM  `banners` ORDER BY id DESC";
                                $result = mysqli_query($conn, $sql);
                                
                                while($row = mysqli_fetch_assoc($result)){ ?>

                                    <tr>

                                        <td><?= $row['id']; ?></td>

                                        <td><?= $row['title']; ?></td>
                                        <td><?= $row['subtitle']; ?></td>
                                        <td><?= $row['button_text']; ?></td>
                                        <td>
                                            <a href="<?= $row['button_link']; ?>"
                                            class="btn btn-link btn-fw"
                                            target="_blank">
                                                <?= $row['button_text']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <img src="<?php echo SITE_URL . 'banners/' . $row['image']; ?>"
                                                width="70"
                                                height="70"
                                                style="object-fit:cover;">
                                        </td>
                                          <td>
                                          <span class="badge <?= $row['status'] ? 'bg-success' : 'bg-danger'; ?>">
                                          <?= $row['status'] ? 'Active' : 'Inactive'; ?>
                                         </span>
                                         </td>
                                         
                                        <td><?= $row['created_at']; ?></td>

                                        <td>

                                            <a href="view_ban.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                                View
                                            </a>
                                               <a href="edit_ban.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="delete_ban.php?id=<?= $row['id']; ?>"
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