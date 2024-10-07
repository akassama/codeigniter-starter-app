<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Admin', 'url' => '/account/admin'),
    array('title' => 'Activity Logs')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Activity Logs</h3>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-table me-1"></i>
                Activities
                <span class="badge rounded-pill bg-dark">
                    <?= $totalActivities ?>
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity By</th>
                            <th>Activity Type</th>
                            <th>Activity</th>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Date/Time</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rowCount = 1; ?>
                        <?php if($activity_logs): ?>
                            <?php foreach($activity_logs as $activity): ?>
                                <tr>
                                    <td><?= $rowCount; ?></td>
                                    <td>
                                        <span class="text-primary">
                                            <?= getActivityBy(esc($activity['activity_by'])) ?>
                                        </span>
                                        (<?= esc($activity['activity_by']) ?>)
                                    </td>
                                    <td><?= esc($activity['activity_type']) ?></td>
                                    <td><?= esc($activity['activity']) ?></td>
                                    <td><?= esc($activity['ip_address']) ?></td>
                                    <td><?= esc($activity['device']) ?></td>
                                    <td><?= esc($activity['created_at']) ?></td>
                                    <td>
                                        <div class="row text-center p-1">
                                            <div class="col mb-1">
                                                <a class="text-dark mr-1 mb-1 view-activity" href="<?=base_url('account/admin/activity-logs/view-activity/'.esc($activity['activity_id']))?>">
                                                    <i class="h5 bi bi-eye-fill"></i>
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

<!-- end main content -->
<?= $this->endSection() ?>
