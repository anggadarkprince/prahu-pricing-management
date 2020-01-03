<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'vendor' => 'master/vendor',
        'create' => 'master/vendor/edit/' . $vendor['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/vendor/update/' . $vendor['id']) ?>" method="POST" id="form-vendor" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Vendor Information</p>
    <div class="form-group">
        <label for="vendor">Vendor</label>
        <input type="text" class="form-control" id="vendor" name="vendor" required maxlength="50" value="<?= set_value('vendor', $vendor['vendor']) ?>" placeholder="Vendor data">
        <?= form_error('vendor') ?>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="custom-select" name="type" id="type" required>
            <option value="TRUCKING" <?= set_select('type', 'TRUCKING', 'TRUCKING' == $vendor['type']) ?>>
                TRUCKING
            </option>
            <option value="SHIPPING LINE" <?= set_select('type', 'SHIPPING LINE', 'SHIPPING LINE' == $vendor['type']) ?>>
                SHIPPING LINE
            </option>
        </select>
        <?= form_error('type') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Size description"><?= set_value('description', $vendor['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
            Update Vendor<i class="mdi mdi-square-edit-outline ml-2"></i>
        </button>
    </div>
</form>