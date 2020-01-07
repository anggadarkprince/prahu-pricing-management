<form action="<?= site_url('pricing/calculator/save') ?>" method="POST" id="form-calculator">
    <?= _csrf() ?>

	<div class="row">
		<div class="col-lg-11 mx-auto">
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
						<div class="col-sm-6">
							<div class="form-group mb-0 row">
								<label for="port_from" class="col-sm-3 col-form-label">Port</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="port_from" id="port_from" data-placeholder="Select port from" style="width: 100%">
										<option value=""></option>
										<option value="0">No port</option>
										<?php foreach ($ports as $port) : ?>
											<option value="<?= $port['id'] ?>" <?= set_select('port', $port['id']) ?>>
												<?= $port['port'] ?> - <?= $port['code'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('port_from') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group mb-0 row">
								<label for="location_from" class="col-sm-3 col-form-label">Location</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="location_from" id="location_from" data-placeholder="Select location from" style="width: 100%">
										<option value=""></option>
										<option value="0">No location</option>
										<?php foreach ($locations as $location) : ?>
											<option value="<?= $location['id'] ?>" <?= set_select('location', $location['id']) ?>>
												<?= $location['location'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('location_from') ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="buruh_from" class="col-sm-3 col-form-label">Buruh</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="buruh_from" id="buruh_from" data-placeholder="Select buruh" required style="width: 100%">
										<option value=""></option>
										<option value="1">YES</option>
										<option value="0">NO</option>
									</select>
									<?= form_error('buruh_from') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="forklift_from" class="col-sm-3 col-form-label">Forklift</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="forklift_from" id="forklift_from" data-placeholder="Select forklift" required style="width: 100%">
										<option value=""></option>
										<option value="1">YES</option>
										<option value="0">NO</option>
									</select>
									<?= form_error('forklift_from') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row mb-0">
								<label for="activity_duration_from" class="col-sm-3 col-form-label">Duration</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="activity_duration_from" id="activity_duration_from" data-placeholder="Select activity duration" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($consumables as $consumable) : ?>
											<?php if($consumable['type'] == ConsumableModel::TYPE_ACTIVITY_DURATION): ?>
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
					</div>
				</div>
			</div>

			<p class="form-section-title text-danger">Destination Point</p>
			<div class="card border-danger mb-4">
				<div class="card-header bg-danger text-white">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group mb-0 row">
								<label for="port_to" class="col-sm-3 col-form-label">Port</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="port_to" id="port_to" data-placeholder="Select port destination" style="width: 100%">
										<option value=""></option>
										<option value="0">No port</option>
										<?php foreach ($ports as $port) : ?>
											<option value="<?= $port['id'] ?>" <?= set_select('port', $port['id']) ?>>
												<?= $port['port'] ?> - <?= $port['code'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('port_to') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group mb-0 row">
								<label for="location_to" class="col-sm-3 col-form-label">Location</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="location_to" id="location_to" data-placeholder="Select location destination" style="width: 100%">
										<option value=""></option>
										<option value="0">No location</option>
										<?php foreach ($locations as $location) : ?>
											<option value="<?= $location['id'] ?>" <?= set_select('location', $location['id']) ?>>
												<?= $location['location'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('location_to') ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="buruh_to" class="col-sm-3 col-form-label">Buruh</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="buruh_to" id="buruh_to" data-placeholder="Select buruh" required style="width: 100%">
										<option value=""></option>
										<option value="1">YES</option>
										<option value="0">NO</option>
									</select>
									<?= form_error('buruh_to') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="forklift_to" class="col-sm-3 col-form-label">Forklift</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="forklift_to" id="forklift_to" data-placeholder="Select forklift" required style="width: 100%">
										<option value=""></option>
										<option value="1">YES</option>
										<option value="0">NO</option>
									</select>
									<?= form_error('forklift_to') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row mb-0">
								<label for="activity_duration_to" class="col-sm-3 col-form-label">Duration</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="activity_duration_to" id="activity_duration_to" data-placeholder="Select activity duration" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($consumables as $consumable) : ?>
											<?php if($consumable['type'] == ConsumableModel::TYPE_ACTIVITY_DURATION): ?>
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
					</div>
				</div>
			</div>

			<p class="form-section-title">Detail Information</p>
			<div class="card mb-3">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="customer_name" class="col-sm-3 col-form-label">Customer</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="customer_name" name="customer_name"
										   required maxlength="50" placeholder="Full name">
									<?= form_error('customer_name') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="company" class="col-sm-3 col-form-label">Company</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="company" name="company"
										   required maxlength="50" placeholder="Company name">
									<?= form_error('company') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="marketing" class="col-sm-3 col-form-label">Marketing</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="marketing" id="marketing" data-placeholder="Select marketing" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($marketings as $marketing) : ?>
											<option value="<?= $marketing['id'] ?>"
													<?= set_select('marketing', $marketing['id']) ?>>
												<?= $marketing['name'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('marketing') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="loading_category" class="col-sm-3 col-form-label">Category</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="loading_category" id="loading_category" data-placeholder="Select loading category" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($loadingCategories as $loadingCategory) : ?>
											<option value="<?= $loadingCategory['id'] ?>"<?= set_select('loading_category', $loadingCategory['id']) ?>>
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
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="container_size" class="col-sm-3 col-form-label">Cargo Size</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="container_size" id="container_size" data-placeholder="Select container size" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($containerSizes as $containerSize) : ?>
											<option value="<?= $containerSize['id'] ?>"<?= set_select('container_size', $containerSize['id']) ?>>
												<?= $containerSize['container_size'] ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?= form_error('container_size') ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="container_type" class="col-sm-3 col-form-label">Cargo Type</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="container_type" id="container_type" data-placeholder="Select container type" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($containerTypes as $containerType) : ?>
											<option value="<?= $containerType['id'] ?>"<?= set_select('container_type', $containerType['id']) ?>>
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
						<div class="col-sm-6">
							<div class="form-group row mb-0">
								<label for="services" class="col-sm-3 col-form-label">Services</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="services" id="services" data-placeholder="Select service type" required style="width: 100%">
										<option value=""></option>
										<?php foreach ($services as $service) : ?>
											<option value="<?= $service['id'] ?>"<?= set_select('service', $service['id']) ?>>
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
						<div class="col-sm-6">
							<div class="form-group row mb-0">
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
						<div class="col-sm-6">
							<div class="form-group row mb-0">
								<label for="shipping_line" class="col-sm-3 col-form-label">Shipping Line</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="shipping_line" id="shipping_line" data-placeholder="Select shipping line" required style="width: 100%">
										<option value=""></option>
										<option value="0">ALL</option>
										<?php foreach ($vendors as $vendor) : ?>
											<?php if ($vendor['type'] == VendorModel::TYPE_SHIPPING_LINE): ?>
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
		</div>
	</div>
</form>
