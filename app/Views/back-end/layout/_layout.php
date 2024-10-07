<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CodeIgniter Starter App Backend</title>

    <!-- Include the header assets -->
    <?= $this->include('back-end/layout/assets/header_assets.php'); ?>
</head>
<body class="sb-nav-fixed">

<!-- Include the nav -->
<?=  $this->include('back-end/layout/back_end_nav.php'); ?>

<div id="layoutSidenav">

    <!-- Include left sidebar -->
    <?=  $this->include('back-end/layout/left_sidebar.php'); ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
        <!-- Include the footer -->
        <?=  $this->include('back-end/layout/footer.php'); ?>
    </div>
</div>
<!-- Include the footer_assets -->
<?=  $this->include('back-end/layout/assets/footer_assets.php'); ?>

<!-- Include sweet_alerts-->
<?=  $this->include('back-end/layout/assets/sweet_alerts.php'); ?>
</body>
</html>
