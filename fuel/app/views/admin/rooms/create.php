<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Tạo Phòng</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/rooms') ?>">Phòng</a></li>
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
                            <?php foreach ($errors as $error): ?><li><?= $error ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= \Uri::create('admin/rooms/create') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="hotel_id">Khách sạn</label>
                                <select class="form-select" id="hotel_id" name="hotel_id" required>
                                    <option value="">Chọn khách sạn</option>
                                    <?php foreach ($hotels as $h): ?>
                                        <option value="<?= $h['id'] ?>" <?= \Input::post('hotel_id')==$h['id']?'selected':'' ?>>
                                            <?= htmlspecialchars($h['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên phòng</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= \Input::post('name') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="price">Giá</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= \Input::post('price') ?>" min="0" step="1000">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="capacity">Sức chứa</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= \Input::post('capacity',1) ?>" min="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="size">Diện tích</label>
                                <input type="text" class="form-control" id="size" name="size" value="<?= \Input::post('size') ?>" placeholder="VD: 30m²">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <?php foreach (Model_Room::get_status_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= \Input::post('status','active')==$value?'selected':'' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="room_type">Loại phòng</label>
                                <select class="form-select" id="room_type" name="room_type">
                                    <option value="">Chọn loại phòng</option>
                                    <?php foreach (Model_Room::get_room_type_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= \Input::post('room_type')==$value?'selected':'' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="bed_type">Loại giường</label>
                                <select class="form-select" id="bed_type" name="bed_type">
                                    <option value="">Chọn loại giường</option>
                                    <?php foreach (Model_Room::get_bed_type_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= \Input::post('bed_type')==$value?'selected':'' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="view_type">Hướng view</label>
                                <select class="form-select" id="view_type" name="view_type">
                                    <option value="">Chọn hướng view</option>
                                    <?php foreach (Model_Room::get_view_type_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= \Input::post('view_type')==$value?'selected':'' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="images">Ảnh phòng</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Ảnh đầu tiên sẽ làm ảnh đại diện nếu chưa có.</small>
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
                            <a href="<?= \Uri::create('admin/rooms') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                            <button type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


