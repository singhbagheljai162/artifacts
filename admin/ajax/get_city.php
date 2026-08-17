<?php
require_once "../../includes/config.php";

if(isset($_POST['state_id'])){

    $state_id = $_POST['state_id'];

    $sql = mysqli_query($conn,
        "SELECT * FROM cities
         WHERE state_id='$state_id'
         AND status='1'
         ORDER BY city_name");

    echo '<option value="">Select City</option>';

    while($row=mysqli_fetch_assoc($sql)){

        echo '<option value="'.$row['id'].'">'.$row['city_name'].'</option>';

    }

}
?>