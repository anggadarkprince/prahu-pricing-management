<footer class="sticky-footer mt-4 mt-md-5 py-4 small">
    <div class="container<?= $this->uri->segment(1) == 'auth' ? '-fluid' : '' ?> d-sm-flex justify-content-between">
        <p class="text-muted mb-1 mb-lg-0">
            Copyright &copy; <?= date('Y') ?> <strong><?= $this->config->item('app_author') ?></strong>
			all rights reserved.
        </p>

        <ul class="list-inline mb-0 d-none d-sm-block">
            <li class="list-inline-item">
                <a href="<?= site_url('/') ?>">Home</a>
            </li>
            <li class="list-inline-item">
                <a href="<?= site_url('page/help') ?>">Help</a>
            </li>
            <li class="list-inline-item">
                <a href="<?= site_url('page/terms') ?>">Terms and Conditions</a>
            </li>
        </ul>
    </div>
</footer>
