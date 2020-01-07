<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['package' => 'master/package']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Package</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">vendor services</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_CREATE)): ?>
            <a href="<?= site_url('master/package/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-component">
    <thead class="thead-dark">
    <tr>
        <th class="text-md-center" style="width: 60px">No</th>
        <th>Component</th>
        <th>Package</th>
        <th>Sub Component</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($packages) ? ($packages['current_page'] - 1) * $packages['per_page'] : 0 ?>
    <?php foreach ($packages['data'] as $package): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td><?= $package['component'] ?></td>
            <td class="font-weight-bold"><?= $package['package'] ?></td>
            <td><?= $package['total_sub_component'] ?></td>
            <td><?= if_empty($package['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/package/view/' . $package['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/package/edit/' . $package['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $package['id'] ?>" data-label="<?= $package['package'] ?>" data-title="Sub Component"
                               data-url="<?= site_url('master/package/delete/' . $package['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($packages['data'])): ?>
        <tr>
            <td colspan="6" class="text-center">No package available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $packages]) ?>

<?php $this->load->view('package/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
