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
        <input type="text" class="form-control" id="component" name="component" required maxlength="50"
               value="<?= set_value('component') ?>" placeholder="Main component">
        <?= form_error('component') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Component description"><?= set_value('description') ?></textarea>
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
