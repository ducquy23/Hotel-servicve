<div class="auth-wrapper auth-cover">
	<div class="auth-inner row m-0">
		<a class="brand-logo" href="#">
			<svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28"></svg>
			<h2 class="brand-text text-primary ms-1">Task Manager</h2>
		</a>
		<div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
			<div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
				<img class="img-fluid" src="<?= \Uri::base() ?>assets/images/pages/login-v2.svg" alt="Login" />
			</div>
		</div>
		<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
			<div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
				<h2 class="card-title fw-bold mb-1">Đăng nhập Admin</h2>
				<p class="card-text mb-2">Nhập thông tin để tiếp tục</p>
				<?php if (!empty($error_message)): ?>
					<div class="alert alert-danger" role="alert">
						<?= e($error_message); ?>
					</div>
				<?php endif; ?>
				<form class="auth-login-form mt-2 needs-validation" action="<?= \Uri::create('admin/login') ?>" method="POST" novalidate>
					<div class="mb-1">
						<label class="form-label" for="username">Username hoặc Email</label>
						<input class="form-control" id="username" type="text" name="username" placeholder="admin hoặc admin@example.com" autofocus tabindex="1" required />
						<div class="invalid-feedback">Vui lòng nhập username hoặc email</div>
					</div>
					<div class="mb-1">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="login-password">Mật khẩu</label>
                            <a href="<?= \Uri::create('admin/forgot') ?>">
                                <small>Quên mật khẩu</small>
                            </a>
                        </div>
						<div class="input-group input-group-merge form-password-toggle">
							<input class="form-control form-control-merge" id="password" type="password" name="password" placeholder="············" tabindex="2" required />
							<span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
							<div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
						</div>
					</div>
                    <div class="mb-1">
                        <div class="form-check">
                            <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3">
                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                        </div>
                    </div>
					<button class="btn btn-primary w-100" tabindex="3" id="btn-login">Đăng nhập</button>
				</form>
                <p class="text-center mt-2">
                    <span>New on our platform?</span>
                    <a href="<?= \Uri::create('admin/register') ?>"><span>&nbsp;Create an account</span></a>
                </p>
                <div class="divider my-2">
                    <div class="divider-text">or</div>
                </div>
                <div class="auth-footer-btn d-flex justify-content-center">
                    <a class="btn btn-facebook waves-effect waves-float waves-light" href="<?= \Uri::create('auth/facebook') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                    <a class="btn btn-google waves-effect waves-float waves-light" href="<?= \Uri::create('auth/google') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></a>
                </div>
			</div>
		</div>
	</div>
</div>

<script>
(function(){
	var form = document.querySelector('.auth-login-form');
	if (!form) return;
	form.addEventListener('submit', function(e){
		var user = document.getElementById('username');
		var pass = document.getElementById('password');
		var valid = true;
		if (user.value.trim() === '') { user.classList.add('is-invalid'); valid = false; } else { user.classList.remove('is-invalid'); }
		if (pass.value.trim() === '') { pass.classList.add('is-invalid'); valid = false; } else { pass.classList.remove('is-invalid'); }
		if (!valid) {
			e.preventDefault();
			if (typeof toastr !== 'undefined') {
				toastr.error('Vui lòng nhập đầy đủ thông tin đăng nhập', 'Lỗi');
			}
		}
	});
})();
</script>