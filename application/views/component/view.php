<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component' => 'master/component',
        'view' => 'master/component/view/' . $component['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Main component</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="component">Component</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="component">
                <?= if_empty($component['component'], 'No component') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($component['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($component['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($component['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_COMPONENT_EDIT)): ?>
			<a href="<?= site_url('master/component/edit/' . $component['id']) ?>" type="submit" class="btn btn-primary">
				Edit Component<i class="mdi mdi-square-edit-outline ml-2"></i>
			</a>
        <?php endif; ?>
    </div>
</form>
