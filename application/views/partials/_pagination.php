<?php if(isset($pagination)): ?>
    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between mt-3">
        <small class="text-muted mb-2">Total result <?= $pagination['total_data'] ?> items</small>
        <?php if($pagination['total_data'] > 0): ?>
            <nav aria-label="Page navigation" class="mb-0">
                <ul class="pagination pagination-sm">
                    <li class="page-item<?= $pagination['current_page'] == 1 ? ' disabled' : '' ?>">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] - 1]) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php if($pagination['total_page'] <= 15): ?>
                        <?php for ($i = 1; $i <= $pagination['total_page']; $i++): ?>
                            <li class="page-item<?= $i == $pagination['current_page'] ? ' active' : '' ?>">
                                <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $i]) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <li class="page-item<?= $pagination['current_page'] >= $pagination['total_page'] ? ' disabled' : '' ?>">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] + 1]) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
<?php endif; ?>