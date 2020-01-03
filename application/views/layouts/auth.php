<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <meta name="theme-color" content="#ffffff">
    <title><?= $this->config->item('app_name') ?> | <?= isset($title) ? $title : 'Home' ?></title>
	<link rel="icon" href="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
	<link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
</head>

<body class="has-sticky-footer">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <?php $this->load->view($page, $data) ?>
        </div>
        <div class="col-lg-8 col-md-6 pr-0 d-none d-md-flex">
            <div class="text-white overlay auth-banner full-height w-100" style="background: url('https://www.smlines.com/iFile/main/2017090521063938.jpg') center / cover;">
                <h1 class="display-6">Instant Pricing Calculator</h1>
                <p class="lead" style="opacity: 0.93"><?= get_setting('meta_description') ?></p>
                <ul class="mt-4 list-unstyled">
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACsSURBVEhLYxgFo2BwAed5HqZO891X2M+354AKUQ+ADV/g/sF5gft/5wWuhVBh6gBUw90Wha4KZYZKUQ5GDccKyDIcqIjNeb7bMpBmqBBWQLbLHRe4lYA0gTXjsISiYDGeaczqPN99NS5LKDIcBuz327MANa9Ct4QqhsMASDMou8MtWeCWRjXDYQBkCDjCwYbCMJUMhwGwTxa4L6GJ4TAA9gkwiGhi+CiAAAYGADGloRbwDtXLAAAAAElFTkSuQmCC">
                        <strong>Planning</strong><span class="d-none d-md-inline" style="opacity: 0.8"> - finalizing the daily plan for receiving dock activity.</span>
                    </li>
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACsSURBVEhLYxgFo2BwAed5HqZO891X2M+354AKUQ+ADV/g/sF5gft/5wWuhVBh6gBUw90Wha4KZYZKUQ5GDccKyDIcqIjNeb7bMpBmqBBWQLbLHRe4lYA0gTXjsISiYDGeaczqPN99NS5LKDIcBuz327MANa9Ct4QqhsMASDMou8MtWeCWRjXDYQBkCDjCwYbCMJUMhwGwTxa4L6GJ4TAA9gkwiGhi+CiAAAYGADGloRbwDtXLAAAAAElFTkSuQmCC">
                        <strong>Organizing</strong><span class="d-none d-md-inline" style="opacity: 0.8"> - sequencing the orders to be picked.</span>
                    </li>
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACsSURBVEhLYxgFo2BwAed5HqZO891X2M+354AKUQ+ADV/g/sF5gft/5wWuhVBh6gBUw90Wha4KZYZKUQ5GDccKyDIcqIjNeb7bMpBmqBBWQLbLHRe4lYA0gTXjsISiYDGeaczqPN99NS5LKDIcBuz327MANa9Ct4QqhsMASDMou8MtWeCWRjXDYQBkCDjCwYbCMJUMhwGwTxa4L6GJ4TAA9gkwiGhi+CiAAAYGADGloRbwDtXLAAAAAElFTkSuQmCC">
                        <strong>Staffing</strong><span class="d-none d-md-inline" style="opacity: 0.8"> - assign staff to work functions and areas.</span>
                    </li>
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACsSURBVEhLYxgFo2BwAed5HqZO891X2M+354AKUQ+ADV/g/sF5gft/5wWuhVBh6gBUw90Wha4KZYZKUQ5GDccKyDIcqIjNeb7bMpBmqBBWQLbLHRe4lYA0gTXjsISiYDGeaczqPN99NS5LKDIcBuz327MANa9Ct4QqhsMASDMou8MtWeCWRjXDYQBkCDjCwYbCMJUMhwGwTxa4L6GJ4TAA9gkwiGhi+CiAAAYGADGloRbwDtXLAAAAAElFTkSuQmCC">
                        <strong>Directing</strong><span class="d-none d-md-inline" style="opacity: 0.8"> - ensuring the documented processes.</span>
                    </li>
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACsSURBVEhLYxgFo2BwAed5HqZO891X2M+354AKUQ+ADV/g/sF5gft/5wWuhVBh6gBUw90Wha4KZYZKUQ5GDccKyDIcqIjNeb7bMpBmqBBWQLbLHRe4lYA0gTXjsISiYDGeaczqPN99NS5LKDIcBuz327MANa9Ct4QqhsMASDMou8MtWeCWRjXDYQBkCDjCwYbCMJUMhwGwTxa4L6GJ4TAA9gkwiGhi+CiAAAYGADGloRbwDtXLAAAAAElFTkSuQmCC">
                        <strong>Controlling</strong><span class="d-none d-md-inline" style="opacity: 0.8"> - providing milestones for reporting through the day.</span>
                    </li>
                </ul>
                <a href="<?= site_url('page/help') ?>" class="btn btn-outline-light px-5 mt-3">Learn More</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('components/_footer') ?>

<script src="<?= base_url(get_asset('runtime.js')) ?>"></script>
<script src="<?= base_url(get_asset('vendors.js')) ?>"></script>
<script src="<?= base_url(get_asset('app.js')) ?>"></script>
</body>

</html>
