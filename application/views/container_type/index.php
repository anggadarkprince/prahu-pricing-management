<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => ['container-type' => 'master/container-type']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Container Type</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">cargo type</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_TYPE_CREATE)): ?>
            <a href="<?= site_url('master/container-type/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-container-type">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Container Type</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($containerTypes) ? ($containerTypes['current_page'] - 1) * $containerTypes['per_page'] : 0 ?>
    <?php foreach ($containerTypes['data'] as $containerType): ?>
        <tr>
            <td class="responsive-hide text-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $containerType['container_type'] ?></td>
            <td><?= if_empty($containerType['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_TYPE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/container-type/view/' . $containerType['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_TYPE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/container-type/edit/' . $containerType['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_TYPE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $containerType['id'] ?>" data-label="<?= $containerType['container_type'] ?>" data-title="Container type"
                               data-url="<?= site_url('master/container-type/delete/' . $containerType['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($containerTypes['data'])): ?>
        <tr>
            <td colspan="4" class="text-center">No container type available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('components/_pagination', ['pagination' => $containerTypes]) ?>

<?php $this->load->view('container_type/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_TYPE_DELETE)): ?>
    <?php $this->load->view('components/modals/_delete') ?>
<?php endif; ?>
