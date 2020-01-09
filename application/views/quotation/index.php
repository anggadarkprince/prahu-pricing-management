<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['quotation' => 'pricing/quotation']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Quotations</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">pricing history</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_QUOTATION_CREATE)): ?>
            <a href="<?= site_url('pricing/calculator') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Generate
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-quotation">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Customer</th>
        <th>Marketing</th>
        <th>Service</th>
        <th>Price</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($quotations) ? ($quotations['current_page'] - 1) * $quotations['per_page'] : 0 ?>
    <?php foreach ($quotations['data'] as $quotation): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $quotation['customer'] ?></td>
            <td><?= $quotation['marketing'] ?></td>
            <td><?= $quotation['service'] ?></td>
            <td>Rp. <?= numerical($quotation['total_price_after_tax']) ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_QUOTATION_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/quotation/view/' . $quotation['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                            <a class="dropdown-item" href="<?= site_url('master/quotation/print-quotation/' . $quotation['id']) ?>">
                                <i class="mdi mdi-cloud-print-outline mr-2"></i> Print
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_QUOTATION_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $quotation['id'] ?>" data-label="<?= $quotation['customer'] ?>" data-title="Quotation"
                               data-url="<?= site_url('master/quotation/delete/' . $quotation['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($quotations['data'])): ?>
        <tr>
            <td colspan="6" class="text-center">No quotation available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $quotations]) ?>

<?php $this->load->view('quotation/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_QUOTATION_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
