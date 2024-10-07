<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Contacts', 'url' => '/account/contacts'),
    array('title' => 'View Contact')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>New Contact</h3>
    </div>
    <div class="col-12 bg-light rounded p-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 mb-3">
                <label for="contact_picture" class="form-label">Contact Picture</label>
                <br>
                <img src="<?= base_url($contact_data['contact_picture']); ?>" class="img-thumbnail" alt="<?= $contact_data['contact_name']; ?>" width="100" height="100">
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?= $contact_data['contact_name'] ?>" readonly>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= $contact_data['contact_email'] ?>" readonly>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= $contact_data['contact_number'] ?>" readonly>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_address" class="form-label">Contact Address</label>
                <textarea rows="1" class="form-control" id="contact_address" name="contact_address" readonly><?= $contact_data['contact_address'] ?></textarea>
            </div>
            <div class="mb-3">
                <a href="<?= base_url('/account/contacts') ?>" class="btn btn-outline-danger">
                    <i class="bi bi-caret-left-fill"></i>
                    Back
                </a>
            </div>
        </div>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
