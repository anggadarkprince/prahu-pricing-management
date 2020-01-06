<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['consumable' => 'master/consumable']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Consumable</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">additional equipments</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_CREATE)): ?>
            <a href="<?= site_url('master/consumable/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-consumable">
    <thead class="thead-dark">
    <tr>
        <th class="text-md-center" style="width: 60px">No</th>
        <th>Consumable</th>
        <th>Type</th>
        <th>Description</th>
        <th>Last Updated</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($consumables) ? ($consumables['current_page'] - 1) * $consumables['per_page'] : 0 ?>
    <?php foreach ($consumables['data'] as $consumable): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td><?= $consumable['consumable'] ?></td>
            <td><?= $consumable['type'] ?></td>
            <td><?= if_empty($consumable['description'], 'No description') ?></td>
			<td><?= format_date(if_empty($consumable['updated_at'], $consumable['created_at']), 'd F Y H:i') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/consumable/view/' . $consumable['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/consumable/edit/' . $consumable['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $consumable['id'] ?>" data-label="<?= $consumable['consumable'] ?>" data-title="Consumable"
                               data-url="<?= site_url('master/consumable/delete/' . $consumable['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($consumables['data'])): ?>
        <tr>
            <td colspan="5" class="text-center">No consumable available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $consumables]) ?>

<?php $this->load->view('consumable/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
