<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Create your beautiful dashboard here.</h3>
        <p>
            See: SB Admin (<a href="https://startbootstrap.com/template/sb-admin" target="_blank">https://startbootstrap.com/template/sb-admin</a>)
        </p>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
