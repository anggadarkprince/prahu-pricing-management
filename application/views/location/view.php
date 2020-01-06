<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'location' => 'master/location',
        'view' => 'master/location/view/' . $location['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Door location</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="location">Location</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="port">
                <?= if_empty($location['location'], 'No port name') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($location['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($location['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($location['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_LOCATION_EDIT)): ?>
			<a href="<?= site_url('master/port/edit/' . $location['id']) ?>" type="submit" class="btn btn-primary">
				Edit Location<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
