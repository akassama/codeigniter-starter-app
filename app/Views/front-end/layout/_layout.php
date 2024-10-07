<?php

// Get root directory by removing the last directory from the path
$rootDirectory = dirname(dirname(__DIR__));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CodeIgniter Starter App</title>

    <!-- Include the header assets -->
    <?= $this->include('front-end/layout/assets/header_assets.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Include the home nav -->
<?=  $this->include('front-end/layout/home_nav.php'); ?>

<div class="container mt-2">
    <?= $this->renderSection('content') ?>
</div>

<!-- Include the footer -->
<?=  $this->include('front-end/layout/footer.php'); ?>

<!-- Include the footer_assets -->
<?=  $this->include('front-end/layout/assets/footer_assets.php'); ?>

<!-- Include sweet_alerts-->
<?=  $this->include('front-end/layout/assets/sweet_alerts.php'); ?>

</body>
</html>
