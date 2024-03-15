<!-- include layout -->
<?= $this->extend('front-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h2 class="text-center">Sign-In</h2>
<div class="row justify-content-center">
    <div class="col-md-4 col-sm-12 bg-light rounded p-4">

        <div class="row">
            <span class="validation_errors text-danger">
                <?= validation_list_errors() ?>
            </span>
        </div>
        <?php $validation = \Config\Services::validation(); ?>

        <form action="<?= base_url('sign-in') ?>" method="post" class="row g-3 needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= set_value('email') ?>"  required>
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
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="my-2">
                <p>
                    Don't have an account? Register <a href="<?= base_url('/sign-up'); ?>">here</a>
                </p>
            </div>
        </form>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
