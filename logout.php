<<?php
include 'includes/config.php';


// Destroy session
session_destroy();

// Redirect to login page
header("Location: auth.php");
exit();
?>