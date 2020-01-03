<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => [
        'container size' => 'master/container-type',
        'create' => 'master/container-type/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/container-type/save') ?>" method="POST" id="form-container-type">
    <?= _csrf() ?>

    <p class="form-section-title">Container Information</p>
    <div class="form-group">
        <label for="container_type">Cargo Type</label>
        <input type="text" class="form-control" id="container_type" name="container_type" required maxlength="50"
               value="<?= set_value('container_type') ?>" placeholder="Container type">
        <?= form_error('container_type') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Type description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Type<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
