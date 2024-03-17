<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>


<ol class="breadcrumb mb-4 mt-4">
    <li class="breadcrumb-item"><a href="<?= base_url('/account'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('/account/settings'); ?>">Settings</a></li>
    <li class="breadcrumb-item active">Account Details</li>
</ol>
<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Update Account Details</h3>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
