<?php
$session = session();
// Get session data
$sessionName = $session->get('first_name').' '.$session->get('last_name');
$sessionEmail = $session->get('email');
$userRole = getUserRole($sessionEmail);
?>

<script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function() {
        // After 0.2 seconds, execute the following code
        setTimeout(function() {
            // Get the current URL
            const current_url = window.location.href;

            // Check if the URL contains "account/settings"
            if (current_url.includes("account/settings")) {
                // Click the button with id "settingsButton"
                document.getElementById("settingsButton").click();
            }
            // Check if the URL contains "account/admin"
            else if (current_url.includes("account/admin")) {
                // Click the button with id "adminButton"
                document.getElementById("adminButton").click();
            }
            // Else, do nothing
        }, 200); // 200 milliseconds = 0.2 seconds
    });
</script>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link <?= (str_contains(current_url(), 'account/dashboard')) ? 'active' : ''; ?>" href="<?= base_url('/account'); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer h5"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?= (str_contains(current_url(), 'account/contacts')) ? 'active' : ''; ?>" href="<?= base_url('/account/contacts'); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-list h5"></i></div>
                    Contacts
                </a>
                <a class="nav-link <?= (str_contains(current_url(), 'account/file-manager')) ? 'active' : ''; ?>" href="<?= base_url('/account/file-manager'); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-richtext h5"></i></div>
                    File Manager
                </a>
                <a class="nav-link collapsed <?= (str_contains(current_url(), 'account/settings')) ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings" id="settingsButton">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear h5"></i></div>
                    Settings
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                </a>
                <div class="collapse" id="collapseSettings" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= (str_contains(current_url(), 'account/settings/update-details')) ? 'active' : ''; ?>" href="<?= base_url('/account/settings/update-details'); ?>">
                            <i class="bi bi-dot"></i> Update Details
                        </a>
                        <a class="nav-link <?= (str_contains(current_url(), 'account/settings/change-password')) ? 'active' : ''; ?>" href="<?= base_url('/account/settings/change-password'); ?>">
                            <i class="bi bi-dot"></i> Change Password
                        </a>
                    </nav>
                </div>
                
                <?php if ($userRole == "Admin"): ?>
                    <!--Admin Views-->
                    <a class="nav-link collapsed <?= (str_contains(current_url(), 'account/admin')) ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin" id="adminButton">
                        <div class="sb-nav-link-icon"><i class="bi bi-person-gear h5"></i></div>
                        Admin
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                    </a>
                    <div class="collapse" id="collapseAdmin" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= (str_contains(current_url(), 'account/admin/users')) ? 'active' : ''; ?>" href="<?= base_url('/account/admin/users'); ?>">
                                <i class="bi bi-dot"></i> Users
                            </a>
                            <a class="nav-link <?= (str_contains(current_url(), 'account/admin/configurations')) ? 'active' : ''; ?>" href="<?= base_url('/account/admin/configurations'); ?>">
                                <i class="bi bi-dot"></i> Configurations
                            </a>
                            <a class="nav-link <?= (str_contains(current_url(), 'account/admin/activity-logs')) ? 'active' : ''; ?>" href="<?= base_url('/account/admin/activity-logs'); ?>">
                                <i class="bi bi-dot"></i> Activity Logs
                            </a>
                        </nav>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span class="small text-primary"><?= $sessionName ?> (<?=$userRole?>)</span>
        </div>
    </nav>
</div>