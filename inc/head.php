<?php
$settings=mysqli_query($conn,"SELECT * FROM settings WHERE id=1");

$setData=mysqli_fetch_assoc($settings)
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $setData['website_name']  ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="shortcut icon" href="<?php echo SITE_URL?>images/setting/<?= $setData['favicon'];  ?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>assets/css/style.css">
</head>