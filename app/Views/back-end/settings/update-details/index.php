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
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/settings/update-details/update-user'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user_data['first_name'] ?>" required>
                <!-- Error -->
                <?php if($validation->getError('first_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('first_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an first name
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user_data['last_name'] ?>" required>
                <!-- Error -->
                <?php if($validation->getError('last_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('last_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an first name
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="email" class="form-label">
                    Email
                    <small>(read-only)</small>
                </label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user_data['email'] ?>" required readonly>
                <!-- Error -->
                <?php if($validation->getError('email')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('email'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide email
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="username" class="form-label">
                    Username
                    <small>(read-only)</small>
                </label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user_data['username'] ?>" required readonly>
                <!-- Error -->
                <?php if($validation->getError('username')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('username'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide username
                </div>
            </div>

            <!--hidden inputs -->
            <div class="col-12">
                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $user_data['user_id']; ?>">
            </div>

            <div class="mb-3">
                <a href="<?= base_url('/account/settings') ?>" class="btn btn-outline-danger">
                    <i class="bi bi-caret-left-fill"></i>
                    Back
                </a>
                <button type="submit" class="btn btn-outline-primary float-end" id="submit-btn">
                    <i class="bi bi-pencil-square"></i>
                    Update
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
