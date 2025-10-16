<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Sửa Tiện ích</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/amenities') ?>">Tiện ích</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
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

                <form method="POST" action="<?= \Uri::create('admin/amenities/edit/' . $amenity['id']) ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên tiện ích <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= \Input::post('name', $amenity['name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <?= \View::forge('admin/components/icon_picker', array(
                                    'name' => 'icon',
                                    'value' => \Input::post('icon', $amenity['icon']),
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
                                    <?php $cat = \Input::post('category', $amenity['category']); ?>
                                    <option value="general" <?= $cat == 'general' ? 'selected' : '' ?>>General</option>
                                    <option value="room" <?= $cat == 'room' ? 'selected' : '' ?>>Room</option>
                                    <option value="facility" <?= $cat == 'facility' ? 'selected' : '' ?>>Facility</option>
                                    <option value="service" <?= $cat == 'service' ? 'selected' : '' ?>>Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
								<?php $st = \Input::post('status', $amenity['status']); ?>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?= $st == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= $st == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                    </div>

					<div class="row">
						<div class="col-md-3">
							<div class="mb-1">
								<label class="form-label" for="price">Giá</label>
								<input type="number" class="form-control" id="price" name="price" value="<?= \Input::post('price', $amenity['price'] ?? '') ?>" min="0" step="1000" placeholder="0">
							</div>
						</div>
						<div class="col-md-3">
							<div class="mb-1">
								<label class="form-label" for="service_type">Loại dịch vụ</label>
								<?php $stype = \Input::post('service_type', $amenity['service_type'] ?? 'free'); ?>
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
								<input type="text" class="form-control" id="operating_hours" name="operating_hours" value="<?= \Input::post('operating_hours', $amenity['operating_hours'] ?? '') ?>" placeholder="Ví dụ: 09:00 - 21:00 hoặc 24/7">
							</div>
						</div>
						<div class="col-md-3">
							<div class="mb-1">
								<div class="form-check mt-2">
									<input class="form-check-input" type="checkbox" id="is_24h" name="is_24h" value="1" <?= \Input::post('is_24h', $amenity['is_24h'] ?? 0) ? 'checked' : '' ?>>
									<label class="form-check-label" for="is_24h">Hoạt động 24/7</label>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= \Input::post('description', $amenity['description']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="<?= \Uri::create('admin/amenities') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


