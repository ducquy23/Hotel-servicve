<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>

<div class="content-wrapper container-xxl p-0">
    <div class="content-body">
        <!-- users list start -->
        <section class="app-user-list">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tạo Admin Mới</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?= \Uri::create('admin/admins/create') ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?= \Input::post('username', '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= \Input::post('email', '') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="full_name">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                                   value="<?= \Input::post('full_name', '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="avatar">Ảnh đại diện</label>
                                            <input type="file" class="form-control" id="avatar" name="avatar" 
                                                   accept="image/*">
                                            <small class="text-muted">Chấp nhận: JPG, PNG, GIF (tối đa 2MB)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="group">Nhóm quyền</label>
                                            <select class="form-select" id="group" name="group">
                                                <option value="1" <?= \Input::post('group', 100) == 1 ? 'selected' : '' ?>>User</option>
                                                <option value="50" <?= \Input::post('group', 100) == 50 ? 'selected' : '' ?>>Managers</option>
                                                <option value="100" <?= \Input::post('group', 100) == 100 ? 'selected' : '' ?>>Administrator</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="status">Trạng thái</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="active" <?= \Input::post('status', 'active') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                                <option value="inactive" <?= \Input::post('status', 'active') == 'inactive' ? 'selected' : '' ?>>Vô hiệu hóa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="password">Mật khẩu <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label" for="password_confirm">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="<?= \Uri::create('admin/admins') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                                            <button type="submit" class="btn btn-primary">Tạo Admin</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- users list ends -->
    </div>
</div>