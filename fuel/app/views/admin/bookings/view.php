<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Chi tiết Booking</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/bookings') ?>">Booking</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin Booking</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Mã Booking:</strong>
                                    <span class="text-primary fw-bold"><?= htmlspecialchars($booking['booking_reference']) ?></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Khách hàng:</strong>
                                    <?= htmlspecialchars($booking['user_name'] ?: 'N/A') ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Email:</strong>
                                    <?= htmlspecialchars($booking['user_email'] ?: 'N/A') ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Số điện thoại:</strong>
                                    <?= htmlspecialchars($booking['user_phone'] ?: 'N/A') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Khách sạn:</strong>
                                    <?= htmlspecialchars($booking['hotel_name'] ?: 'N/A') ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Phòng:</strong>
                                    <?= htmlspecialchars($booking['room_name'] ?: 'N/A') ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Check-in:</strong>
                                    <?= date('d/m/Y', strtotime($booking['check_in'])) ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Check-out:</strong>
                                    <?= date('d/m/Y', strtotime($booking['check_out'])) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Số khách:</strong>
                                    <?= (int)$booking['guest_count'] ?> người
                                </div>
                                <div class="mb-2">
                                    <strong>Tổng tiền:</strong>
                                    <span class="text-success fw-bold"><?= number_format($booking['total_price'], 0, ',', '.') ?> VNĐ</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Trạng thái:</strong>
                                    <?php
                                    $badge_class = Model_Booking::get_status_badge_class($booking['status']);
                                    $status_text = Model_Booking::get_status_options()[$booking['status']] ?? $booking['status'];
                                    ?>
                                    <span class="badge rounded-pill <?= $badge_class ?>"><?= $status_text ?></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Ngày tạo:</strong>
                                    <?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Rooms Details -->
                        <?php if (!empty($booking_rooms)): ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Chi tiết phòng đã đặt</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Loại phòng</th>
                                                <th>Số lượng</th>
                                                <th>Giá/đêm</th>
                                                <th>Số đêm</th>
                                                <th>Tổng tiền</th>
                                                <th>Yêu cầu đặc biệt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($booking_rooms as $room): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($room['room_name']) ?></td>
                                                    <td class="text-center"><?= $room['quantity'] ?></td>
                                                    <td class="text-end"><?= number_format($room['price_per_night'], 0, ',', '.') ?> VNĐ</td>
                                                    <td class="text-center"><?= $room['total_nights'] ?></td>
                                                    <td class="text-end text-success fw-bold"><?= number_format($room['total_price'], 0, ',', '.') ?> VNĐ</td>
                                                    <td><?= htmlspecialchars($room['guest_requests'] ?: 'Không có') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Booking Amenities -->
                        <?php if (!empty($booking_amenities)): ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Dịch vụ bổ sung</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Dịch vụ</th>
                                                <th>Số lượng</th>
                                                <th>Giá đơn vị</th>
                                                <th>Tổng tiền</th>
                                                <th>Ngày hẹn</th>
                                                <th>Giờ hẹn</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($booking_amenities as $amenity): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($amenity['amenity_name']) ?></td>
                                                    <td class="text-center"><?= $amenity['quantity'] ?></td>
                                                    <td class="text-end"><?= number_format($amenity['unit_price'], 0, ',', '.') ?> VNĐ</td>
                                                    <td class="text-end text-success fw-bold"><?= number_format($amenity['total_price'], 0, ',', '.') ?> VNĐ</td>
                                                    <td><?= $amenity['scheduled_date'] ? date('d/m/Y', strtotime($amenity['scheduled_date'])) : 'Chưa hẹn' ?></td>
                                                    <td><?= $amenity['scheduled_time'] ? date('H:i', strtotime($amenity['scheduled_time'])) : 'Chưa hẹn' ?></td>
                                                    <td>
                                                        <span class="badge badge-<?= $amenity['status'] == 'confirmed' ? 'success' : ($amenity['status'] == 'pending' ? 'warning' : 'secondary') ?>">
                                                            <?= ucfirst($amenity['status']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($booking['cancellation_reason']): ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <strong>Lý do hủy:</strong>
                                    <div class="alert alert-warning">
                                        <?= htmlspecialchars($booking['cancellation_reason']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thao tác</h4>
                    </div>
                    <div class="card-body">
                        <?php if (in_array($booking['status'], array('pending', 'confirmed', 'checked_in'))): ?>
                        <form method="POST" action="<?= \Uri::create('admin/bookings/update_status/' . $booking['id']) ?>" class="mb-3">
                            <div class="mb-2">
                                <label class="form-label">Cập nhật trạng thái:</label>
                                <select name="status" class="form-select">
                                    <?php foreach (Model_Booking::get_status_options() as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $booking['status'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                        </form>
                        <?php endif; ?>
                        
                        <?php if (in_array($booking['status'], array('pending', 'confirmed'))): ?>
                        <form method="POST" action="<?= \Uri::create('admin/bookings/cancel/' . $booking['id']) ?>" class="mb-3">
                            <div class="mb-2">
                                <label class="form-label">Lý do hủy:</label>
                                <textarea name="cancellation_reason" class="form-control" rows="3" placeholder="Nhập lý do hủy booking..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy booking này?')">Hủy Booking</button>
                        </form>
                        <?php endif; ?>
                        
                        <div class="d-grid">
                            <a href="<?= \Uri::create('admin/bookings') ?>" class="btn btn-outline-secondary">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
