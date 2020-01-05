<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'vendor' => 'master/vendor',
        'view' => 'master/vendor/view/' . $vendor['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Partner data</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="vendor">Vendor</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="vendor">
                <?= if_empty($vendor['vendor'], 'No vendor') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="type">Type</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="type">
                <?= if_empty($vendor['type'], 'No type') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="term_payment">Term of Payment</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="term_payment">
                <?= if_empty($vendor['term_payment'], '0') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($vendor['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($vendor['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($vendor['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <?php if (AuthorizationModel::isAuthorized(PERMISSION_VENDOR_EDIT)) : ?>
            <a href="<?= site_url('master/vendor/edit/' . $vendor['id']) ?>" type="submit" class="btn btn-primary">
                Edit Vendor<i class="mdi mdi-square-edit-outline ml-2"></i>
            </a>
        <?php endif; ?>
    </div>
</form>