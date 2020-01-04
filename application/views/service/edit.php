<?php $this->load->view('partials/_breadcrumb', [
	'breadcrumbs' => [
		'service' => 'master/service',
		'create' => 'master/service/edit/' . $service['id']
	]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/service/update/' . $service['id']) ?>" method="POST" id="form-service" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Service Information</p>
	<div class="form-group">
		<label for="service">Component</label>
		<input type="text" class="form-control" id="service" name="service" required maxlength="50"
			   value="<?= set_value('service', $service['service']) ?>" placeholder="Main service">
		<?= form_error('service') ?>
	</div>
	<div class="form-group">
		<label for="components">Components</label>
		<select class="form-control select2" multiple name="components[]" id="components" required style="width: 100%">
			<?php foreach ($components as $component): ?>
				<option value="<?= $component['id'] ?>"<?= set_select('components[]', $component['id'], $component['is_selected']) ?>>
					<?= $component['component'] ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?= form_error('components') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Service description"><?= set_value('description', $service['description']) ?></textarea>
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
