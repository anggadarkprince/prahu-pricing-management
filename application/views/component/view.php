<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component' => 'master/component',
        'view' => 'master/component/view/' . $component['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Main component</p>

<form class="form-plaintext">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="component">Component</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="component">
                        <?= if_empty($component['component'], 'No component') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="description">Description</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="description">
                        <?= if_empty($component['description'], 'No description') ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="created_at">Created At</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="created_at">
                        <?= format_date($component['created_at'], 'd F Y H:i') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="updated_at">Updated At</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="updated_at">
                        <?= if_empty(format_date($component['updated_at'], 'd F Y H:i'), '-') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <p class="form-section-title">Package combination</p>

    <table class="table table-sm mt-3 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Sub Component</th>
                <?php foreach ($packages as $package) : ?>
                    <th class="text-md-center"><?= $package['package'] ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subComponents as $index => $subComponent) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <a href="<?= site_url('master/sub-component/view/' . $subComponent['id']) ?>">
                            <?= $subComponent['sub_component'] ?>
                        </a>
                    </td>
                    <?php foreach ($packages as $package) : ?>
                        <td class="text-md-center<?= in_array($subComponent['id'], array_column($package['sub_components'], 'id_sub_component')) ? ' table-success' : ' table-danger' ?>">
                            <?= in_array($subComponent['id'], array_column($package['sub_components'], 'id_sub_component')) ? 'YES' : 'NO' ?>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
            <?php if (empty($subComponents)) : ?>
                <tr>
                    <td colspan="<?= 2 + count($packages) ?>">
                        No combination data available
                    </td>
                </tr>
            <?php else : ?>
                <tr class="table-warning">
                    <td></td>
                    <td><strong>Total</strong></td>
                    <?php foreach ($packages as $package) : ?>
                        <td class="text-md-center">
                            <strong><?= count($package['sub_components']) ?></strong>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="form-section-title">Sub components</p>

    <table class="table table-sm mt-3 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Sub Component</th>
                <th style="width: 220px">Description</th>
                <th style="width: 180px">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subComponents as $index => $subComponent) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <a href="<?= site_url('master/sub-component/view/' . $subComponent['id']) ?>">
                            <?= $subComponent['sub_component'] ?>
                        </a>
                    </td>
                    <td><?= if_empty($subComponent['description'], 'No description') ?></td>
                    <td><?= format_date($subComponent['created_at'], 'd F Y H:i') ?></td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($subComponents)) : ?>
                <tr>
                    <td colspan="4">
                        No sub component data available
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="form-section-title">Package of component</p>

    <table class="table table-sm mt-3 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Package</th>
                <th style="width: 220px">Description</th>
                <th style="width: 180px">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($packages as $index => $package) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <a href="<?= site_url('master/package/view/' . $package['id']) ?>">
                            <?= $package['package'] ?>
                        </a>
                    </td>
                    <td><?= if_empty($package['description'], 'No description') ?></td>
                    <td><?= format_date($package['created_at'], 'd F Y H:i') ?></td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($packages)) : ?>
                <tr>
                    <td colspan="4">
                        No package data available
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="form-section-title">Service of component</p>

    <table class="table table-sm mt-3 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Service</th>
                <th style="width: 220px">Description</th>
                <th style="width: 180px">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($serviceComponents as $index => $serviceComponent) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <a href="<?= site_url('master/service/view/' . $serviceComponent['id_service']) ?>">
                            <?= $serviceComponent['service'] ?>
                        </a>
                    </td>
                    <td><?= if_empty($serviceComponent['description'], 'No description') ?></td>
                    <td><?= format_date($serviceComponent['created_at'], 'd F Y H:i') ?></td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($serviceComponents)) : ?>
                <tr>
                    <td colspan="4">
                        No service data available
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <?php if (AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_EDIT)) : ?>
            <a href="<?= site_url('master/component/edit/' . $component['id']) ?>" type="submit" class="btn btn-primary">
                Edit Component<i class="mdi mdi-square-edit-outline ml-2"></i>
            </a>
        <?php endif; ?>
    </div>
</form>