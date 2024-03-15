<!-- include layout -->
<?= $this->extend('front-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h2 class="text-center">Sign-Up</h2>
<div class="row justify-content-center">
    <div class="col-md-6 col-sm-12 bg-light rounded p-4">

        <div class="row">
            <span class="validation_errors text-danger">
                <?= validation_list_errors() ?>
            </span>
        </div>
        <?php $validation = \Config\Services::validation(); ?>

        <form action="<?= base_url('sign-up') ?>" method="post" class="row g-3 needs-validation" novalidate>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="first name" required>
                <!-- Error -->
                <?php if($validation->getError('first_name')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('first_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide first name
                </div>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="last name" required>
                <!-- Error -->
                <?php if($validation->getError('last_name')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('last_name'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide last name
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
                <!-- Error -->
                <?php if($validation->getError('username')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('username'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide your username
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <!-- Error -->
                <?php if($validation->getError('email')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('email'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide an email
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="enter password" required>
                <!-- Error -->
                <?php if($validation->getError('password')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('password'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide a password
                </div>
            </div>
            <div class="mb-3">
                <label for="repeat_password" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="re-enter password" required>
                <!-- Error -->
                <?php if($validation->getError('repeat_password')) {?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('repeat_password'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please re-type password
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="my-2">
                <p>
                    Already have an account? Login <a href="<?= base_url('/sign-in'); ?>">here</a>
                </p>
            </div>
        </form>
    </div>
</div>
<!-- end main content -->
<?= $this->endSection() ?>
