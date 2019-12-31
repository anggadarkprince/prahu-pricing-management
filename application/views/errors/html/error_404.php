<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <meta name="theme-color" content="#28a745">
    <title><?= $this->config->item('app_name') ?> | Page not found 404</title>
	<link rel="icon" href="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
	<link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
</head>

<body>

<div class="d-flex align-items-center justify-content-center text-center" style="height: calc(100vh - 80px)">
    <div class="px-3">
        <h1 class="display-1 text-primary">404</h1>
        <h1>Page Not Found</h1>
        <p class="lead text-muted">The page you’re looking for was not found.</p>
		<a class="btn btn-primary mt-2" href="<?= site_url() ?>">
			<i class="mdi mdi-arrow-left mr-2"></i>Back to home
		</a>

		<p class="lead mt-5"><?= $this->config->item('app_name') ?></p>
		<ul class="list-inline">
			<li class="list-inline-item">
				<a href="<?= site_url('/') ?>">Dashboard</a>
			</li>
			<li class="list-inline-item">
				<a href="<?= site_url('setting') ?>">Setting</a>
			</li>
			<li class="list-inline-item">
				<a href="<?= site_url('account') ?>">My Account</a>
			</li>
		</ul>
    </div>
</div>

<?php $this->load->view('components/_footer') ?>
</body>

</html>
