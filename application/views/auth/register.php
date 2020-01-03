<div class="form-auth mx-auto">
	<div class="d-flex align-items-center mb-4">
		<img src="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" alt="Logo" class="mr-3 p-1" style="max-width: 50px; border-radius: 5px; border: 1px solid #22b250">
		<div>
			<h3 class="mb-1">Register account</h3>
			<p class="text-muted mb-0">Register to prahu-hub pricing</p>
		</div>
	</div>

    <?php $this->load->view('components/_alert') ?>

    <form action="<?= site_url('auth/register') ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Your full name" maxlength="50" value="<?= set_value('name') ?>">
            <?= form_error('name') ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username"
                   placeholder="Enter username" maxlength="50" value="<?= set_value('username') ?>">
            <?= form_error('username') ?>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="Your email address" maxlength="50" value="<?= set_value('email') ?>">
            <?= form_error('email') ?>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Your secret password" minlength="6" maxlength="50">
            <?= form_error('password') ?>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                   placeholder="Repeat your password" minlength="6" maxlength="50">
            <?= form_error('confirm_password') ?>
        </div>
        <div class="form-group auth-control">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="1" required>
                <label class="custom-control-label" for="terms">I agree to the terms and condition.</label>
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Register</button>
        <div class="text-center auth-control">
            Already have and account ?
            <a href="<?= site_url('auth/login') ?>">
                Sign In
            </a>
        </div>
    </form>
</div>
