<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => ['component price' => 'master/component-price']
]) ?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-1 text-primary">Component Price</h4>
    <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">vendor price</span>
    <div>
        <a href="#modal-filter" data-toggle="modal" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-filter-variant"></i>
        </a>
        <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
            <i class="mdi mdi-file-download-outline"></i>
        </a>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_CREATE)): ?>
            <a href="<?= site_url('master/component-price/create') ?>" class="btn btn-sm btn-primary">
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
        <th>Vendor</th>
        <th>Port Origin</th>
        <th>Port Dest</th>
        <th>Location Origin</th>
        <th>Location Dest</th>
        <th>Container Size</th>
        <th>Container Type</th>
        <th>Sub Component</th>
        <th>Price</th>
        <th style="width: 80px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = isset($componentPrices) ? ($componentPrices['current_page'] - 1) * $componentPrices['per_page'] : 0 ?>
    <?php foreach ($componentPrices['data'] as $componentPrice): ?>
        <tr>
            <td class="text-md-center"><?= ++$no ?></td>
            <td><?= $componentPrice['component'] ?></td>
            <td><?= $componentPrice['vendor'] ?></td>
            <td><?= $componentPrice['port_origin'] ?></td>
            <td><?= if_empty($componentPrice['port_destination'], '-') ?></td>
            <td><?= $componentPrice['location_origin'] ?></td>
            <td><?= $componentPrice['location_destination'] ?></td>
            <td><?= $componentPrice['container_size'] ?></td>
            <td><?= $componentPrice['container_type'] ?></td>
            <td><?= $componentPrice['sub_component'] ?></td>
            <td>Rp. <?= numerical($componentPrice['price']) ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_VIEW)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/component-price/view/' . $componentPrice['id']) ?>">
                                <i class="mdi mdi-eye-outline mr-2"></i> View
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_EDIT)): ?>
                            <a class="dropdown-item" href="<?= site_url('master/component-price/edit/' . $componentPrice['id']) ?>">
                                <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_DELETE)): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                               data-id="<?= $componentPrice['id'] ?>" data-label="<?= numerical($componentPrice['price']) ?>" data-title="Component Price"
                               data-url="<?= site_url('master/component-price/delete/' . $componentPrice['id']) ?>">
                                <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($componentPrices['data'])): ?>
        <tr>
            <td colspan="12" class="text-center">No component price available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php $this->load->view('partials/_pagination', ['pagination' => $componentPrices]) ?>

<?php $this->load->view('component_price/_modal_filter') ?>
<?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_DELETE)): ?>
    <?php $this->load->view('partials/modals/_delete') ?>
<?php endif; ?>
