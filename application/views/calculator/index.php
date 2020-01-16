<form action="<?= site_url('pricing/calculator/save') ?>" method="POST" id="form-calculator">
	<?= _csrf() ?>

	<div class="d-flex justify-content-between">
		<h4 class="text-primary mb-3"><?= $title ?></h4>
		<?php $this->load->view('partials/_breadcrumb', [
			'breadcrumbs' => [
				'pricing' => 'pricing/calculator',
				'calculator' => 'pricing/calculator'
			]
		]) ?>
	</div>

	<hr class="mt-0">

	<p class="form-section-title text-success">Pickup Point</p>
	<div class="card border-success mb-4">
		<div class="card-header bg-primary text-white">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group mb-lg-0 row">
						<label for="port_origin" class="col-sm-3 col-form-label">Port Origin</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="port_origin" id="port_origin" data-placeholder="Select port from" style="width: 100%">
								<option value=""></option>
								<option value="0">No port</option>
								<?php foreach ($ports as $port) : ?>
									<option value="<?= $port['id'] ?>" <?= set_select('port', $port['id']) ?>>
										<?= $port['port'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('port_origin') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group mb-0 row">
						<label for="location_origin" class="col-sm-3 col-form-label">Location Origin</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="location_origin" id="location_origin" data-placeholder="Select location from" style="width: 100%">
								<option value=""></option>
								<option value="0">No location</option>
								<?php foreach ($locations as $location) : ?>
									<option value="<?= $location['id'] ?>" <?= set_select('location', $location['id']) ?>>
										<?= $location['location'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('location_origin') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="buruh_from" class="col-sm-3 col-form-label">Buruh</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="buruh_from" id="buruh_from" data-placeholder="Select buruh" style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('buruh_from') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="forklift_from" class="col-sm-3 col-form-label">Forklift</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="forklift_from" id="forklift_from" data-placeholder="Select forklift" style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('forklift_from') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row mb-0">
						<label for="activity_duration_from" class="col-sm-3 col-form-label">Duration</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="activity_duration_from" id="activity_duration_from" data-placeholder="Select activity duration" style="width: 100%">
								<option value=""></option>
								<option value="0">No Duration</option>
								<?php foreach ($consumables as $consumable) : ?>
									<?php if ($consumable['type'] == ConsumableModel::TYPE_ACTIVITY_DURATION) : ?>
										<option value="<?= $consumable['id'] ?>" <?= set_select('consumable', $consumable['id']) ?>>
											<?= $consumable['consumable'] ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?= form_error('activity_duration_from') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="address_origin" class="col-sm-3 col-form-label">Address</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="address_origin" name="address_origin" maxlength="100" placeholder="Origin address">
							<?= form_error('address_origin') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="form-section-title text-danger">Destination Point</p>
	<div class="card border-danger mb-4">
		<div class="card-header bg-danger text-white">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group mb-lg-0 row">
						<label for="port_destination" class="col-sm-3 col-form-label">Port Dest</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="port_destination" id="port_destination" data-placeholder="Select port destination" style="width: 100%">
								<option value=""></option>
								<option value="0">No port</option>
								<?php foreach ($ports as $port) : ?>
									<option value="<?= $port['id'] ?>" <?= set_select('port_destination', $port['id']) ?>>
										<?= $port['port'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('port_destination') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group mb-0 row">
						<label for="location_destination" class="col-sm-3 col-form-label">Location Dest</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="location_destination" id="location_destination" data-placeholder="Select location destination" style="width: 100%">
								<option value=""></option>
								<option value="0">No location</option>
								<?php foreach ($locations as $location) : ?>
									<option value="<?= $location['id'] ?>" <?= set_select('location_destination', $location['id']) ?>>
										<?= $location['location'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('location_destination') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="buruh_to" class="col-sm-3 col-form-label">Buruh</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="buruh_to" id="buruh_to" data-placeholder="Select buruh" style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('buruh_to') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="forklift_to" class="col-sm-3 col-form-label">Forklift</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="forklift_to" id="forklift_to" data-placeholder="Select forklift" style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('forklift_to') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row mb-0">
						<label for="activity_duration_to" class="col-sm-3 col-form-label">Duration</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="activity_duration_to" id="activity_duration_to" data-placeholder="Select activity duration" style="width: 100%">
								<option value=""></option>
								<option value="0">No Duration</option>
								<?php foreach ($consumables as $consumable) : ?>
									<?php if ($consumable['type'] == ConsumableModel::TYPE_ACTIVITY_DURATION) : ?>
										<option value="<?= $consumable['id'] ?>" <?= set_select('consumable', $consumable['id']) ?>>
											<?= $consumable['consumable'] ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?= form_error('activity_duration_to') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="address_destination" class="col-sm-3 col-form-label">Address</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="address_destination" name="address_destination" maxlength="100" placeholder="Destination address">
							<?= form_error('address_destination') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="form-section-title">Detail Information</p>
	<div class="card mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="customer_name" class="col-sm-3 col-form-label">Customer</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="customer_name" name="customer_name" required maxlength="50" placeholder="Full name">
							<?= form_error('customer_name') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="company" class="col-sm-3 col-form-label">Company</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="company" name="company" required maxlength="50" placeholder="Company name">
							<?= form_error('company') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="marketing" class="col-sm-3 col-form-label">Marketing</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="marketing" id="marketing" data-placeholder="Select marketing" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($marketings as $marketing) : ?>
									<option value="<?= $marketing['id'] ?>" <?= set_select('marketing', $marketing['id']) ?>>
										<?= $marketing['name'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('marketing') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="loading_category" class="col-sm-3 col-form-label">Category</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="loading_category" id="loading_category" data-placeholder="Select loading category" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($loadingCategories as $loadingCategory) : ?>
									<option value="<?= $loadingCategory['id'] ?>" <?= set_select('loading_category', $loadingCategory['id']) ?>>
										<?= $loadingCategory['loading_category'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('loading_category') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="container_size" class="col-sm-3 col-form-label">Cargo Size</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="container_size" id="container_size" data-placeholder="Select container size" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($containerSizes as $containerSize) : ?>
									<option value="<?= $containerSize['id'] ?>" <?= set_select('container_size', $containerSize['id']) ?>>
										<?= $containerSize['container_size'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('container_size') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="container_type" class="col-sm-3 col-form-label">Cargo Type</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="container_type" id="container_type" data-placeholder="Select container type" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($containerTypes as $containerType) : ?>
									<option value="<?= $containerType['id'] ?>" <?= set_select('container_type', $containerType['id']) ?>>
										<?= $containerType['container_type'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('container_type') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row mb-0">
						<label for="service" class="col-sm-3 col-form-label">Service</label>
						<div class="col-sm-9">
							<select class="form-control select2 select-service" name="service" id="service" data-placeholder="Select service type" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($services as $service) : ?>
									<option value="<?= $service['id'] ?>" <?= set_select('service', $service['id']) ?>>
										<?= $service['service'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('service') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4">
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row mb-lg-0">
						<label for="payment_type" class="col-sm-3 col-form-label">Payment Type</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="payment_type" id="payment_type" data-placeholder="Select payment type" required style="width: 100%">
								<option value=""></option>
								<?php foreach ($paymentTypes as $paymentType) : ?>
									<option value="<?= $paymentType['id'] ?>" <?= set_select('payment_type', $paymentType['id']) ?>>
										<?= $paymentType['payment_type'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('payment_type') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row mb-0">
						<label for="shipping_line" class="col-sm-3 col-form-label">Shipping Line</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="shipping_line" id="shipping_line" data-placeholder="Select shipping line" required style="width: 100%">
								<option value=""></option>
								<option value="-1">NO SHIPPING LINE</option>
								<option value="0">ALL</option>
								<?php foreach ($vendors as $vendor) : ?>
									<?php if ($vendor['type'] == VendorModel::TYPE_SHIPPING_LINE) : ?>
										<option value="<?= $vendor['id'] ?>" <?= set_select('vendor', $vendor['id']) ?>>
											<?= $vendor['vendor'] ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?= form_error('vendor') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="form-section-title text-warning">Additional Service</p>
	<div class="card border-warning mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="packaging" class="col-sm-3 col-form-label">Packaging</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="packaging" id="packaging" data-placeholder="Use package" required style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('packaging') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="income_tax" class="col-sm-3 col-form-label">Income Tax 2%</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="income_tax" id="income_tax" data-placeholder="Include tax" required style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('income_tax') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="insurance" class="col-sm-3 col-form-label">Insurance</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="insurance" id="insurance" data-placeholder="Use insurance" required style="width: 100%">
								<option value=""></option>
								<option value="1">YES</option>
								<option value="0">NO</option>
							</select>
							<?= form_error('insurance') ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="goods_value" class="col-sm-3 col-form-label">Goods Value</label>
						<div class="col-sm-9">
							<input type="text" class="form-control currency" id="goods_value" name="goods_value" data-toggle="tooltip" data-placement="top" title="Any amount below Rp. 125 M will treat Rp. 125 M as minimum (8% + Rp. 25.000)"
								   readonly maxlength="50" placeholder="Per container min Rp. 125.000.000">
							<?= form_error('goods_value') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="pricing-wrapper" class="my-4">

	</div>

	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Additional note"><?= set_value('description') ?></textarea>
		<?= form_error('description') ?>
	</div>

	<hr>

	<div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Price<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
	</div>
</form>

<script id="pricing-template" type="text/x-custom-template">
	<div class="card border-primary pricing-item mb-4" data-id="{{id}}">
		<div class="card-header">{{title}}</div>
		<div class="card-body p-0">
			<table class="table table-sm responsive">
				<thead class="thead-dark">
					<tr>
						<th style="width: 150px">Component</th>
						<th style="width: 200px">Package</th>
						<th style="width: 250px">Partner</th>
						<th style="width: 300px" class="text-md-right">Price</th>
						<th style="width: 80px"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($components as $component) : ?>
						<tr class="row-component" data-component-id="<?= $component['id'] ?>" data-service-section="<?= $component['service_section'] ?>">
							<td class="font-weight-bold"><?= $component['component'] ?></td>
							<td>
								<select class="form-control select2 select-package" name="pricing[0][components][<?= $component['id'] ?>][package]" aria-label="Package" data-placeholder="Package <?= $component['component'] ?>" style="max-width: 150px">
									<option value=""></option>
									<?php foreach ($component['packages'] as $package) : ?>
										<option value="<?= $package['id'] ?>" <?= set_select('package', $package['id']) ?>>
											<?= $package['package'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
							<td>
								<select class="form-control select2 select-vendor" name="pricing[0][components][<?= $component['id'] ?>][vendor]" disabled aria-label="Vendor" data-placeholder="Select <?= strtolower($component['provider']) ?>" style="width: 100%">
									<option value=""></option>
									<?php if ($component['provider'] == VendorModel::TYPE_SHIPPING_LINE) : ?>
										<?php foreach ($vendors as $vendor) : ?>
											<?php if ($vendor['type'] == VendorModel::TYPE_SHIPPING_LINE) : ?>
												<option value="<?= $vendor['id'] ?>" <?= set_select('vendor', $vendor['id']) ?>>
													<?= $vendor['vendor'] ?>
												</option>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php else : ?>
										<?php foreach ($vendors as $vendor) : ?>
											<?php if ($vendor['type'] == VendorModel::TYPE_TRUCKING) : ?>
												<option value="<?= $vendor['id'] ?>" <?= set_select('vendor', $vendor['id']) ?>>
													<?= $vendor['vendor'] ?>
												</option>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<input type="hidden" name="pricing[0][components][<?= $component['id'] ?>][partner]" class="input-vendor">
								<input type="hidden" name="pricing[0][components][<?= $component['id'] ?>][duration_percent]" class="input-duration-percent">
							</td>
							<td class="text-md-right">
								<input type="text" readonly class="form-control text-md-right ml-auto currency input-component-price" style="max-width: 300px" aria-label="Price" placeholder="Component <?= $component['component'] ?> price" name="pricing[0][components][<?= $component['id'] ?>][price]">
								<input type="hidden" class="form-control input-component-price-original" name="pricing[0][components][<?= $component['id'] ?>][price_original]">
							</td>
							<td class="text-md-right">
								<button class="btn btn-sm btn-outline-danger btn-reveal-price" type="button">
									<i class="mdi mdi-magnify"></i>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
					<tr class="row-packaging">
						<td colspan="2">Packaging</td>
						<td>
							<select class="form-control select2 select-packaging" name="pricing[][packaging][][package]" aria-label="Packaging" data-placeholder="Add packaging" style="width: 100%">
								<option value=""></option>
								<option value="0">No Packaging</option>
								<?php foreach ($consumables as $consumable) : ?>
									<?php if ($consumable['type'] == ConsumableModel::TYPE_PACKAGING) : ?>
										<option value="<?= $consumable['id'] ?>" <?= set_select('consumable', $consumable['id']) ?>>
											<?= $consumable['consumable'] ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="text-md-right">
							<input type="text" class="form-control text-md-right ml-auto currency input-packaging-price" aria-label="Packaging price"
								   name="pricing[][packaging][][price]" readonly maxlength="50" style="max-width: 300px" placeholder="Packaging price">
						</td>
						<td class="text-md-right">
							<button class="btn btn-sm btn-primary btn-add-packaging" type="button">
								<i class="mdi mdi-plus"></i>
							</button>
						</td>
					</tr>
					<tr class="row-surcharge">
						<td colspan="2">Surcharge</td>
						<td>
							<input type="text" class="form-control" name="pricing[][surcharges][][surcharge]" maxlength="50"
								   aria-label="Surcharge title" placeholder="Surcharge title">
						</td>
						<td class="text-md-right">
							<input type="text" class="form-control text-md-right ml-auto currency input-surcharge-price" name="pricing[][surcharges][][price]"
								   maxlength="50" aria-label="Surcharge price" style="max-width: 300px" placeholder="Surcharge price">
						</td>
						<td class="text-md-right">
							<button class="btn btn-sm btn-primary btn-add-surcharge" type="button">
								<i class="mdi mdi-plus"></i>
							</button>
						</td>
					</tr>
					<tr>
						<td colspan="3">Insurance</td>
						<td class="text-md-right label-insurance">
							<input type="text" readonly class="form-control text-md-right ml-auto currency input-insurance-price"
								   aria-label="Insurance" placeholder="Insurance amount" style="max-width: 300px" name="pricing[][insurance]">
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
					<tr class="font-weight-bold">
						<td colspan="3">Purchase Amount</td>
						<td class="text-md-right label-purchase-amount">
							Rp. 0
						</td>
						<td></td>
					</tr>
					<tr class="font-weight-bold">
						<td colspan="3">Sell Amount (Before Tax)</td>
						<td class="text-md-right label-sell-before-tax">
							Rp. 0
						</td>
						<td></td>
					</tr>
					<tr class="font-weight-bold table-success">
						<td colspan="3">Sell Amount (After Tax)</td>
						<td class="text-md-right label-sell-after-tax">
							Rp. 0
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</script>

<script id="component-detail-template" type="text/x-custom-template">
	<tr class="row-component-detail">
		<td colspan="4" class="pl-4">
			<table class="table table-sm responsive ml-3">
				<thead>
				<tr>
					<th style="width: 60px" class="text-md-center">No</th>
					<th>Sub Component</th>
					<th class="text-md-right">Price</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td colspan="3">Fetching data...</td>
				</tr>
				</tbody>
				<tfoot class="font-weight-bold">
				<tr>
					<td></td>
					<td>Partner Info</td>
					<td class="text-md-right partner-info"></td>
				</tr>
				<tr>
					<td></td>
					<td>Total Component</td>
					<td class="text-md-right partner-total-component"></td>
				</tr>
				<tr>
					<td></td>
					<td>Activity Duration</td>
					<td class="text-md-right partner-activity-duration"></td>
				</tr>
				<tr>
					<td></td>
					<td>Term Payment</td>
					<td class="text-md-right partner-term-payment"></td>
				</tr>
				<tr>
					<td></td>
					<td>Total Payment</td>
					<td class="text-md-right partner-total-payment"></td>
				</tr>
				<tr>
					<td></td>
					<td>Total DP</td>
					<td class="text-md-right partner-total-dp"></td>
				</tr>
				<tr>
					<td></td>
					<td>Payment Left</td>
					<td class="text-md-right partner-payment-left"></td>
				</tr>
				</tfoot>
			</table>
		</td>
		<td></td>
	</tr>
</script>

<script id="packaging-template" type="text/x-custom-template">
	<tr class="row-packaging additional-package">
		<td colspan="2"></td>
		<td>
			<select class="form-control select2 select-packaging" name="pricing[][packaging][][package]" aria-label="Packaging" data-placeholder="Add packaging" required style="width: 100%">
				<option value=""></option>
				<?php foreach ($consumables as $consumable) : ?>
					<?php if ($consumable['type'] == ConsumableModel::TYPE_PACKAGING) : ?>
						<option value="<?= $consumable['id'] ?>" <?= set_select('consumable', $consumable['id']) ?>>
							<?= $consumable['consumable'] ?>
						</option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</td>
		<td class="text-md-right">
			<input type="text" class="form-control text-md-right ml-auto currency input-packaging-price" name="pricing[][packaging][][price]"
				   required readonly maxlength="50" style="max-width: 300px" aria-label="Packaging price" placeholder="Packaging price">
		</td>
		<td class="text-md-right">
			<button class="btn btn-sm btn-outline-danger btn-remove-packaging" type="button">
				<i class="mdi mdi-trash-can-outline"></i>
			</button>
		</td>
	</tr>
</script>

<script id="surcharge-template" type="text/x-custom-template">
	<tr class="row-surcharge additional-surcharge">
		<td colspan="2"></td>
		<td>
			<input type="text" class="form-control" name="pricing[][surcharges][][surcharge]" required maxlength="50"
				   aria-label="Surcharge title" placeholder="Surcharge title">
		</td>
		<td class="text-md-right">
			<input type="text" class="form-control text-md-right ml-auto currency input-surcharge-price" name="pricing[][surcharges][][price]"
				   required maxlength="50" style="max-width: 300px" aria-label="Surcharge price" placeholder="Surcharge price">
		</td>
		<td class="text-md-right">
			<button class="btn btn-sm btn-outline-danger btn-remove-surcharge" type="button">
				<i class="mdi mdi-trash-can-outline"></i>
			</button>
		</td>
	</tr>
</script>
