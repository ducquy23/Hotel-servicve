<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý tình trạng phòng</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tình trạng phòng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                        <i data-feather="plus"></i> Thêm tình trạng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <!-- Filters -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?= \Uri::create('admin/room-availability') ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="hotel_id">Khách sạn</label>
                                <select class="form-select" id="hotel_id" name="hotel_id">
                                    <option value="">Tất cả khách sạn</option>
                                    <?php if (!empty($hotels)): foreach ($hotels as $hotel): ?>
                                        <option value="<?= $hotel['id'] ?>" <?= \Input::get('hotel_id') == $hotel['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($hotel['name']) ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="room_id">Loại phòng</label>
                                <select class="form-select" id="room_id" name="room_id">
                                    <option value="">Tất cả loại phòng</option>
                                    <?php if (!empty($rooms)): foreach ($rooms as $room): ?>
                                        <option value="<?= $room['id'] ?>" <?= \Input::get('room_id') == $room['id'] ? 'selected' : '' ?>>
                                            <?= $room['name'] ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="date_from">Từ ngày</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="<?= \Input::get('date_from', date('Y-m-d')) ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="date_to">Đến ngày</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="<?= \Input::get('date_to', date('Y-m-d', strtotime('+7 days'))) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="<?= \Uri::create('admin/room-availability') ?>" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Khách sạn</th>
                                <th>Loại phòng</th>
                                <th>Ngày</th>
                                <th>Số phòng trống</th>
                                <th>Giá đặc biệt</th>
                                <th>Trạng thái</th>
                                <th>Lý do</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($availabilities)): foreach ($availabilities as $availability): ?>
                                <tr>
                                    <td><?= ($availability['hotel_name']) ?></td>
                                    <td><?= ($availability['room_name']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($availability['date'])) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $availability['available_rooms'] > 0 ? 'success' : 'danger' ?>">
                                            <?= $availability['available_rooms'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($availability['price_override']): ?>
                                            <span class="text-warning"><?= number_format($availability['price_override'], 0, ',', '.') ?> VNĐ</span>
                                        <?php else: ?>
                                            <span class="text-muted">Giá mặc định</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $availability['status'] == 'available' ? 'success' : ($availability['status'] == 'blocked' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($availability['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= ($availability['block_reason'] ?? '') ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editAvailability(<?= $availability['id'] ?>)">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteAvailability(<?= $availability['id'] ?>)">
                                                <i data-feather="trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm tình trạng phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="availabilityForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="modal_room_id">Loại phòng <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_room_id" name="room_id" required>
                            <option value="">Chọn loại phòng</option>
                            <?php if (!empty($rooms)): foreach ($rooms as $room): ?>
                                <option value="<?= $room['id'] ?>"><?= htmlspecialchars($room['name']) ?> - <?= htmlspecialchars($room['hotel_name']) ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_date">Ngày <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="modal_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_available_rooms">Số phòng trống</label>
                        <input type="number" class="form-control" id="modal_available_rooms" name="available_rooms" min="0" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_price_override">Giá đặc biệt (VNĐ)</label>
                        <input type="number" class="form-control" id="modal_price_override" name="price_override" min="0" step="1000">
                        <small class="text-muted">Để trống nếu dùng giá mặc định</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_status">Trạng thái</label>
                        <select class="form-select" id="modal_status" name="status">
                            <option value="available">Có sẵn</option>
                            <option value="blocked">Bị chặn</option>
                            <option value="maintenance">Bảo trì</option>
                            <option value="sold_out">Hết phòng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_block_reason">Lý do</label>
                        <textarea class="form-control" id="modal_block_reason" name="block_reason" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editAvailability(id) {
    // Load data and show modal
    fetch('<?= \Uri::create('admin/room-availability/get/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modal_room_id').value = data.data.room_id;
                document.getElementById('modal_date').value = data.data.date;
                document.getElementById('modal_available_rooms').value = data.data.available_rooms;
                document.getElementById('modal_price_override').value = data.data.price_override || '';
                document.getElementById('modal_status').value = data.data.status;
                document.getElementById('modal_block_reason').value = data.data.block_reason || '';
                
                document.getElementById('availabilityForm').action = '<?= \Uri::create('admin/room-availability/update/') ?>' + id;
                document.querySelector('#addAvailabilityModal .modal-title').textContent = 'Sửa tình trạng phòng';
                
                new bootstrap.Modal(document.getElementById('addAvailabilityModal')).show();
            }
        });
}

function deleteAvailability(id) {
    if (confirm('Bạn có chắc muốn xóa tình trạng phòng này?')) {
        fetch('<?= \Uri::create('admin/room-availability/delete/') ?>' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        });
    }
}

// Reset form when modal is hidden
document.getElementById('addAvailabilityModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('availabilityForm').reset();
    document.getElementById('availabilityForm').action = '<?= \Uri::create('admin/room-availability/create') ?>';
    document.querySelector('#addAvailabilityModal .modal-title').textContent = 'Thêm tình trạng phòng';
});
</script>
