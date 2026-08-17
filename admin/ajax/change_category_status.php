<?php
require_once "../../includes/config.php";

if (isset($_POST['id'])) {

    $id = intval($_POST['id']);

    // Get current status
    $sql = "SELECT status FROM states WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if ($row['status'] == '1') {
            $newStatus = '0';
        } else {
            $newStatus = '1';
        }

        mysqli_query($conn, "UPDATE states SET status = '$newStatus' WHERE id = '$id'");

        echo $newStatus;
    }
}
?>