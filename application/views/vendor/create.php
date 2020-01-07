<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'vendor' => 'master/vendor',
        'create' => 'master/vendor/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/vendor/save') ?>" method="POST" id="form-vendor">
    <?= _csrf() ?>

    <p class="form-section-title">Vendor Information</p>
    <div class="form-group">
        <label for="vendor">Vendor</label>
        <input type="text" class="form-control" id="vendor" name="vendor" required maxlength="50" value="<?= set_value('vendor') ?>" placeholder="Vendor name">
        <?= form_error('vendor') ?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control select2" name="type" id="type" data-placeholder="Select partner type" required>
                    <option value=""></option>
                    <option value="TRUCKING" <?= set_select('type', 'TRUCKING') ?>>
                        TRUCKING
                    </option>
                    <option value="SHIPPING LINE" <?= set_select('type', 'SHIPPING LINE') ?>>
                        SHIPPING LINE
                    </option>
                </select>
                <?= form_error('type') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="term_payment">Term of Payment (%)</label>
                <input type="number" min="0" max="100" class="form-control" id="term_payment" name="term_payment" required value="<?= set_value('term_payment') ?>" placeholder="Term of payment percent">
                <?= form_error('term_payment') ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Vendor description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-success" data-toggle="one-touch">
            Save Vendor<i class="mdi mdi-content-save-outline ml-2"></i>
        </button>
    </div>
</form>