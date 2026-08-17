<?php 
require_once '../includes/config.php';
$result = array(
    "success" => true,
    "server_t" => "Alok Time: ".date("Y-m-d H:i:s")
);
echo json_encode($result);
    exit;
    ?>