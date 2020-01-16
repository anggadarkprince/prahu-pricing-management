<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component' => 'pricing/quotation',
        'view' => 'pricing/quotation/view/' . $quotation['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Customer quotation</p>

<form class="form-plaintext">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="customer">Customer</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="customer">
                        <?= if_empty($quotation['customer'], 'No customer') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="company">Company</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="company">
                        <?= if_empty($quotation['company'], 'No company') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="marketing">Marketing</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="marketing">
                        <?= if_empty($quotation['marketing'], 'No marketing') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="location_from">Location From</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="location_from">
                        <?= if_empty($quotation['location_from'], 'No location') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="address_from">Address From</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="address_from">
                        <?= if_empty($quotation['address_from'], 'No address') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="location_to">Location To</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="location_to">
                        <?= if_empty($quotation['location_to'], 'No location') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="address_to">Address To</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="address_to">
                        <?= if_empty($quotation['address_to'], 'No address') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="port_from">Port From</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="port_from">
                        <?= if_empty($quotation['port_from'], 'No port') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="port_to">Port To</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="port_to">
                        <?= if_empty($quotation['port_to'], 'No port') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="container_type">Container</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="container_type">
                        <?= $quotation['container_size'] ?>' <?= $quotation['container_type'] ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="loding_category">Category</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="loding_category">
                        <?= if_empty($quotation['loading_category'], 'No category') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row d-none">
                <label class="col-sm-3 col-lg-3 col-form-label" for="loading_date">Loading Date</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="loading_date">
                        <?= if_empty(format_date($quotation['loading_date'], 'd F Y'), '-') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="description">Description</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="description">
                        <?= if_empty($quotation['description'], 'No description') ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-3 col-lg-3 col-form-label" for="service">Service</label>
				<div class="col-sm-9 col-lg-9">
					<p class="form-control-plaintext" id="service">
						<?= if_empty($quotation['service'], 'No service') ?>
					</p>
				</div>
			</div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="payment_type">Payment Type</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="payment_type">
                        <?= if_empty($quotation['payment_type'], 'No payment type') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_component">Total Component</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="total_component">
                        Rp. <?= if_empty(numerical($quotation['total_component']), '0') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_packaging">Total Packaging</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="total_packaging">
                        Rp. <?= if_empty(numerical($quotation['total_packaging']), '0') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_surcharge">Total Surcharge</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="total_surcharge">
                        Rp. <?= if_empty(numerical($quotation['total_surcharge']), '0') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="insurance">Insurance</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="insurance">
                        <?= if_empty(numerical($quotation['insurance']), 'No insurance', 'Rp. ') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="base_amount">Base Amount</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="base_amount">
                        Rp. <?= if_empty(numerical($quotation['base_amount']), '0') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="margin">Margin</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="margin">
                        Rp. <?= if_empty(numerical($quotation['total_margin']), '0') ?>
                        (<?= numerical($quotation['margin_percent']) ?>%)
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_tax">Income Tax</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="total_tax">
                        Rp. <?= if_empty(numerical($quotation['total_tax']), '0') ?>
                        (<?= numerical($quotation['tax_percent']) ?>%)
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_price_after_tax">Total After Tax</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext text-primary" id="total_price_after_tax">
                        Rp. <?= if_empty(numerical($quotation['total_price_after_tax']), '0') ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="total_payment">Total Payment</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext text-danger" id="total_payment">
                        Rp. <?= if_empty(numerical($quotation['total_payment']), '0') ?>
                        (<?= numerical($quotation['payment_percent']) ?>%)
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-lg-3 col-form-label" for="created_at">Created At</label>
                <div class="col-sm-9 col-lg-9">
                    <p class="form-control-plaintext" id="created_at">
                        <?= format_date($quotation['created_at'], 'd F Y H:i') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <p class="form-section-title">Component price</p>

    <table class="table table-sm mt-3 mb-4 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Component</th>
                <th>Vendor</th>
                <th>Package</th>
                <th class="text-md-right" style="width: 200px">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quotationComponents as $index => $component) : ?>
                <tr class="table-secondary">
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <?= $component['component'] ?>
                    </td>
                    <td><?= $component['vendor'] ?></td>
                    <td><?= if_empty($component['package'], '-') ?></td>
                    <td class="text-md-right">Rp. <?= numerical($component['total_price']) ?></td>
                </tr>
                <?php if (!empty($component['sub_components'])) : ?>
                    <?php foreach ($component['sub_components'] as $subComponent) : ?>
                        <tr>
                            <td></td>
                            <td colspan="3"><?= $subComponent['sub_component'] ?></td>
                            <td class="text-md-right">Rp. <?= numerical($subComponent['price']) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif; ?>
				<tr class="font-weight-bold">
					<td></td>
					<td colspan="3">Partner Info</td>
					<td class="font-weight-bold text-md-right"><?= $component['vendor'] ?></td>
				</tr>
				<tr class="font-weight-bold">
					<td></td>
					<td colspan="3">Total Component</td>
					<td class="font-weight-bold text-md-right">Rp. <?= numerical($component['total_price']) ?></td>
				</tr>
				<tr class="font-weight-bold">
					<td></td>
					<td colspan="3">Activity Duration</td>
					<td class="font-weight-bold text-md-right"><?= numerical($component['duration_charge_percent']) ?>% Rp. <?= numerical($component['total_activity_charge']) ?></td>
				</tr>
				<tr class="font-weight-bold">
                    <td></td>
                    <td colspan="3">Term Payment</td>
                    <td class="font-weight-bold text-md-right"><?= numerical($component['term_payment']) ?>%</td>
                </tr>
				<tr class="font-weight-bold">
					<td></td>
					<td colspan="3">Total Payment</td>
					<td class="font-weight-bold text-md-right">Rp. <?= numerical($component['total_price'] + $component['total_activity_charge']) ?></td>
				</tr>
				<tr class="font-weight-bold">
                    <td></td>
                    <td colspan="3">Total DP</td>
                    <td class="font-weight-bold text-md-right">Rp. <?= numerical($component['term_payment'] / 100 * ($component['total_price'] + $component['total_activity_charge'])) ?></td>
                </tr>
                <tr class="font-weight-bold table-danger">
                    <td></td>
                    <td colspan="3">Payment Left</td>
                    <td class="font-weight-bold text-md-right">Rp. <?= numerical(($component['total_price'] + $component['total_activity_charge']) - ($component['term_payment'] / 100 * ($component['total_price'] + $component['total_activity_charge']))) ?></td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($quotationComponents)) : ?>
                <tr>
                    <td colspan="5">
                        No component data available
                    </td>
                </tr>
            <?php else : ?>
                <tr class="font-weight-bold table-warning">
                    <td></td>
                    <td colspan="3"><strong>Total Component</strong></td>
                    <td class="text-md-right">Rp. <?= numerical(array_sum(array_column($quotationComponents, 'total_price'))) ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="form-section-title">Surcharge Price</p>

    <div class="table-responsive mb-4">
        <table class="table table-sm mb-0 table-hover text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 60px">No</th>
                    <th>Surcharge</th>
                    <th class="text-md-right" style="width: 200px">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotationSurcharges as $index => $quotationSurcharge) : ?>
                    <tr>
                        <td class="text-md-center"><?= $index + 1 ?></td>
                        <td><?= $quotationSurcharge['surcharge'] ?></td>
                        <td class="text-md-right">Rp. <?= numerical($quotationSurcharge['price']) ?></td>
                    </tr>
                <?php endforeach ?>
                <?php if (empty($quotationSurcharges)) : ?>
                    <tr>
                        <td colspan="3">
                            No surcharge data available
                        </td>
                    </tr>
                <?php else : ?>
                    <tr class="table-warning">
                        <td></td>
                        <td><strong>Total Surcharge</strong></td>
                        <td class="text-md-right">Rp. <?= numerical(array_sum(array_column($quotationSurcharges, 'price'))) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p class="form-section-title">Packaging Price</p>

    <div class="table-responsive mb-4">
        <table class="table table-sm mb-0 table-hover text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 60px">No</th>
                    <th>Surcharge</th>
                    <th class="text-md-right" style="width: 200px">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotationPackaging as $index => $packaging) : ?>
                    <tr>
                        <td class="text-md-center"><?= $index + 1 ?></td>
                        <td><?= $packaging['package'] ?></td>
                        <td class="text-md-right">Rp. <?= numerical($packaging['price']) ?></td>
                    </tr>
                <?php endforeach ?>
                <?php if (empty($quotationPackaging)) : ?>
                    <tr>
                        <td colspan="3">
                            No packaging data available
                        </td>
                    </tr>
                <?php else : ?>
                    <tr class="table-warning">
                        <td></td>
                        <td><strong>Total Packaging</strong></td>
                        <td class="text-md-right">Rp. <?= numerical(array_sum(array_column($quotationPackaging, 'price'))) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <a href="<?= site_url('pricing/quotation/print-quotation/' . $quotation['id']) ?>" class="btn btn-primary">
            Print Quotation<i class="mdi mdi-cloud-print-outline ml-2"></i>
        </a>
    </div>
</form>
