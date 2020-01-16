<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['location' => 'master/location']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Locations</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">area destination and pickup</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_CREATE)): ?>
            <a href="<?= site_url('master/location/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-location">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Location</th>
        <th>Port</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($locations) ? ($locations['current_page'] - 1) * $locations['per_page'] : 0 ?>
    <?php foreach ($locations['data'] as $location): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td><?= $location['location'] ?></td>
            <td><?= $location['port'] ?></td>
            <td><?= if_empty($location['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/location/view/' . $location['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/location/edit/' . $location['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $location['id'] ?>" data-label="<?= $location['location'] ?>" data-title="Location"
                               data-url="<?= site_url('master/location/delete/' . $location['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($locations['data'])): ?>
        <tr>
            <td colspan="5" class="text-center">No location available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $locations]) ?>

<?php $this->load->view('location/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
