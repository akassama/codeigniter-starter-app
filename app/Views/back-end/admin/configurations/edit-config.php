<?php
$session = session();
// Get session data
$sessionName = $session->get('first_name').' '.$session->get('last_name');
$sessionEmail = $session->get('email');
$userRole = getUserRole($sessionEmail);
?>

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
    array('title' => 'Edit Configuration')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Edit User</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/admin/configurations/edit-config'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="config_for" class="form-label">Config For <small>(read-only)</small> </label>
                <input type="text" class="form-control" id="config_for" name="config_for" value="<?= $config_data['config_for'] ?>" required readonly>
                <!-- Error -->
                <?php if($validation->getError('config_for')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('config_for'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide config_for
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="config_value" class="form-label">Config value</label>
                <input type="text" class="form-control" id="config_value" name="config_value" value="<?= $config_data['config_value'] ?>" required>
                <!-- Error -->
                <?php if($validation->getError('config_value')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('config_value'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide config_value
                </div>
            </div>

            <!--hidden inputs -->
            <div class="col-12">
                <input type="hidden" class="form-control" id="config_id" name="config_id" value="<?= $config_data['config_id']; ?>">
            </div>

            <div class="mb-3">
                <a href="<?= base_url('/account/admin/configurations') ?>" class="btn btn-outline-danger">
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
