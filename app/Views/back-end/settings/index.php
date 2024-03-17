<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h1 class="mt-4">Settings</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= base_url('/account'); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Settings</li>
</ol>
<div class="row">
    <!--Content-->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white mb-4">
            <div class="card-body border-bottom">
                <i class="bi bi-person-vcard"></i>
                Update Account Details
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('/account/settings/update-details'); ?>">View Details</a>
                <div class="small text-white"><i class="bi bi-arrow-right-circle h5"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white mb-4">
            <div class="card-body border-bottom">
                <i class="bi bi-shield-lock-fill"></i>
                Change Password
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('/account/settings/change-password'); ?>">View Details</a>
                <div class="small text-white"><i class="bi bi-arrow-right-circle h5"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
