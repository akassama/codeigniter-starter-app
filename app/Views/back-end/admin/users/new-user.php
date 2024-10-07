<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Admin', 'url' => '/account/admin'),
    array('title' => 'Configurations', 'url' => '/account/admin/configurations'),
    array('title' => 'New Configuration')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>New User</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/admin/users/new-user'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= set_value('first_name') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('first_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('first_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide first name
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= set_value('last_name') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('last_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('last_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide last name
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" minlength="6" maxlength="20" value="<?= set_value('username') ?>" required
                       hx-post="<?=base_url()?>/htmx/check-contact-number-exists"
                       hx-trigger="keyup changed delay:250ms"
                       hx-target="#existing-username-error"
                       hx-swap="innerHTML">
                <!-- Error -->
                <?php if($validation->getError('username')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('username'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide username
                </div>
                <div id="existing-username-error">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" minlength="6" maxlength="20" value="<?= set_value('email') ?>" required
                       hx-post="<?=base_url()?>/htmx/check-contact-number-exists"
                       hx-trigger="keyup changed delay:250ms"
                       hx-target="#existing-user-email-error"
                       hx-swap="innerHTML">
                <!-- Error -->
                <?php if($validation->getError('email')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('email'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide email
                </div>
                <div id="existing-user-email-error">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= set_value('password') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('password')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('password'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide password
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="status" class="form-label">Status <small>(default : inactive)</small></label>
                <input type="text" class="form-control" id="status" name="status" value="0" required readonly>
                <!-- Error -->
                <?php if($validation->getError('status')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('status'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide status
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="role" class="form-label">Role <small>(default : user)</small></label>
                <input type="text" class="form-control" id="role" name="role" value="User" required readonly>
                <!-- Error -->
                <?php if($validation->getError('role')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('role'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide role
                </div>
            </div>
            <div class="mb-3">
                <a href="<?= base_url('/account/contacts') ?>" class="btn btn-outline-danger">
                    <i class="bi bi-caret-left-fill"></i>
                    Back
                </a>
                <button type="submit" class="btn btn-outline-primary float-end" id="submit-btn">
                    <i class="bi bi-send"></i>
                    Submit
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
