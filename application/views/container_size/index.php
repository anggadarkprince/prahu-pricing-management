<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['container-size' => 'master/container-size']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Container Sizes</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">cargo dimension</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_CREATE)): ?>
            <a href="<?= site_url('master/container-size/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-container-size">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Container Size</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($containerSizes) ? ($containerSizes['current_page'] - 1) * $containerSizes['per_page'] : 0 ?>
    <?php foreach ($containerSizes['data'] as $containerSize): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $containerSize['container_size'] ?>" feet</td>
            <td><?= if_empty($containerSize['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/container-size/view/' . $containerSize['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/container-size/edit/' . $containerSize['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $containerSize['id'] ?>" data-label="<?= $containerSize['container_size'] ?>" data-title="Container size"
                               data-url="<?= site_url('master/container-size/delete/' . $containerSize['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($containerSizes['data'])): ?>
        <tr>
            <td colspan="4" class="text-center">No container size available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $containerSizes]) ?>

<?php $this->load->view('container_size/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
