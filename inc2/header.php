<?php require_once 'includes/config.php'; 

$settings=mysqli_query($conn,"SELECT * FROM settings WHERE id=1");

$setData=mysqli_fetch_assoc($settings)

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $setData['website_name']  ?></title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet" href="assets/css/responsive.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<link rel="shortcut icon" href="<?php echo SITE_URL?>images/setting/<?= $setData['favicon'];  ?>" />

</head>

<body>