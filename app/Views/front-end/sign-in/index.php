<!-- include layout -->
<?= $this->extend('front-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h2 class="text-center">Sign-In</h2>
<div class="row justify-content-center">
    <div class="col-md-4 col-sm-12 bg-light rounded p-4">

        <?php $validation = \Config\Services::validation(); ?>

        <form action="<?= base_url('sign-in') ?>" method="post" class="row g-3 needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= set_value('email') ?>" required>
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
            <div class="mb-3" x-data="{ showPassword: false }">
                <label for="password" class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input x-bind:type="showPassword ? 'text' : 'password'" class="form-control" id="password" name="password" placeholder="enter password" required>
                    <span class="input-group-text" id="addon-wrapping" x-on:click="showPassword = !showPassword">
                        <i x-bind:class="{'bi bi-eye text-dark': !showPassword, 'bi bi-eye-slash-fill text-dark': showPassword}" id="eye-icon"></i>
                    </span>
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
                <div class="text-start mt-1">
                    <a href="<?= base_url('forgot-password') ?>" class="text-decoration-none text-dark">Forgot your password?</a>
                </div>
            </div>
            <?php if (!empty($captcha_image)) { ?>
                <div class="mb-3">
                    <label for="captcha" class="form-label">Captcha</label>
                    <img src="<?= $captcha_image ?>" alt="CAPTCHA" class="mb-2">
                    <input type="text" class="form-control" id="captcha" name="captcha" required>
                    <input type="hidden" name="captcha_session" value="<?= session('captcha') ?>">
                    <?php if ($validation->getError('captcha')) { ?>
                        <div class='alert alert-danger mt-2'>
                            <?= $error = $validation->getError('captcha'); ?>
                        </div>
                    <?php } ?>
                    <div class="invalid-feedback">
                        Please enter the captcha
                    </div>
                </div>
            <?php } ?>
            <div class="mb-3">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn">Login</button>
                </div>
            </div>
            <div class="my-2">
                <p>
                    Don't have an account? Register <a href="<?= base_url('/sign-up'); ?>">here</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
    //TODO: REMOVE AUTO LOGIN
    $(document).ready(function() {
        setTimeout(
            function()
            {
                $("#email").val("admin@example.com");
                $("#password").val("Admin@1");
                //$("#submit-btn").click();
            }, 1000);

    });
</script>

<!-- end main content -->
<?= $this->endSection() ?>
