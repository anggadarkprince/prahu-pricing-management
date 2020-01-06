<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['payment type' => 'master/payment-type']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Payment Type</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">payment schemas</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_CREATE)): ?>
            <a href="<?= site_url('master/payment-type/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-payment-type">
    <thead class="thead-dark">
    <tr>
        <th class="text-md-center" style="width: 60px">No</th>
        <th>Payment Type</th>
        <th>Description</th>
        <th>Last Updated</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($paymentTypes) ? ($paymentTypes['current_page'] - 1) * $paymentTypes['per_page'] : 0 ?>
    <?php foreach ($paymentTypes['data'] as $paymentType): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td><?= $paymentType['payment_type'] ?></td>
            <td><?= if_empty($paymentType['description'], 'No description') ?></td>
			<td><?= format_date(if_empty($paymentType['updated_at'], $paymentType['created_at']), 'd F Y H:i') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/payment-type/view/' . $paymentType['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/payment-type/edit/' . $paymentType['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $paymentType['id'] ?>" data-label="<?= $paymentType['payment_type'] ?>" data-title="Payment type"
                               data-url="<?= site_url('master/payment-type/delete/' . $paymentType['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($paymentTypes['data'])): ?>
        <tr>
            <td colspan="4" class="text-center">No location available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $paymentTypes]) ?>

<?php $this->load->view('payment_type/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
