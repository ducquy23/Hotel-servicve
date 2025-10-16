<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Chính sách khách sạn</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chính sách khách sạn</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                        <i data-feather="plus"></i> Thêm chính sách
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <!-- Filters -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?= \Uri::create('admin/hotel-policies') ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="hotel_id">Khách sạn</label>
                                <select class="form-select" id="hotel_id" name="hotel_id">
                                    <option value="">Tất cả khách sạn</option>
                                    <?php if (!empty($hotels)): foreach ($hotels as $hotel): ?>
                                        <option value="<?= $hotel['id'] ?>" <?= \Input::get('hotel_id') == $hotel['id'] ? 'selected' : '' ?>>
                                            <?= ($hotel['name']) ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="policy_type">Loại chính sách</label>
                                <select class="form-select" id="policy_type" name="policy_type">
                                    <option value="">Tất cả loại</option>
                                    <option value="checkin" <?= \Input::get('policy_type') == 'checkin' ? 'selected' : '' ?>>Giờ nhận phòng</option>
                                    <option value="checkout" <?= \Input::get('policy_type') == 'checkout' ? 'selected' : '' ?>>Giờ trả phòng</option>
                                    <option value="cancellation" <?= \Input::get('policy_type') == 'cancellation' ? 'selected' : '' ?>>Chính sách hủy</option>
                                    <option value="payment" <?= \Input::get('policy_type') == 'payment' ? 'selected' : '' ?>>Chính sách thanh toán</option>
                                    <option value="pets" <?= \Input::get('policy_type') == 'pets' ? 'selected' : '' ?>>Chính sách thú cưng</option>
                                    <option value="smoking" <?= \Input::get('policy_type') == 'smoking' ? 'selected' : '' ?>>Chính sách hút thuốc</option>
                                    <option value="children" <?= \Input::get('policy_type') == 'children' ? 'selected' : '' ?>>Chính sách trẻ em</option>
                                    <option value="other" <?= \Input::get('policy_type') == 'other' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Tất cả</option>
                                    <option value="active" <?= \Input::get('status') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= \Input::get('status') == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="<?= \Uri::create('admin/hotel-policies') ?>" class="btn btn-outline-secondary">Xóa bộ lọc</a>
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
                                <th>Loại</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Bắt buộc</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($policies)): foreach ($policies as $policy): ?>
                                <tr>
                                    <td><?= ($policy['hotel_name']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $policy['policy_type'] == 'checkin' || $policy['policy_type'] == 'checkout' ? 'info' : ($policy['policy_type'] == 'cancellation' ? 'warning' : 'secondary') ?>">
                                            <?= ucfirst($policy['policy_type']) ?>
                                        </span>
                                    </td>
                                    <td><?= ($policy['title']) ?></td>
                                    <td>
                                        <?php if (strlen($policy['description']) > 50): ?>
                                            <?= (substr($policy['description'], 0, 50)) ?>...
                                        <?php else: ?>
                                            <?= ($policy['description']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($policy['is_mandatory']): ?>
                                            <span class="badge badge-danger">Bắt buộc</span>
                                        <?php else: ?>
                                            <span class="badge badge-light">Tùy chọn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $policy['display_order'] ?></td>
                                    <td>
                                        <span class="badge-<?= $policy['status'] == 'active' ? 'success' : 'secondary' ?>">
                                            <?= $policy['status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editPolicy(<?= $policy['id'] ?>)">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deletePolicy(<?= $policy['id'] ?>)">
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
<div class="modal fade" id="addPolicyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm chính sách</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="policyForm" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="modal_hotel_id">Khách sạn <span class="text-danger">*</span></label>
                                <select class="form-select" id="modal_hotel_id" name="hotel_id" required>
                                    <option value="">Chọn khách sạn</option>
                                    <?php if (!empty($hotels)): foreach ($hotels as $hotel): ?>
                                        <option value="<?= $hotel['id'] ?>"><?= ($hotel['name']) ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="modal_policy_type">Loại chính sách <span class="text-danger">*</span></label>
                                <select class="form-select" id="modal_policy_type" name="policy_type" required>
                                    <option value="">Chọn loại</option>
                                    <option value="checkin">Giờ nhận phòng</option>
                                    <option value="checkout">Giờ trả phòng</option>
                                    <option value="cancellation">Chính sách hủy</option>
                                    <option value="payment">Chính sách thanh toán</option>
                                    <option value="pets">Chính sách thú cưng</option>
                                    <option value="smoking">Chính sách hút thuốc</option>
                                    <option value="children">Chính sách trẻ em</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_title">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal_description">Mô tả</label>
                        <textarea class="form-control" id="modal_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modal_is_mandatory" name="is_mandatory" value="1">
                                    <label class="form-check-label" for="modal_is_mandatory">
                                        Bắt buộc
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="modal_display_order">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" id="modal_display_order" name="display_order" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="modal_status">Trạng thái</label>
                                <select class="form-select" id="modal_status" name="status">
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Tạm dừng</option>
                                </select>
                            </div>
                        </div>
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
function editPolicy(id) {
    // Load data and show modal
    fetch('<?= \Uri::create('admin/hotel-policies/get/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modal_hotel_id').value = data.data.hotel_id;
                document.getElementById('modal_policy_type').value = data.data.policy_type;
                document.getElementById('modal_title').value = data.data.title;
                document.getElementById('modal_description').value = data.data.description || '';
                document.getElementById('modal_is_mandatory').checked = data.data.is_mandatory == 1;
                document.getElementById('modal_display_order').value = data.data.display_order;
                document.getElementById('modal_status').value = data.data.status;
                
                document.getElementById('policyForm').action = '<?= \Uri::create('admin/hotel-policies/update/') ?>' + id;
                document.querySelector('#addPolicyModal .modal-title').textContent = 'Sửa chính sách';
                
                new bootstrap.Modal(document.getElementById('addPolicyModal')).show();
            }
        });
}

// Submit create/update with AJAX and Swal
document.getElementById('policyForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = e.target;
    var actionUrl = form.action || '<?= \Uri::create('admin/hotel-policies/create') ?>';
    var formData = new FormData(form);
    fetch(actionUrl, {
        method: 'POST',
        body: new URLSearchParams([...formData]),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(r => r.json())
    .then(data => {
        if (data && data.success) {
            if (window.Swal) {
                Swal.fire({ icon: 'success', title: 'Thành công', text: 'Lưu chính sách thành công', timer: 1500, showConfirmButton: false }).then(() => location.reload());
            } else {
                alert('Lưu thành công'); location.reload();
            }
        } else {
            var msg = (data && data.message) ? data.message : 'Không thể lưu';
            if (window.Swal) Swal.fire({ icon: 'error', title: 'Lỗi', text: msg }); else alert(msg);
        }
    }).catch(err => {
        if (window.Swal) Swal.fire({ icon: 'error', title: 'Lỗi', text: err.message }); else alert(err.message);
    });
});

function deletePolicy(id) {
    if (window.Swal) {
        Swal.fire({
            title: 'Xóa chính sách?',
            text: 'Hành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= \Uri::create('admin/hotel-policies/delete/') ?>' + id, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Đã xóa', timer: 1200, showConfirmButton: false }).then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Lỗi', text: data.message || 'Không thể xóa' });
                    }
                }).catch(err => Swal.fire({ icon: 'error', title: 'Lỗi', text: err.message }));
            }
        });
    } else {
        if (confirm('Bạn có chắc muốn xóa chính sách này?')) {
            fetch('<?= \Uri::create('admin/hotel-policies/delete/') ?>' + id, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json()).then(data => { if (data.success) location.reload(); else alert(data.message || 'Không thể xóa'); });
        }
    }
}

// Reset form when modal is hidden
document.getElementById('addPolicyModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('policyForm').reset();
    document.getElementById('policyForm').action = '<?= \Uri::create('admin/hotel-policies/create') ?>';
    document.querySelector('#addPolicyModal .modal-title').textContent = 'Thêm chính sách';
});
</script>
