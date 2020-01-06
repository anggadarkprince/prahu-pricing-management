<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'payment type' => 'master/payment-type',
        'view' => 'master/payment-type/view/' . $paymentType['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Payment schemas</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="payment_type">Payment Type</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="payment_type">
                <?= if_empty($paymentType['payment_type'], 'No payment-type name') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($paymentType['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($paymentType['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($paymentType['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

	<p class="form-section-title">Service payment schemas</p>

	<table class="table table-sm mt-3 mb-4 table-hover responsive">
		<thead class="thead-dark">
		<tr>
			<th class="text-center" style="width: 60px">No</th>
			<th>Service</th>
			<th style="width: 200px">Payment Percent %</th>
			<th style="width: 200px">Margin Percent %</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($services as $index => $service) : ?>
			<tr>
				<td class="text-md-center"><?= $index + 1 ?></td>
				<td class="font-weight-bold">
					<a href="<?= site_url('master/service/view/' . $service['id']) ?>">
						<?= $service['service'] ?>
					</a>
				</td>
				<td><?= numerical($service['payment_percent']) ?>%</td>
				<td><?= numerical($service['margin_percent']) ?>%</td>
			</tr>
		<?php endforeach ?>
		<?php if (empty($services)) : ?>
			<tr>
				<td colspan="4">
					No service payment data available
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
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_PAYMENT_TYPE_EDIT)): ?>
			<a href="<?= site_url('master/payment-type/edit/' . $paymentType['id']) ?>" class="btn btn-primary">
				Edit Payment Type<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
