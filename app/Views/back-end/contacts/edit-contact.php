<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Contacts', 'url' => '/account/contacts'),
    array('title' => 'Edit Contact')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Edit Contact</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <?php $validation = \Config\Services::validation(); ?>
        <?php echo form_open(base_url('account/contacts/edit-contact'), 'method="post" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate'); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?= $contact_data['contact_name'] ?>" required>
                <!-- Error -->
                <?php if($validation->getError('contact_name')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an contact name
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_picture" class="form-label">Contact Picture</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_picture" name="contact_picture" value="<?= $contact_data['contact_picture'] ?>" required>
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
                    Please provide a contact picture
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_document" class="form-label">Contact Document</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_document" name="contact_document" value="<?= $contact_data['contact_document'] ?>">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#imageFilesModal">
                        <i class="bi bi-images"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_document')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_document'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide a contact_document
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_audio" class="form-label">Contact Audio</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_audio" name="contact_audio" value="<?= $contact_data['contact_audio'] ?>">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#imageFilesModal">
                        <i class="bi bi-images"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_audio')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_audio'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide a contact_audio
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_video" class="form-label">Contact Video</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="contact_video" name="contact_video" value="<?= $contact_data['contact_video'] ?>">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#imageFilesModal">
                        <i class="bi bi-images"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('contact_video')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_video'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide a contact_video
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="other_document" class="form-label">Other Document</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="other_document" name="other_document" value="<?= $contact_data['other_document'] ?>">
                    <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#imageFilesModal">
                        <i class="bi bi-images"></i>
                    </button>
                </div>
                <!-- Error -->
                <?php if($validation->getError('other_document')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('other_document'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide a other_document
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= $contact_data['contact_email'] ?>" required>
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
                <input type="text" class="form-control" id="contact_number" name="contact_number" minlength="6" value="<?= $contact_data['contact_number'] ?>" required
                       hx-post="<?=base_url()?>/htmx/check-edit-contact-number-exists"
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
                <textarea rows="1" class="form-control" id="contact_address" name="contact_address" required><?= $contact_data['contact_address'] ?></textarea>
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

            <!--hidden inputs -->
            <div class="col-12">
                <input type="hidden" class="form-control" id="contact_id" name="contact_id" value="<?= $contact_data['contact_id']; ?>" />
            </div>

            <div class="mb-3">
                <a href="<?= base_url('/account/contacts') ?>" class="btn btn-outline-danger">
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

<!-- Include the files modal -->
<?=  $this->include('back-end/layout/modals/files_modal.php'); ?>

<!-- end main content -->
<?= $this->endSection() ?>
