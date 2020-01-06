<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'marketing' => 'master/marketing',
        'view' => 'master/marketing/view/' . $marketing['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Marketing user list</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="name">Name</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="name">
                <?= if_empty($marketing['name'], 'name') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="email">Email</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="email">
                <?= if_empty($marketing['email'], 'email') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="contact">Contact</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="contact">
                <?= if_empty($marketing['contact'], 'contact') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($marketing['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($marketing['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($marketing['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_MARKETING_EDIT)): ?>
			<a href="<?= site_url('master/marketing/edit/' . $marketing['id']) ?>" class="btn btn-primary">
				Edit Marketing<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
