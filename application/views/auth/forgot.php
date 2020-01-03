<div class="form-auth mt-0 mt-sm-4 mx-auto">
	<div class="d-flex align-items-center mb-3">
		<img src="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" alt="Logo" class="mr-3 p-1" style="max-width: 50px; border-radius: 5px; border: 1px solid #22b250">
		<div>
			<h3 class="mb-1">Reset Password</h3>
			<p class="text-muted mb-0">Recovery my account</p>
		</div>
	</div>

    <p class="text-muted">
        Enter your email address that you used to register. We'll send you an email with your username and a
        link to reset your password.
    </p>

    <?php $this->load->view('partials/_alert') ?>

    <form action="<?= site_url('auth/password/forgot-password') ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Registered email address">
            <?= form_error('email') ?>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Request Reset Password</button>
        <div class="text-center auth-control">
            Remember password ?
            <a href="<?= site_url('auth/login') ?>">
                Sign In
            </a>
        </div>
    </form>
</div>
