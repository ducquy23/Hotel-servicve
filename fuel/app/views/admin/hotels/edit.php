<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Sửa khách sạn</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/hotels') ?>">Khách sạn</a></li>
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

                <form method="POST" action="<?= \Uri::create('admin/hotels/edit/' . $row['id']) ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="name">Tên khách sạn <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= \Input::post('name', $row['name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="rating">Đánh giá</label>
                                <select class="form-select" id="rating" name="rating">
                                    <option value="0" <?= \Input::post('rating', $row['rating']) == 0 ? 'selected' : '' ?>>Chưa đánh giá</option>
                                    <option value="1" <?= \Input::post('rating', $row['rating']) == 1 ? 'selected' : '' ?>>1 sao</option>
                                    <option value="2" <?= \Input::post('rating', $row['rating']) == 2 ? 'selected' : '' ?>>2 sao</option>
                                    <option value="3" <?= \Input::post('rating', $row['rating']) == 3 ? 'selected' : '' ?>>3 sao</option>
                                    <option value="4" <?= \Input::post('rating', $row['rating']) == 4 ? 'selected' : '' ?>>4 sao</option>
                                    <option value="5" <?= \Input::post('rating', $row['rating']) == 5 ? 'selected' : '' ?>>5 sao</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= \Input::post('phone', $row['phone']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value= "<?= \Input::post('email', $row['email']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="province_id">Tỉnh/Thành phố</label>
                                <select class="form-select" id="province_id" name="province_id">
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                    <?php if (!empty($provinces)): foreach ($provinces as $province): ?>
                                        <option value="<?= $province['id'] ?>" <?= \Input::post('province_id', $row['province_id'] ?? '') == $province['id'] ? 'selected' : '' ?>>
                                            <?= $province['name'] ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="ward_id">Phường/Xã</label>
                                <select class="form-select" id="ward_id" name="ward_id">
                                    <option value="">Chọn Phường/Xã</option>
                                    <?php if (!empty($wards)): foreach ($wards as $ward): ?>
                                        <option value="<?= $ward['id'] ?>" <?= \Input::post('ward_id', $row['ward_id'] ?? '') == $ward['id'] ? 'selected' : '' ?>>
                                            <?= $ward['name'] ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="category_id">Loại khách sạn</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">Chọn loại khách sạn</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= \Input::post('category_id', $row['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="star_rating">Hạng sao</label>
                                <select class="form-select" id="star_rating" name="star_rating">
                                    <option value="1" <?= \Input::post('star_rating', $row['star_rating']) == 1 ? 'selected' : '' ?>>1 sao</option>
                                    <option value="2" <?= \Input::post('star_rating', $row['star_rating']) == 2 ? 'selected' : '' ?>>2 sao</option>
                                    <option value="3" <?= \Input::post('star_rating', $row['star_rating']) == 3 ? 'selected' : '' ?>>3 sao</option>
                                    <option value="4" <?= \Input::post('star_rating', $row['star_rating']) == 4 ? 'selected' : '' ?>>4 sao</option>
                                    <option value="5" <?= \Input::post('star_rating', $row['star_rating']) == 5 ? 'selected' : '' ?>>5 sao</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?= \Input::post('status', $row['status']) == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= \Input::post('status', $row['status']) == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="website">Website</label>
                                <input type="url" class="form-control" id="website" name="website"
                                       value="<?= \Input::post('website', $row['website']) ?>"
                                       placeholder="https://example.com">
                            </div>
                        </div>
                    </div>

                    <!-- New fields for enhanced hotels -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="checkin_time">Giờ nhận phòng</label>
                                <input type="time" class="form-control" id="checkin_time" name="checkin_time"
                                       value="<?= \Input::post('checkin_time', $row['checkin_time'] ?? '14:00') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="checkout_time">Giờ trả phòng</label>
                                <input type="time" class="form-control" id="checkout_time" name="checkout_time"
                                       value="<?= \Input::post('checkout_time', $row['checkout_time'] ?? '12:00') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="manager_name">Tên quản lý</label>
                                <input type="text" class="form-control" id="manager_name" name="manager_name"
                                       value="<?= \Input::post('manager_name', $row['manager_name'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="manager_phone">SĐT quản lý</label>
                                <input type="tel" class="form-control" id="manager_phone" name="manager_phone"
                                       value="<?= \Input::post('manager_phone', $row['manager_phone'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="wifi_password">Mật khẩu WiFi</label>
                                <input type="text" class="form-control" id="wifi_password" name="wifi_password"
                                       value="<?= \Input::post('wifi_password', $row['wifi_password'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook"
                                       value="<?= \Input::post('facebook', $row['facebook'] ?? '') ?>"
                                       placeholder="https://facebook.com/...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="instagram">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram"
                                       value="<?= \Input::post('instagram', $row['instagram'] ?? '') ?>"
                                       placeholder="https://instagram.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="is_featured">Nổi bật</label>
                                <select class="form-select" id="is_featured" name="is_featured">
                                    <option value="0" <?= \Input::post('is_featured', $row['is_featured'] ?? 0) == 0 ? 'selected' : '' ?>>Không</option>
                                    <option value="1" <?= \Input::post('is_featured', $row['is_featured'] ?? 0) == 1 ? 'selected' : '' ?>>Có</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="latitude">Vĩ độ</label>
                                <input type="text" class="form-control" id="latitude" name="latitude"
                                       value="<?= \Input::post('latitude', $row['latitude']) ?>"
                                       placeholder="VD: 10.8231">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="longitude">Kinh độ</label>
                                <input type="text" class="form-control" id="longitude" name="longitude"
                                       value="<?= \Input::post('longitude', $row['longitude']) ?>"
                                       placeholder="VD: 106.6297">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label" for="address">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" 
                                       value="<?= \Input::post('address', $row['address']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="amenities">Tiện ích</label>
                            <select class="form-select js-select2-multi" id="amenities" name="amenities[]" multiple data-placeholder="Chọn tiện ích">
                                <?php if (!empty($amenities)): foreach ($amenities as $am): ?>
                                    <?php $selected_list = (array) \Input::post('amenities', $selected_amenities ?? array()); ?>
                                    <option value="<?= $am['id'] ?>" <?= in_array($am['id'], $selected_list) ? 'selected' : '' ?>>
                                        <?= $am['name'] ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                            <small class="text-muted">Có thể tìm kiếm và chọn nhiều tiện ích</small>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="images">Ảnh khách sạn</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Có thể chọn nhiều ảnh. Nếu chưa có ảnh đại diện, ảnh đầu tiên sẽ làm đại diện.</small>
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
                                            <button type="button" class="btn btn-sm btn-danger js-delete-image" 
                                                    style="position:absolute;top:2px;right:2px;padding:2px 6px;font-size:12px;"
                                                    data-image-id="<?= $img['id'] ?>" 
                                                    data-hotel-id="<?= $row['id'] ?>"
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
                                <label class="form-label" for="cancellation_policy">Chính sách hủy</label>
                                <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" rows="3"
                                          placeholder="Nhập chính sách hủy phòng..."><?= \Input::post('cancellation_policy', $row['cancellation_policy'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= \Input::post('description', $row['description']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <a href="<?= \Uri::create('admin/hotels') ?>" class="btn btn-outline-secondary me-1">Hủy</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var provinceSelect = document.getElementById('province_id');
    var wardSelect = document.getElementById('ward_id');
    if (!provinceSelect || !wardSelect) return;

    provinceSelect.addEventListener('change', function() {
        var pid = this.value;
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        if (!pid) return;
        fetch('<?= \Uri::create('admin/wards/by-province/') ?>' + pid, { headers: { 'Accept': 'application/json' }})
            .then(function(r){ return r.json(); })
            .then(function(json){
                if (json.status === 'ok') {
                    json.data.forEach(function(w){
                        var opt = document.createElement('option');
                        opt.value = w.id;
                        opt.textContent = w.name;
                        wardSelect.appendChild(opt);
                    });
                }
            })
            .catch(function(err){ console.error(err); });
    });
});

// Handle delete image
document.addEventListener('click', function(e) {
    if (e.target.closest('.js-delete-image')) {
        e.preventDefault();
        var btn = e.target.closest('.js-delete-image');
        var imageId = btn.getAttribute('data-image-id');
        var hotelId = btn.getAttribute('data-hotel-id');
        
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
                fetch('<?= \Uri::create('admin/hotels/delete-image/') ?>' + imageId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        hotel_id: hotelId,
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
