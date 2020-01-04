<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'service' => 'master/service',
        'create' => 'master/service/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/service/save') ?>" method="POST" id="form-service">
    <?= _csrf() ?>

    <p class="form-section-title">Service Information</p>
    <div class="form-group">
        <label for="service">Service</label>
        <input type="text" class="form-control" id="service" name="service" required maxlength="50"
               value="<?= set_value('service') ?>" placeholder="Service name">
        <?= form_error('service') ?>
    </div>
	<div class="form-group">
		<label for="components">Components</label>
		<select class="form-control select2" multiple name="components[]" id="components" required style="width: 100%">
			<?php foreach ($components as $component): ?>
				<option value="<?= $component['id'] ?>"<?= set_select('components[]', $component['id']) ?>>
					<?= $component['component'] ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?= form_error('components') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Service description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Service<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
