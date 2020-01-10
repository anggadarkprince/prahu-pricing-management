<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'sub component' => 'master/componentPrice',
        'view' => 'master/componentPrice/view/' . $componentPrice['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Component price detail</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="component">Component</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="component">
                <?= if_empty($componentPrice['component'], 'No component') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="vendor">Vendor</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="vendor">
                <?= if_empty($componentPrice['vendor'], 'No vendor') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="port_origin">Port Origin</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="port_origin">
                <?= if_empty($componentPrice['port_origin'], 'No port') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="port_destination">Port Destination</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="port_destination">
                <?= if_empty($componentPrice['port_destination'], 'No port destination') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="location_origin">Location Origin</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="location_origin">
                <?= if_empty($componentPrice['location_origin'], 'No location') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="location_destination">Location Destination</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="location_destination">
                <?= if_empty($componentPrice['location_destination'], 'No location') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="container_size">Container Size</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="container_size">
                <?= if_empty($componentPrice['container_size'], 'No container size') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="container_type">Container Type</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="container_type">
                <?= if_empty($componentPrice['container_type'], 'No container type') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="sub_component">Sub Component</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="sub_component">
                <?= if_empty($componentPrice['sub_component'], 'No sub component') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="price">Price</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="price">
                Rp. <?= numerical($componentPrice['price']) ?>
            </p>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-sm-3 col-lg-2 col-form-label" for="expired_date">Expired Date</label>
		<div class="col-sm-9 col-lg-10">
			<p class="form-control-plaintext" id="expired_date">
				<?= format_date($componentPrice['expired_date'], 'd F Y') ?>
			</p>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($componentPrice['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($componentPrice['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($componentPrice['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <?php if (AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_PRICE_EDIT)) : ?>
            <a href="<?= site_url('master/component-price/edit/' . $componentPrice['id']) ?>" class="btn btn-primary">
                Edit Price<i class="mdi mdi-square-edit-outline ml-2"></i>
            </a>
        <?php endif; ?>
    </div>
</form>
