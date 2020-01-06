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
		<div>
			<?php foreach ($components as $component): ?>
				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" <?= set_checkbox('components[' . $component['id'] . ']', $component['id']) ?> id="component_<?= $component['id'] ?>" name="components[<?= $component['id'] ?>]" value="<?= $component['id'] ?>">
					<label class="custom-control-label" for="component_<?= $component['id'] ?>">
						<?= $component['component'] ?>
					</label>
				</div>
			<?php endforeach; ?>
		</div>
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
