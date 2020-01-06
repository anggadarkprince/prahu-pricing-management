<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'consumable' => 'master/consumable',
        'view' => 'master/consumable/view/' . $consumable['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Additional services</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="consumable">Consumable</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="consumable">
                <?= if_empty($consumable['consumable'], 'No consumable title') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="type">Type</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="type">
                <?= if_empty($consumable['type'], 'No type') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($consumable['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($consumable['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($consumable['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

	<p class="form-section-title">Consumable prices</p>

	<table class="table table-sm mt-3 mb-4 table-hover responsive">
		<thead class="thead-dark">
		<tr>
			<th class="text-center" style="width: 60px">No</th>
			<th>Container Size</th>
			<?php if($consumable['type'] == ConsumableModel::TYPE_PACKAGING): ?>
				<th>Price</th>
			<?php else: ?>
				<th>Percent</th>
				<th>Component</th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($consumablePrices as $index => $consumablePrice) : ?>
			<tr>
				<td class="text-md-center"><?= $index + 1 ?></td>
				<td class="font-weight-bold">
					<a href="<?= site_url('master/container-size/view/' . $consumablePrice['id']) ?>">
						<?= $consumablePrice['container_size'] ?>
					</a>
				</td>
				<?php if($consumable['type'] == ConsumableModel::TYPE_PACKAGING): ?>
					<td>Rp. <?= numerical($consumablePrice['price']) ?></td>
				<?php else: ?>
					<td><?= numerical($consumablePrice['percent']) ?>%</td>
					<td><?= implode(', ', array_column($consumablePrice['components'], 'component')) ?></td>
				<?php endif; ?>
			</tr>
		<?php endforeach ?>
		<?php if (empty($consumablePrices)) : ?>
			<tr>
				<td colspan="4">
					No consumable price data available
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONSUMABLE_EDIT)): ?>
			<a href="<?= site_url('master/consumable/edit/' . $consumable['id']) ?>" class="btn btn-primary">
				Edit Consumable<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
