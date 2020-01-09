<?php $this->load->view('partials/_breadcrumb', [
	'breadcrumbs' => [
		'container size' => 'master/container-size',
		'create' => 'master/container-size/edit/' . $containerSize['id']
	]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/container-size/update/' . $containerSize['id']) ?>" method="POST" id="form-container-size" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Container Information</p>
    <div class="form-group">
        <label for="container_size">Cargo Size</label>
		<input type="number" class="form-control" id="container_size" name="container_size" step="1" required maxlength="2"
               value="<?= set_value('container_type', $containerSize['container_size']) ?>" placeholder="Container size or dimension">
        <?= form_error('container_size') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Size description"><?= set_value('description', $containerSize['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
			Update Size<i class="mdi mdi-square-edit-outline ml-2"></i>
		</button>
    </div>
</form>
