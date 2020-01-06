<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'payment type' => 'master/payment-type',
        'create' => 'master/payment-type/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/payment-type/save') ?>" method="POST" id="form-payment-type">
    <?= _csrf() ?>

    <p class="form-section-title">Payment Information</p>
	<div class="form-group">
		<label for="payment_type">Payment Type</label>
		<input type="text" class="form-control" id="payment_type" name="payment_type" required maxlength="50"
			   value="<?= set_value('payment_type') ?>" placeholder="Payment title">
		<?= form_error('payment_type') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Payment type description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

	<table class="table table-sm mt-4">
		<thead>
		<tr>
			<th style="width: 60px">No</th>
			<th>Service</th>
			<th style="width: 250px">Payment Percent %</th>
			<th style="width: 250px">Margin Percent %</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($services as $index => $service): ?>
			<tr>
				<td><?= $index + 1 ?></td>
				<td><strong><?= $service['service'] ?></strong></td>
				<td>
					<div class="input-group">
						<input type="number" step="1" min="0" max="100" value="<?= set_value('services[' . $service['id'] . '][payment_percent]', 100) ?>"
							   class="form-control" placeholder="Payment percent"
							   name="services[<?= $service['id'] ?>][payment_percent]" aria-label="Payment percent" required>
						<div class="input-group-append">
							<span class="input-group-text">%</span>
						</div>
					</div>
				</td>
				<td>
					<div class="input-group">
						<input type="number" step="any" min="0" max="100" value="<?= set_value('services[' . $service['id'] . '][margin_percent]') ?>" class="form-control" placeholder="Margin percent"
							   name="services[<?= $service['id'] ?>][margin_percent]" aria-label="Margin percent" required>
						<div class="input-group-append">
							<span class="input-group-text">%</span>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if(empty($services)): ?>
			<tr>
				<td colspan="4">No service data available</td>
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
			Save Payment<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
