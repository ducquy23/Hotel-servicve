<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Tạo Tiện ích</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/amenities') ?>">Tiện ích</a></li>
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
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= \Uri::create('admin/amenities/create') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên tiện ích <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= \Input::post('name') ?>" required>
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
                                <label class="form-label" for="category">Nhóm <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="general" <?= \Input::post('category', 'general') == 'general' ? 'selected' : '' ?>>General</option>
                                    <option value="room" <?= \Input::post('category') == 'room' ? 'selected' : '' ?>>Room</option>
                                    <option value="facility" <?= \Input::post('category') == 'facility' ? 'selected' : '' ?>>Facility</option>
                                    <option value="service" <?= \Input::post('category') == 'service' ? 'selected' : '' ?>>Service</option>
                                </select>
                            </div>
                        </div>
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
						<div class="col-md-3">
							<div class="mb-1">
								<label class="form-label" for="price">Giá</label>
								<input type="number" class="form-control" id="price" name="price" value="<?= \Input::post('price') ?>" min="0" step="1000" placeholder="0">
							</div>
						</div>
						<div class="col-md-3">
							<div class="mb-1">
								<label class="form-label" for="service_type">Loại dịch vụ</label>
								<?php $stype = \Input::post('service_type', 'free'); ?>
								<select class="form-select" id="service_type" name="service_type">
									<option value="free" <?= $stype == 'free' ? 'selected' : '' ?>>Miễn phí</option>
									<option value="paid" <?= $stype == 'paid' ? 'selected' : '' ?>>Tính phí</option>
									<option value="optional" <?= $stype == 'optional' ? 'selected' : '' ?>>Tùy chọn</option>
								</select>
							</div>
						</div>
                        <div class="col-md-3">
							<div class="mb-1">
								<label class="form-label" for="operating_hours">Giờ hoạt động</label>
								<input type="text" class="form-control" id="operating_hours" name="operating_hours" value="<?= \Input::post('operating_hours') ?>" placeholder="Ví dụ: 09:00 - 21:00 hoặc 24/7">
							</div>
						</div>
						<div class="col-md-3">
							<div class="mb-1">
								<div class="form-check mt-2">
									<input class="form-check-input" type="checkbox" id="is_24h" name="is_24h" value="1" <?= \Input::post('is_24h') ? 'checked' : '' ?>>
									<label class="form-check-label" for="is_24h">Hoạt động 24/7</label>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= \Input::post('description') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="<?= \Uri::create('admin/amenities') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                            <button type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


