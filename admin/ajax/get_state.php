<?php
require_once "../../includes/config.php";

if(isset($_POST['country_id'])){

    $country_id = $_POST['country_id'];

    $sql = mysqli_query($conn,
        "SELECT * FROM states
         WHERE country_id='$country_id'
         AND status='1'
         ORDER BY state_name");

    echo '<option value="">Select State</option>';

    while($row=mysqli_fetch_assoc($sql)){

        echo '<option value="'.$row['id'].'">'.$row['state_name'].'</option>';

    }

}
?>