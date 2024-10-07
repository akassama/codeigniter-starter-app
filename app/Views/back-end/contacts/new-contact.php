<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Contacts', 'url' => '/account/contacts'),
    array('title' => 'New Contact')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>New Contact</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/contacts/new-contact'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?= set_value('contact_name') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('contact_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact name
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_picture" class="form-label">Contact Picture</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_picture" name="contact_picture" placeholder="select picture" required>
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#imageFilesModal">
                        <i class="bi bi-images"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_picture')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_picture'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact picture
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="doc_files" class="form-label">Contact Document</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_document" name="contact_document" placeholder="select file">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#documentFilesModal">
                        <i class="bi bi-file-earmark-text"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_document')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_document'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact_document
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_audio" class="form-label">Contact Audio</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_audio" name="contact_audio" placeholder="select file">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#audioFilesModal">
                        <i class="bi bi-music-note-list"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_audio')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_audio'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact_audio
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_video" class="form-label">Contact Video</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_video" name="contact_video" placeholder="select file">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#videoFilesModal">
                        <i class="bi bi-youtube"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_video')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_video'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact_video
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="other_document" class="form-label">Other Document</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="other_document" name="other_document" placeholder="select file">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#allFilesModal">
                        <i class="bi bi-folder2"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('other_document')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('other_document'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide other_document
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= set_value('contact_email') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('contact_email')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_email'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact email
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" minlength="6" value="<?= set_value('contact_number') ?>" required
                       hx-post="<?=base_url()?>/htmx/check-contact-number-exists"
                       hx-trigger="keyup changed delay:250ms"
                       hx-target="#existing-contact-number-error"
                       hx-swap="innerHTML">
                <!-- Error -->
                <?php if($validation->getError('contact_number')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_number'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact number
                </div>
                <div id="existing-contact-number-error">
                </div>
            </div>
            <div class="col-sm-12 col-md-12 mb-3">
                <label for="contact_address" class="form-label">Contact Address</label>
                <textarea rows="1" class="form-control" id="contact_address" name="contact_address" value="<?= set_value('contact_address') ?>" required></textarea>
                <!-- Error -->
                <?php if($validation->getError('contact_address')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_address'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide contact address
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

<!-- Include the files modal -->
<?=  $this->include('back-end/layout/modals/files_modal.php'); ?>

<!-- end main content -->
<?= $this->endSection() ?>
