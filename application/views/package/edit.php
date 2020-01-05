<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'package' => 'master/package',
        'create' => 'master/package/edit/' . $package['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/package/update/' . $package['id']) ?>" method="POST" id="form-package" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Package Information</p>
    <div class="form-group">
        <label for="component">Component</label>
        <select class="form-control select2" name="component" id="component" data-placeholder="Select component" required style="width: 100%">
            <option value=""></option>
            <?php foreach ($components as $component) : ?>
                <option value="<?= $component['id'] ?>" <?= set_select('component', $component['id'], $component['id'] == $package['id_component']) ?>>
                    <?= $component['component'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('component') ?>
    </div>
    <div class="form-group">
        <label for="package">Package Name</label>
        <input type="text" class="form-control" id="package" name="package" required maxlength="50" value="<?= set_value('package', $package['package']) ?>" placeholder="Package name">
        <?= form_error('package') ?>
    </div>
    <div class="form-group">
        <label for="sub_components">Sub Component</label>
        <div id="sub-component-wrapper">
            <?php if (empty($subComponents)) : ?>
                <span class="form-text">Select component data.</span>
            <?php else : ?>
                <?php foreach ($subComponents as $subComponent) : ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" <?= set_checkbox('sub_components[' . $subComponent['id'] . ']', $subComponent['id'], $subComponent['is_selected']) ?> id="sub_component_<?= $subComponent['id'] ?>" name="sub_components[<?= $subComponent['id'] ?>]" value="<?= $subComponent['id'] ?>">
                        <label class="custom-control-label" for="sub_component_<?= $subComponent['id'] ?>">
                            <?= $subComponent['sub_component'] ?>
                        </label>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <?= form_error('sub_components') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Package description"><?= set_value('description', $package['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
            Update Package<i class="mdi mdi-square-edit-outline ml-2"></i>
        </button>
    </div>
</form>