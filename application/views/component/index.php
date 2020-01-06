<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['component' => 'master/component']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Components</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">main checkpoint</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_CREATE)): ?>
            <a href="<?= site_url('master/component/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-component">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Component</th>
        <th>Sub Component</th>
        <th>Package</th>
        <th>Service</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($components) ? ($components['current_page'] - 1) * $components['per_page'] : 0 ?>
    <?php foreach ($components['data'] as $component): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $component['component'] ?></td>
            <td><?= numerical(if_empty($component['total_sub_component'], 0)) ?></td>
            <td><?= numerical(if_empty($component['total_package'], 0)) ?></td>
            <td><?= numerical(if_empty($component['total_service'], 0)) ?></td>
            <td><?= if_empty($component['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/component/view/' . $component['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/component/edit/' . $component['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $component['id'] ?>" data-label="<?= $component['component'] ?>" data-title="Component"
                               data-url="<?= site_url('master/component/delete/' . $component['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($components['data'])): ?>
        <tr>
            <td colspan="7" class="text-center">No component available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $components]) ?>

<?php $this->load->view('component/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
