<?php $this->load->view('partials/_breadcrumb', [
	'breadcrumbs' => [
		'port' => 'master/port',
		'create' => 'master/port/edit/' . $port['id']
	]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/port/update/' . $port['id']) ?>" method="POST" id="form-port" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Port Information</p>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="code">Port Code</label>
				<input type="text" class="form-control" id="code" name="code" required maxlength="50"
					   value="<?= set_value('code', $port['code']) ?>" placeholder="Port code">
				<?= form_error('code') ?>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="form-group">
				<label for="port">Port Name</label>
				<input type="text" class="form-control" id="port" name="port" required maxlength="100"
					   value="<?= set_value('port', $port['port']) ?>" placeholder="Port name">
				<?= form_error('port') ?>
			</div>
		</div>
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Size description"><?= set_value('description', $port['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
			Update Port<i class="mdi mdi-square-edit-outline ml-2"></i>
		</button>
    </div>
</form>
