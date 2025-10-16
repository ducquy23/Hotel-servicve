<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Sửa Phòng</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/rooms') ?>">Phòng</a></li>
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
                    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <form method="POST" action="<?= \Uri::create('admin/rooms/edit/'.$row['id']) ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="hotel_id">Khách sạn</label>
                                <select class="form-select" id="hotel_id" name="hotel_id" required>
                                    <?php foreach ($hotels as $h): ?>
                                        <option value="<?= $h['id'] ?>" <?= \Input::post('hotel_id', $row['hotel_id'])==$h['id']?'selected':'' ?>>
                                            <?= htmlspecialchars($h['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên phòng</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= \Input::post('name', $row['name']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="price">Giá</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= \Input::post('price', $row['price']) ?>" min="0" step="1000">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="capacity">Sức chứa</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= \Input::post('capacity', $row['capacity']) ?>" min="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="size">Diện tích</label>
                                <input type="text" class="form-control" id="size" name="size" value="<?= \Input::post('size', $row['size']) ?>" placeholder="VD: 30m²">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
                                <?php $st = \Input::post('status', $row['status']); ?>
                                <select class="form-select" id="status" name="status">
                                    <?php foreach (Model_Room::get_status_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $st==$value?'selected':'' ?>><?= $label ?></option>
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
                                        <option value="<?= $value ?>" <?= \Input::post('room_type', $row['room_type'])==$value?'selected':'' ?>><?= $label ?></option>
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
                                        <option value="<?= $value ?>" <?= \Input::post('bed_type', $row['bed_type'])==$value?'selected':'' ?>><?= $label ?></option>
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
                                        <option value="<?= $value ?>" <?= \Input::post('view_type', $row['view_type'])==$value?'selected':'' ?>><?= $label ?></option>
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
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($images)): ?>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Ảnh hiện có</label>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($images as $img): ?>
                                    <div class="me-1 mb-1" style="position:relative;">
                                        <img src="<?= \Uri::base() . htmlspecialchars($img['image_path']) ?>" alt="img" style="height:80px;border-radius:6px;border:1px solid #eee;">
                                        <?php if ((int)$img['is_primary'] === 1): ?>
                                            <span class="badge bg-primary" style="position:absolute;top:2px;left:2px;">Primary</span>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-danger js-delete-room-image" 
                                                style="position:absolute;top:2px;right:2px;padding:2px 6px;font-size:12px;"
                                                data-image-id="<?= $img['id'] ?>" 
                                                data-room-id="<?= $row['id'] ?>"
                                                title="Xóa ảnh">
                                            <i data-feather="x" style="width:12px;height:12px;"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= \Input::post('description', $row['description']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="<?= \Uri::create('admin/rooms') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Handle delete room image
document.addEventListener('click', function(e) {
    if (e.target.closest('.js-delete-room-image')) {
        e.preventDefault();
        var btn = e.target.closest('.js-delete-room-image');
        var imageId = btn.getAttribute('data-image-id');
        var roomId = btn.getAttribute('data-room-id');
        
        Swal.fire({
            title: 'Xác nhận xóa ảnh',
            text: 'Bạn có chắc muốn xóa ảnh này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= \Uri::create('admin/rooms/delete-image/') ?>' + imageId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        room_id: roomId,
                        image_id: imageId
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        btn.closest('.me-1').remove();
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Đã xóa ảnh thành công',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: data.message || 'Có lỗi xảy ra',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi xóa ảnh',
                        icon: 'error'
                    });
                });
            }
        });
    }
});
</script>
