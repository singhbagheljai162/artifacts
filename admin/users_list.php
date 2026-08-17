<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>

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

                    <h3>Users List</h3>

                    <a href="add_user.php" class="btn btn-primary">
                        Add User
                    </a>

                </div>

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="myDataTable" class="table table-bordered table-striped">

                                <thead class="table-dark">

                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php while($row = mysqli_fetch_assoc($result)){ ?>

                                    <tr>

                                        <td><?= $row['id']; ?></td>

                                        <td><?= htmlspecialchars($row['full_name']); ?></td>

                                        <td><?= htmlspecialchars($row['email']); ?></td>

                                        <td><?= htmlspecialchars($row['phone']); ?></td>

                                        <td><?= htmlspecialchars($row['gender']); ?></td>

                                        <td><?= htmlspecialchars($row['role']); ?></td>

                                        <td>

                                            <?php if($row['status']==='Active'){ ?>

                                                <span class="badge bg-success">Active</span>

                                            <?php }else{ ?>

                                                <span class="badge bg-danger">Inactive</span>

                                            <?php } ?>

                                        </td>

                                        <td><?= $row['created_at']; ?></td>

                                        <td>
                                        <a href="view_user.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                         View
                                        </a>
                                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                         Edit
                                        </a>
                                         <a href="delete_user.php?id=<?= $row['id']; ?>"
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