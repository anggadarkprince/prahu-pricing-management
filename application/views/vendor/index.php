<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['vendor' => 'master/vendor']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Vendors</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">partner data</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_VENDOR_CREATE)): ?>
            <a href="<?= site_url('master/vendor/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-vendor">
    <thead class="thead-dark">
    <tr>
        <th class="text-md-center" style="width: 60px">No</th>
        <th>Partner</th>
        <th>Type</th>
        <th>Term Payment</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($vendors) ? ($vendors['current_page'] - 1) * $vendors['per_page'] : 0 ?>
    <?php foreach ($vendors['data'] as $vendor): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $vendor['vendor'] ?></td>
            <td><?= $vendor['type'] ?></td>
            <td><?= $vendor['term_payment'] ?>%</td>
            <td><?= if_empty($vendor['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_VENDOR_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/vendor/view/' . $vendor['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_VENDOR_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/vendor/edit/' . $vendor['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_VENDOR_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $vendor['id'] ?>" data-label="<?= $vendor['vendor'] ?>" data-title="Vendor"
                               data-url="<?= site_url('master/vendor/delete/' . $vendor['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($vendors['data'])): ?>
        <tr>
            <td colspan="6" class="text-center">No vendor available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $vendors]) ?>

<?php $this->load->view('vendor/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_VENDOR_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
