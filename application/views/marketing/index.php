<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => ['marketing' => 'master/marketing']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Marketing</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">sales user list</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_CREATE)): ?>
            <a href="<?= site_url('master/marketing/create') ?>" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-box-multiple-outline mr-1"></i>Create
            </a>
        <?php endif; ?>
    </div>
</div>

<table class="table table-sm table-hover mt-3 responsive" id="table-marketing">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" style="width: 60px">No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Description</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($marketings) ? ($marketings['current_page'] - 1) * $marketings['per_page'] : 0 ?>
    <?php foreach ($marketings['data'] as $marketing): ?>
        <tr>
            <td class="responsive-hide text-center"><?= ++$no ?></td>
            <td class="font-weight-bold"><?= $marketing['name'] ?></td>
            <td><?= $marketing['email'] ?></td>
            <td><?= $marketing['contact'] ?></td>
            <td><?= if_empty($marketing['description'], 'No description') ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/marketing/view/' . $marketing['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/marketing/edit/' . $marketing['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $marketing['id'] ?>" data-label="<?= $marketing['name'] ?>" data-title="Marketing"
                               data-url="<?= site_url('master/marketing/delete/' . $marketing['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($marketings['data'])): ?>
        <tr>
            <td colspan="6" class="text-center">No marketing available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('components/_pagination', ['pagination' => $marketings]) ?>

<?php $this->load->view('marketing/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_DELETE)): ?>
    <?php $this->load->view('components/modals/_delete') ?>
<?php endif; ?>
