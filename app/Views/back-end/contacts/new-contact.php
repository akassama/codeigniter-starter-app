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
                <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="" value="<?= set_value('contact_name') ?>" required>
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
                <input type="file" class="form-control" id="contact_picture" name="contact_picture">
                <!-- Error -->
                <?php if($validation->getError('contact_picture')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_picture'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an contact picture
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="" value="<?= set_value('contact_email') ?>" required>
                <!-- Error -->
                <?php if($validation->getError('contact_email')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_email'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an contact email
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="" value="<?= set_value('contact_number') ?>" required
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
                    Please provide a contact number
                </div>
                <div id="existing-contact-number-error">
                </div>
            </div>
            <div class="col-sm-12 col-md-12 mb-3">
                <label for="contact_address" class="form-label">Contact Address</label>
                <textarea rows="1" class="form-control" id="contact_address" name="contact_address" placeholder="" value="<?= set_value('contact_address') ?>" required></textarea>
                <!-- Error -->
                <?php if($validation->getError('contact_address')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('contact_address'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an contact address
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
