<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'sub component' => 'master/sub-component',
        'create' => 'master/sub-component/edit/' . $subComponent['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/sub-component/update/' . $subComponent['id']) ?>" method="POST" id="form-component" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Sub Component Information</p>
    <div class="form-group">
        <label for="sub_component">Sub Component</label>
        <input type="text" class="form-control" id="sub_component" name="sub_component" required maxlength="50" value="<?= set_value('component', $subComponent['sub_component']) ?>" placeholder="Secondary component">
        <?= form_error('sub_component') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Size description"><?= set_value('description', $subComponent['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
            Update Sub Component<i class="mdi mdi-square-edit-outline ml-2"></i>
        </button>
    </div>
</form>