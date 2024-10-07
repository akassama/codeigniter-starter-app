<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'File Manager')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Manage Files</h3>
    </div>
    <div class="col-12 d-flex justify-content-end mb-2">
        <a href="<?=base_url('/account/file-manager/upload')?>" class="btn btn-outline-dark mx-1">
        <i class="bi bi-cloud-arrow-up"></i> Upload
        </a>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-table me-1"></i>
                Files
                <span class="badge rounded-pill bg-dark">
                    <?= $totalFileUploads ?>
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>File</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rowCount = 1; ?>
                        <?php if($file_uploads): ?>
                            <?php foreach($file_uploads as $file): ?>
                                <tr>
                                    <td><?= $rowCount; ?></td>
                                    <td>
                                        <div class="input-group col-12 mb-3">
                                            <span class="input-group-text">
                                               <?= getFileInputIcon($file['file_type']) ?>
                                            </span>
                                            <input type="text" class="form-control" id="name-<?= esc($file['file_id']) ?>" value="<?= esc($file['file_name']) ?>" readonly diasbled />
                                            <span class="input-group-text">
                                                <button class="btn btn-outline-secondary copy-btn copy-btn-label" type="button" id="button-addon2" data-clipboard-target="#name-<?= esc($file['file_id']) ?>">
                                                    <i class="bi bi-clipboard-check"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td><?= esc($file['file_type']) ?></td>
                                    <td><?= displayFileSize($file['file_size']) ?> </td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($file['created_at'])) ?></td>
                                    <td>
                                        <div class="row text-center p-1">
                                            <div class="col mb-1">
                                                <a class="text-dark mr-1 mb-1 copy-btn copy-path-label" href="javascript:void(0)" data-clipboard-text="<?= $file['upload_path']; ?>">
                                                    <i class="h5 bi bi-copy" data-clipboard-text="Sample copy text"></i>
                                                </a>
                                            </div>
                                            <div class="col mb-1">
                                                <a class="text-dark mr-1 mb-1 download-btn" href="<?= base_url($file['upload_path']); ?>" download="<?= $file['file_name']; ?>">
                                                    <i class="h5 bi bi-download"></i>
                                                </a>
                                            </div>
                                            <div class="col mb-1">
                                                <a class="text-dark mr-1 remove-file" href="javascript:void(0)" onclick="deleteFile('file_uploads', 'file_id', '<?=$file['file_id'];?>', '', '<?=$file['upload_path'];?>', 'account/file-manager')">
                                                    <i class="h5 bi bi-x-circle-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $rowCount++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the delete script -->
<?=  $this->include('back-end/layout/assets/delete_file_prompt_script.php'); ?>

<!--tippy tooltips-->
<script>

</script>

<!-- end main content -->
<?= $this->endSection() ?>
