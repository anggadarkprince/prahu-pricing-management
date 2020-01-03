<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => [
        'container size' => 'master/container-size',
        'create' => 'master/container-size/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/container-size/save') ?>" method="POST" id="form-container-size">
    <?= _csrf() ?>

    <p class="form-section-title">Container Information</p>
    <div class="form-group">
        <label for="container_size">Cargo Size</label>
        <input type="number" class="form-control" id="container_size" name="container_size" step="1" required maxlength="2"
               value="<?= set_value('container_size') ?>" placeholder="Container size or dimension">
        <?= form_error('container_size') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Size description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Size<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
