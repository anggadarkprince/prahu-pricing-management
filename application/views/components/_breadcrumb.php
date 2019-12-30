<nav aria-label="breadcrumb" class="d-none d-sm-block">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= site_url('dashboard') ?>">
                <span class="mdi mdi-arrow-left"></span> Dashboard
            </a>
        </li>
        <?php $count = 0; ?>
        <?php foreach ($breadcrumbs as $breadcrumb => $link): ?>
            <?php if ($count < count($breadcrumbs) - 1): ?>
                <li class="breadcrumb-item">
                    <a href="<?= site_url($link) ?>">
                        <?= $breadcrumb ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $breadcrumb ?>
                </li>
            <?php endif; ?>
            <?php $count++; ?>
        <?php endforeach; ?>
    </ol>
</nav>