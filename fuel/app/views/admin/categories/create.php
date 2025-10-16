<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Tạo Loại Khách sạn</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/categories') ?>">Loại Khách sạn</a></li>
                            <li class="breadcrumb-item active">Tạo mới</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= \Uri::create('admin/categories/create') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên loại khách sạn <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="<?= \Input::post('name') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <?= \View::forge('admin/components/icon_picker', array(
                                    'name' => 'icon',
                                    'value' => \Input::post('icon'),
                                    'id' => 'icon'
                                )) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?= \Input::post('status', 'active') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= \Input::post('status', 'active') == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                          placeholder="Mô tả về loại khách sạn..."><?= \Input::post('description') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1">Tạo loại khách sạn</button>
                            <a href="<?= \Uri::create('admin/categories') ?>" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
