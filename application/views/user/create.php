<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'user' => 'master/user',
        'create' => 'master/user/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/user/save') ?>" method="post" enctype="multipart/form-data">
    <?= _csrf() ?>
    <p class="form-section-title">Profile Info</p>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="Your full name" maxlength="50" value="<?= set_value('name') ?>">
                <?= form_error('name') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Unique username" maxlength="50" value="<?= set_value('username') ?>">
                <?= form_error('username') ?>
            </div>
        </div>
    </div>
	<div class="form-group">
		<label for="email">Email Address</label>
		<input type="email" class="form-control" id="email" name="email"
			   placeholder="Your email address" maxlength="50" value="<?= set_value('email') ?>">
		<?= form_error('email') ?>
	</div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="avatar">Photo</label>
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png" class="file-upload-default" data-max-size="2000000">
                <div class="input-group">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload photo">
                    <div class="input-group-append">
                        <button class="file-upload-browse btn btn-secondary btn-simple-upload" type="button">
                            Select Photo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="custom-select" name="status" id="status" required>
                    <option value="<?= UserModel::STATUS_ACTIVATED ?>"
                        <?= set_select('status', UserModel::STATUS_ACTIVATED) ?>>
                        <?= UserModel::STATUS_ACTIVATED ?>
                    </option>
                    <option value="<?= UserModel::STATUS_SUSPENDED ?>"
                        <?= set_select('status', UserModel::STATUS_SUSPENDED) ?>>
                        <?= UserModel::STATUS_SUSPENDED ?>
                    </option>
                </select>
                <?= form_error('status'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Pick a password" required minlength="6" maxlength="50">
                <?= form_error('password') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                       placeholder="Repeat your password" minlength="6" maxlength="50">
                <?= form_error('confirm_password') ?>
            </div>
        </div>
    </div>

    <p class="form-section-title">User Roles</p>
    <div class="row">
        <?php foreach ($roles as $role): ?>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input"
                               id="role_<?= $role['id'] ?>" name="roles[]"
                               value="<?= $role['id'] ?>"<?= set_checkbox('roles[]', $role['id']) ?>>
                        <label class="custom-control-label" for="role_<?= $role['id'] ?>">
                            <?= $role['role'] ?>
                        </label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?= form_error('roles[]') ?>

    <hr>

    <div class="d-flex justify-content-between">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
		<button type="submit" class="btn btn-success" data-toggle="one-touch">
			Save User<i class="mdi mdi-content-save-outline ml-2"></i>
		</button>
    </div>
</form>
