<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="<?= AuthModel::loginData('id') ?>">
    <meta name="description" content="<?= get_setting('meta_description') ?>">
    <meta name="keywords" content="<?= get_setting('meta_keywords') ?>">
    <meta name="theme-color" content="#28a745">
    <title><?= $this->config->item('app_name') ?> | <?= isset($title) ? $title : 'Home' ?></title>
	<link rel="icon" href="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
	<link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
</head>

<body class="has-sticky-footer">
<?php $this->load->view('components/_navigation') ?>

<div class="wrapper">
    <?php $this->load->view('components/_alert_block') ?>
    <div class="container content-wrapper pb-5">
        <?php $this->load->view($page, $data) ?>
    </div>
</div>

<?php $this->load->view('components/_footer') ?>

<script src="<?= base_url(get_asset('runtime.js')) ?>"></script>
<script src="<?= base_url(get_asset('vendors.js')) ?>"></script>
<script src="<?= base_url(get_asset('app.js')) ?>"></script>

</body>

</html>
