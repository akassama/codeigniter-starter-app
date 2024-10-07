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
        <h3>New Configuration</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/admin/configurations/new-config'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="config_for" class="form-label">Config For</label>
                <input type="text" class="form-control" id="config_for" name="config_for" value="<?= set_value('config_for') ?>" required
                       hx-post="<?=base_url()?>/htmx/check-config-exists"
                       hx-trigger="keyup changed delay:250ms"
                       hx-target="#existing-config-error"
                       hx-swap="innerHTML">
                <!-- Error -->
                <?php if($validation->getError('config_for')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('config_for'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide config_for
                </div>
                <div id="existing-config-error">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="config_value" class="form-label">Config Value</label>
                <input type="text" class="form-control" id="config_value" name="config_value" value="<?= set_value('config_value') ?>" required>
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
            <div class="mb-3">
                <a href="<?= base_url('/account/admin/configurations') ?>" class="btn btn-outline-danger">
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
