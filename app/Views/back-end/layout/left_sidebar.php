<?php
$session = session();
// Get session data
$sessionName = $session->get('first_name').' '.$session->get('last_name');
$sessionEmail = $session->get('email');
$userRole = getUserRole($sessionEmail);
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link" href="<?= base_url('/account'); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer h5"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="<?= base_url('/account/contacts'); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-list h5"></i></div>
                    Contacts
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear h5"></i></div>
                    Settings
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                </a>
                <div class="collapse" id="collapseSettings" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('/account/settings/update-details'); ?>">
                            <i class="bi bi-dot"></i> Update Details
                        </a>
                        <a class="nav-link" href="<?= base_url('/account/settings/change-password'); ?>">
                            <i class="bi bi-dot"></i> Change Password
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                    <div class="sb-nav-link-icon"><i class="bi bi-person-gear h5"></i></div>
                    Admin
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                </a>
                <div class="collapse" id="collapseAdmin" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('/account/admin/users'); ?>">
                            <i class="bi bi-dot"></i> Users
                        </a>
                        <a class="nav-link" href="<?= base_url('/account/admin/activity-logs'); ?>">
                            <i class="bi bi-dot"></i> Activity Logs
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span class="small text-primary"><?= $sessionName ?> (<?=$userRole?>)</span>
        </div>
    </nav>
</div>