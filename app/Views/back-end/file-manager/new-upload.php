<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h1 class="mt-4">File Manager</h1>
<?php
    // Breadcrumbs
    $breadcrumb_links = array(
        array('title' => 'Dashboard', 'url' => '/account'),
        array('title' => 'File Manager', 'url' => '/account/file-manager'),
        array('title' => 'Upload File')
    );
    echo generateBreadcrumb($breadcrumb_links);
?>
<div class="row">
    <!--Content-->
    <div class="col-12">
        <?php $validation = \Config\Services::validation(); ?>
        <?= form_open_multipart('account/file-manager/upload', ['class' => 'needs-validation', 'novalidate' => '']) ?>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="upload_file" class="form-label">Choose File</label>
                <input type="file" class="form-control file-input" id="upload_file" name="upload_file" required>

                <!-- Error -->
                <?php if($validation->getError('upload_file')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('upload_file'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide file
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-upload"></i> Upload
            </button>
        <?= form_close() ?>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
