<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= base_url('/account'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Contacts</li>
</ol>
<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Manage Contacts</h3>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
