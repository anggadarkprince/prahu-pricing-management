<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['port' => 'master/port']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Ports</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">docking standard</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PORT_CREATE)): ?>
            <a href="<?= site_url('master/port/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-port">
    <thead class="thead-dark">
    <tr>
        <th class="text-md-center" style="width: 60px">No</th>
        <th>Port Code</th>
        <th>Port Name</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($ports) ? ($ports['current_page'] - 1) * $ports['per_page'] : 0 ?>
    <?php foreach ($ports['data'] as $port): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $port['code'] ?></td>
            <td><?= $port['port'] ?></td>
            <td><?= if_empty($port['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PORT_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/port/view/' . $port['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PORT_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/port/edit/' . $port['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PORT_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $port['id'] ?>" data-label="<?= $port['port'] ?>" data-title="Port"
                               data-url="<?= site_url('master/port/delete/' . $port['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($ports['data'])): ?>
        <tr>
            <td colspan="5" class="text-center">No port available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $ports]) ?>

<?php $this->load->view('port/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_PORT_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
