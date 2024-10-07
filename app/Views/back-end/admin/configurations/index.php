<?php
$session = session();
// Get session data
$sessionName = $session->get('first_name').' '.$session->get('last_name');
$sessionEmail = $session->get('email');
$userRole = getUserRole($sessionEmail);
?>

<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Admin', 'url' => '/account/admin'),
    array('title' => 'Configurations')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Manage Configurations</h3>
    </div>
    <div class="col-12 d-flex justify-content-end mb-2">
        <a href="<?=base_url('/account/admin/configurations/new-config')?>" class="btn btn-outline-dark mx-1">
            <i class="bi bi-plus"></i> New Configuration
        </a>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-table me-1"></i>
                Configurations
                <span class="badge rounded-pill bg-dark">
                    <?= $totalConfigurations ?>
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ConfigFor</th>
                            <th>Value</th>
                            <th>Last Modified</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rowCount = 1; ?>
                        <?php if($configurations): ?>
                            <?php foreach($configurations as $config): ?>
                                <tr>
                                    <td><?= $rowCount; ?></td>
                                    <td><?= $config['config_for']; ?></td>
                                    <td><?= $config['config_value']; ?></td>
                                    <td><?= $config['updated_at']; ?></td>
                                    <td>
                                        <div class="row text-center p-1">
                                            <div class="col mb-1">
                                                <a class="text-dark mr-1 mb-1 edit-config" href="<?=base_url('account/admin/configurations/edit-config/'.$config['config_id'])?>">
                                                    <i class="h5 bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                            <?php
                                            if ($config['deletable'] == 1) {
                                                echo '<div class="col mb-1">
                                                            <a class="text-dark mr-1 remove-config" href="javascript:void(0)" onclick="deleteRecord(\'configurations\', \'config_id\', \'' . $config['config_id'] . '\', \'\', \'account/admin/configurations\')">
                                                                <i class="h5 bi bi-x-circle-fill"></i>
                                                            </a>
                                                        </div>';
                                            } else {
                                            echo '<div class="col mb-1">
                                                        <a class="text-dark mr-1 remove-config disabled text-muted" href="javascript:void(0)">
                                                            <i class="h5 bi bi-x-circle-fill"></i>
                                                        </a>
                                                    </div>';
                                            }
                                            ?>
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
<?=  $this->include('back-end/layout/assets/delete_prompt_script.php'); ?>

<!-- end main content -->
<?= $this->endSection() ?>
