<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Settings', 'url' => '/account/settings'),
    array('title' => 'Account Details')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Update Account Details</h3>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
