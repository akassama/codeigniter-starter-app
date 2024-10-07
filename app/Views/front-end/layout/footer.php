<footer class="py-3 mt-auto">
    <div class="text-center p-3">
        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>
        <p>
            <?= CodeIgniter\CodeIgniter::CI_VERSION ?>
        </p>
    </div>
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="<?= base_url('/'); ?>" class="nav-link px-2 text-body-secondary">Home</a></li>
        <li class="nav-item"><a href="<?= base_url('/about'); ?>" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">&copy; <?= date('Y') ?> CI Starter App</p>
</footer>