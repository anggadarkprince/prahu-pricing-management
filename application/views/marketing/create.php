<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'marketing' => 'master/marketing',
        'create' => 'master/marketing/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/marketing/save') ?>" method="POST" id="form-marketing">
    <?= _csrf() ?>

    <p class="form-section-title">Person Information</p>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required maxlength="50"
               value="<?= set_value('name') ?>" placeholder="Full name">
        <?= form_error('name') ?>
    </div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="contact">Contact</label>
				<input type="tel" class="form-control" id="contact" name="contact" maxlength="50"
					   value="<?= set_value('contact') ?>" placeholder="Phone or mobile">
				<?= form_error('contact') ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" maxlength="50"
					   value="<?= set_value('email') ?>" placeholder="Email address">
				<?= form_error('email') ?>
			</div>
		</div>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Type description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save Marketing<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
