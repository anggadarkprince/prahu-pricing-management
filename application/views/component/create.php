<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component' => 'master/component',
        'create' => 'master/component/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/component/save') ?>" method="POST" id="form-component">
    <?= _csrf() ?>

    <p class="form-section-title">Component Information</p>
    <div class="form-group">
        <label for="component">Component</label>
        <input type="text" class="form-control" id="component" name="component" required maxlength="50" value="<?= set_value('component') ?>" placeholder="Main component">
        <?= form_error('component') ?>
    </div>
    <div class="form-group">
        <label for="sub_components">Sub Component</label>
        <div id="sub-component-wrapper">
            <?php if (empty($subComponents)) : ?>
                <span class="form-text">No sub component data</span>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($subComponents as $subComponent) : ?>
                        <div class="col-sm-2 col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" <?= set_checkbox('sub_components[' . $subComponent['id'] . ']', $subComponent['id']) ?> id="sub_component_<?= $subComponent['id'] ?>" name="sub_components[<?= $subComponent['id'] ?>]" value="<?= $subComponent['id'] ?>">
                                <label class="custom-control-label" for="sub_component_<?= $subComponent['id'] ?>">
                                    <?= $subComponent['sub_component'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <?= form_error('sub_components') ?>
    </div>
    <div class="form-group">
        <label for="provider">Related Partner</label>
        <select class="form-control select2" name="provider" id="provider" data-placeholder="Select partner" required>
            <option value=""></option>
            <option value="TRUCKING" <?= set_select('provider', 'TRUCKING') ?>>
                TRUCKING
            </option>
            <option value="SHIPPING LINE" <?= set_select('provider', 'SHIPPING LINE') ?>>
                SHIPPING LINE
            </option>
        </select>
        <?= form_error('provider') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Component description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-success" data-toggle="one-touch">
            Save Component<i class="mdi mdi-content-save-outline ml-2"></i>
        </button>
    </div>
</form>