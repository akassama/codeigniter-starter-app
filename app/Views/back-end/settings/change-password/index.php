<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Settings', 'url' => '/account/settings'),
    array('title' => 'Change Password')
);
echo generateBreadcrumb($breadcrumb_links);
?>
<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Change Password</h3>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
