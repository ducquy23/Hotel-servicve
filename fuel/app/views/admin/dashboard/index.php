<div class="container py-4">
	<h1>Welcome, <?= e(Auth::get('username')); ?>!</h1>
	<p class="text-muted">Bạn đang ở trang Admin Dashboard.</p>
	<p>
		<a class="btn btn-outline-danger" href="<?= Uri::create('admin/logout'); ?>">Đăng xuất</a>
	</p>
</div>