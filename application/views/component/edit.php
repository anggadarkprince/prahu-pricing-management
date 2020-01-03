<?php $this->load->view('partials/_breadcrumb', [
	'breadcrumbs' => [
		'container size' => 'master/component',
		'create' => 'master/component/edit/' . $component['id']
	]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/component/update/' . $component['id']) ?>" method="POST" id="form-component" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Component Information</p>
	<div class="form-group">
		<label for="component">Component</label>
		<input type="text" class="form-control" id="component" name="component" required maxlength="50"
			   value="<?= set_value('component', $component['component']) ?>" placeholder="Main component">
		<?= form_error('component') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Size description"><?= set_value('description', $component['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
			Update Component<i class="mdi mdi-square-edit-outline ml-2"></i>
		</button>
    </div>
</form>
