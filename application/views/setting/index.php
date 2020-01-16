<div class="d-flex justify-content-between">
	<h4 class="text-primary">Settings</h4>
	<?php $this->load->view('partials/_breadcrumb', [
		'breadcrumbs' => ['setting' => 'setting']
	]) ?>
</div>

<form action="<?= site_url('setting') ?>" method="post" id="form-setting" enctype="multipart/form-data">
    <?= _csrf() ?>
    <?= _method('put') ?>

	<p class="form-section-title">Profile</p>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="company_name">Company Name</label>
				<input type="text" class="form-control" id="company_name" name="company_name"
					   placeholder="Enter company name" maxlength="50"
					   value="<?= set_value('company_name', get_if_exist($setting, 'company_name')) ?>">
				<?= form_error('company_name') ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="company_contact">Contact Label</label>
				<input type="text" class="form-control" id="company_contact" name="company_contact"
					   placeholder="Company contact label" maxlength="100"
					   value="<?= set_value('company_contact', get_if_exist($setting, 'company_contact')) ?>">
				<?= form_error('company_contact') ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="company_address">Company Address</label>
		<textarea class="form-control" id="company_address" name="company_address"
				  placeholder="Application description" maxlength="300"><?= set_value('company_address', get_if_exist($setting, 'company_address')) ?></textarea>
		<?= form_error('company_address') ?>
	</div>
	<div class="form-group">
		<label>Company Logo</label>
		<div class="d-sm-flex align-items-center">
			<?php if(empty(get_if_exist($setting, 'company_logo'))): ?>
				<img src="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" alt="Logo" class="mb-3 mb-sm-0 mr-3" style="max-width: 90px">
			<?php else: ?>
				<img src="<?= base_url('uploads/' . $setting['company_logo']) ?>" alt="Logo" class="mb-3 mb-sm-0 mr-3" style="max-width: 90px">
			<?php endif; ?>
			<div>
				<input type="file" id="company_logo" name="company_logo" class="file-upload-default" accept="image/*" data-max-size="3000000">
				<div class="input-group col-xs-12">
					<input type="text" class="form-control file-upload-info" value="<?= set_value('company_logo', get_if_exist($setting, 'company_logo')) ?>" disabled placeholder="Upload logo" aria-label="path">
					<span class="input-group-append">
						<button class="file-upload-browse btn btn-secondary btn-simple-upload" type="button">
							Pick Image
						</button>
					</span>
				</div>
				<?= form_error('company_logo') ?>
			</div>
		</div>
	</div>

    <p class="form-section-title">Contact & Basic Setting</p>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="meta_author">Author</label>
				<input type="text" class="form-control" id="meta_author" name="meta_author"
					   placeholder="Author of application" maxlength="50"
					   value="<?= set_value('meta_author', get_if_exist($setting, 'meta_author')) ?>">
				<?= form_error('meta_author') ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="language">Language</label>
				<select class="custom-select" name="language" id="language" required>
					<option value="english"<?= set_select('language', 'english', get_if_exist($setting, 'language', 'english') == 'english') ?>>
						English (US)
					</option>
					<option value="indonesia"<?= set_select('language', 'indonesia', get_if_exist($setting, 'language', 'english') == 'indonesia') ?>>
						Indonesia (ID)
					</option>
				</select>
				<?= form_error('language'); ?>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="email_bug_report">Bug Report</label>
                <input type="email" class="form-control" id="email_bug_report" name="email_bug_report"
                       placeholder="Enter email bug reports" maxlength="50" value="<?= set_value('email_bug_report', get_if_exist($setting, 'email_bug_report', 'bug@inventory.app')) ?>">
                <?= form_error('email_bug_report') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="email_support">Support</label>
                <input type="email" class="form-control" id="email_support" name="email_support"
                       placeholder="Enter email bug reports" maxlength="50" value="<?= set_value('email_support', get_if_exist($setting, 'email_support', 'support@inventory.app')) ?>">
                <?= form_error('email_support') ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="meta_keywords">Keywords</label>
        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
               placeholder="Enter application keywords" maxlength="300" value="<?= set_value('meta_keywords', get_if_exist($setting, 'meta_keywords', 'warehouse,inventory,goods,stock,report,management')) ?>">
        <?= form_error('meta_keywords') ?>
    </div>

    <div class="form-group">
        <label for="meta_description">App Description</label>
        <textarea class="form-control" id="meta_description" name="meta_description"
                  placeholder="Application description"
                  maxlength="300"><?= set_value('meta_description', get_if_exist($setting, 'meta_description', 'An inventory management system that designed to support and optimize warehouse functionality and distribution center management')) ?></textarea>
        <?= form_error('meta_description') ?>
    </div>

    <p class="form-section-title">API Token</p>
    <div class="form-group">
        <label for="api_token">Token Key</label>
        <input type="text" class="form-control" id="api_token" name="api_token"
               placeholder="Enter api token" maxlength="100" value="<?= set_value('api_token', get_if_exist($setting, 'api_token')) ?>">
        <span class="form-text">This token is secret key to authenticate into third party service.</span>
        <?= form_error('api_token') ?>
    </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary my-4" data-toggle="one-touch">Update Settings</button>
    </div>
</form>
