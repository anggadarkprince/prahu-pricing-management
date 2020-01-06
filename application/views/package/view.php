<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'sub component' => 'master/package',
        'view' => 'master/package/view/' . $package['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Package component</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="component">Component</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="component">
                <?= if_empty($package['component'], 'No component') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="package">Package Name</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="package">
                <?= if_empty($package['package'], 'No package') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($package['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($package['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($package['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <p class="form-section-title">Package sub component</p>

    <table class="table table-sm mt-3 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Sub Component</th>
                <th style="width: 180px">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($packageSubComponents as $index => $packageSubComponent) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold"><?= $packageSubComponent['sub_component'] ?></td>
                    <td><?= format_date($packageSubComponent['created_at'], 'd F Y H:i') ?></td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($packageSubComponents)) : ?>
                <tr>
                    <td colspan="4">
                        No sub component data available
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
        <?php if (AuthorizationModel::isAuthorized(PERMISSION_PACKAGE_EDIT)) : ?>
            <a href="<?= site_url('master/package/edit/' . $package['id']) ?>" class="btn btn-primary">
                Edit Package<i class="mdi mdi-square-edit-outline ml-2"></i>
            </a>
        <?php endif; ?>
    </div>
</form>
