<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'sub component' => 'master/sub-component',
        'create' => 'master/sub-component/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/sub-component/save') ?>" method="POST" id="form-sub-component">
    <?= _csrf() ?>

    <p class="form-section-title">Sub Component Information</p>
    <div class="form-group">
        <label for="sub_component">Sub Component</label>
        <input type="text" class="form-control" id="sub_component" name="sub_component" required maxlength="50" value="<?= set_value('sub_component') ?>" placeholder="Sub component">
        <?= form_error('sub_component') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Sub component description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-success" data-toggle="one-touch">
            Save Sub Component<i class="mdi mdi-content-save-outline ml-2"></i>
        </button>
    </div>
</form>