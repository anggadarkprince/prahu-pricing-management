<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => ['setting' => 'setting']
]) ?>

<h4>Settings</h4>

<form action="<?= site_url('setting') ?>" method="post" id="form-setting">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Basic Setting</p>
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
        <label for="meta_description">Description</label>
        <textarea class="form-control" id="meta_description" name="meta_description"
                  placeholder="Application description"
                  maxlength="300"><?= set_value('meta_description', get_if_exist($setting, 'meta_description', 'An inventory management system that designed to support and optimize warehouse functionality and distribution center management')) ?></textarea>
        <?= form_error('meta_description') ?>
    </div>

    <p class="form-section-title">API Token</p>
    <div class="form-group">
        <label for="email_token">Email Token</label>
        <input type="email" class="form-control" id="email_token" name="email_token"
               placeholder="Registered token email" maxlength="50" value="<?= set_value('email_token', get_if_exist($setting, 'email_token')) ?>">
        <?= form_error('email_token') ?>
    </div>
    <div class="form-group">
        <label for="api_token">Token Key</label>
        <input type="text" class="form-control" id="api_token" name="api_token"
               placeholder="Enter api token" maxlength="100" value="<?= set_value('api_token', get_if_exist($setting, 'api_token')) ?>">
        <span class="form-text">This token is secret key to authenticate into third party service.</span>
        <?= form_error('api_token') ?>
    </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary my-4">Update Settings</button>
    </div>
</form>