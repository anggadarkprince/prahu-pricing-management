<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'consumable' => 'master/consumable',
        'create' => 'master/consumable/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/consumable/save') ?>" method="POST" id="form-consumable">
    <?= _csrf() ?>

    <p class="form-section-title">Consumable Information</p>
	<div class="form-group">
		<label for="consumable">Consumable</label>
		<input type="text" class="form-control" id="consumable" name="consumable" required maxlength="100"
			   value="<?= set_value('consumable') ?>" placeholder="Consumable title">
		<?= form_error('consumable') ?>
	</div>
	<div class="form-group">
		<label for="type">Type</label>
		<select class="form-control select2" data-placeholder="Select consumable type" name="type" id="type" required>
			<option value=""></option>
			<option value="<?= ConsumableModel::TYPE_PACKAGING ?>"<?= set_select('type', ConsumableModel::TYPE_PACKAGING) ?>>
				<?= ConsumableModel::TYPE_PACKAGING ?>
			</option>
			<option value="<?= ConsumableModel::TYPE_ACTIVITY_DURATION ?>"<?= set_select('type', ConsumableModel::TYPE_ACTIVITY_DURATION) ?>>
				<?= ConsumableModel::TYPE_ACTIVITY_DURATION ?>
			</option>
		</select>
		<?= form_error('type') ?>
	</div>
	<div class="form-group">
		<label for="expired_date">Expired Date</label>
		<input type="text" class="form-control datepicker" id="expired_date" name="expired_date" autocomplete="off" required maxlength="50" value="<?= set_value('expired_date') ?>" placeholder="Price will expired">
		<?= form_error('expired_date') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Consumable description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

	<p class="form-section-title mt-4">Consumable Price</p>
	<table class="table table-sm">
		<thead>
		<tr>
			<th style="width: 60px">No</th>
			<th>Container Size</th>
			<th style="width: 220px" class="mode-value">Price</th>
			<th style="width: 200px" class="mode-percent">Percent %</th>
			<th style="width: 400px" class="mode-percent">From Component</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($containerSizes as $index => $containerSize): ?>
			<tr>
				<td><?= $index + 1 ?></td>
				<td><strong><?= $containerSize['container_size'] ?>"</strong></td>
				<td class="mode-value">
					<input type="text" maxlength="20" required value="<?= set_value('container_sizes[' . $containerSize['id'] . '][price]') ?>"
						   class="form-control currency" placeholder="Price <?= $containerSize['container_size'] ?>"
						   name="container_sizes[<?= $containerSize['id'] ?>][price]" aria-label="Price <?= $containerSize['container_size'] ?>">
				</td>
				<td class="mode-percent">
					<div class="input-group">
						<input type="number" step="1" min="0" max="100" value="<?= set_value('container_sizes[' . $containerSize['id'] . '][percent]') ?>"
							   class="form-control" placeholder="Price percent"
							   name="container_sizes[<?= $containerSize['id'] ?>][percent]" aria-label="Payment percent" required>
						<div class="input-group-append">
							<span class="input-group-text">%</span>
						</div>
					</div>
				</td>
				<td class="mode-percent">
					<select class="form-control select2" multiple name="container_sizes[<?= $containerSize['id'] ?>][components][]"
							id="component_<?= $containerSize['id'] ?>" aria-label="Component" required style="width: 100%">
						<?php foreach ($components as $component): ?>
							<option value="<?= $component['id'] ?>"<?= set_select('components[]', $component['id']) ?>>
								<?= $component['component'] ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if(empty($containerSizes)): ?>
			<tr>
				<td colspan="5">No container size data available</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Consumable<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
