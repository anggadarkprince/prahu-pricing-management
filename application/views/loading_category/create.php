<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'loading category' => 'master/loading-category',
        'create' => 'master/loading-category/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/loading-category/save') ?>" method="POST" id="form-loading-category">
    <?= _csrf() ?>

    <p class="form-section-title">Category Information</p>
	<div class="form-group">
		<label for="loading_category">Loading Category</label>
		<input type="text" class="form-control" id="loading_category" name="loading_category" required maxlength="100"
			   value="<?= set_value('loading_category') ?>" placeholder="Category title">
		<?= form_error('loading_category') ?>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Category description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Category<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
