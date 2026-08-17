<?php
require_once "../includes/config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $stmt = mysqli_prepare($conn, "DELETE FROM  `countries` WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: country_list.php");
        exit();
    } else {
        echo "Delete Failed";
    }

    mysqli_stmt_close($stmt);

} else {
    echo "Invalid User ID";
}
?>