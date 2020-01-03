<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => [
        'role' => 'master/container-size',
        'view' => 'master/container-size/view/' . $containerSize['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Container Size Information</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="container_size">Container Size</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="container_size">
                <?= if_empty($containerSize['container_size'], 'No size') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($containerSize['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($containerSize['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($containerSize['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_CONTAINER_SIZE_EDIT)): ?>
			<a href="<?= site_url('master/container-size/edit/' . $containerSize['id']) ?>" type="submit" class="btn btn-primary">
				Edit Container Size<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
