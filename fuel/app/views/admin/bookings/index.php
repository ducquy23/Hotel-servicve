<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý Booking</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Booking</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body border-bottom">
            <h4 class="card-title">Search &amp; Filter</h4>
            <div class="row">
                <div class="col-md-4 user_status">
                    <label class="form-label" for="FilterTransaction">Trạng thái</label>
                    <form method="GET" action="<?= \Uri::create('admin/bookings') ?>" id="statusFilter">
                        <input type="hidden" name="q" value="">
                        <div class="me-1">
                            <select id="FilterTransaction" name="status"
                                    class="form-select text-capitalize mb-md-0 mb-2" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <?php foreach (Model_Booking::get_status_options() as $value => $label): ?>
                                    <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                    <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                        <div class="dataTables_length" id="DataTables_Table_0_length">
                            <label>Hiển thị <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                                    class="form-select" fdprocessedid="r179lv">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> bản ghi</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                        <form method="GET" action="<?= \Uri::create('admin/bookings') ?>"
                              class="d-flex justify-content-end">
                            <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                <div class="me-3">
                                    <input type="hidden" name="status" value="">
                                    <div class="dataTables_filter">
                                        <input type="search" name="q" class="form-control w-auto"
                                               placeholder="Tìm theo mã booking, tên khách, khách sạn..."
                                               value="<?= htmlspecialchars($keyword ?? '') ?>">
                                        <button class="btn btn-primary ms-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="user-list-table table dataTable no-footer dtr-column" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info" style="width: 1066px;">
                    <thead class="table-light">
                    <tr role="row">
                        <th class="control sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;"
                            aria-label=""></th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 50px;">#
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 120px;">MÃ BOOKING
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 150px;">KHÁCH HÀNG
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 150px;">KHÁCH SẠN
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 120px;">PHÒNG
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 100px;">CHECK-IN
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 100px;">CHECK-OUT
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 80px;">SỐ KHÁCH
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 120px;">TỔNG TIỀN
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 100px;">TRẠNG THÁI
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 100px;">NGÀY TẠO
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 100px;">THAO TÁC
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="12" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php else: $i = 1;
                        foreach ($rows as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <span class="fw-bold text-primary"><?= htmlspecialchars($row['booking_reference']) ?></span>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($row['user_name'] ?: 'N/A') ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($row['user_email'] ?: 'N/A') ?></small>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['hotel_name'] ?: 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['room_name'] ?: 'N/A') ?></td>
                                <td><?= date('d/m/Y', strtotime($row['check_in'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['check_out'])) ?></td>
                                <td><?= (int)$row['guest_count'] ?> người</td>
                                <td>
                                    <span class="fw-bold text-success"><?= number_format($row['total_price'] ?? 0, 0, ',', '.') ?> VNĐ</span>
                                </td>
                                <td>
                                    <?php
                                    $badge_class = Model_Booking::get_status_badge_class($row['status']);
                                    $status_text = Model_Booking::get_status_options()[$row['status']] ?? $row['status'];
                                    ?>
                                    <span class="badge rounded-pill <?= $badge_class ?>"><?= $status_text ?></span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="<?= \Uri::create('admin/bookings/view/' . $row['id']) ?>"
                                               class="dropdown-item">
                                                <i data-feather="eye" class="font-small-4 me-50"></i>
                                                Xem chi tiết
                                            </a>
                                            <?php if (in_array($row['status'], array('pending', 'confirmed'))): ?>
                                                <a href="<?= \Uri::create('admin/bookings/cancel/' . $row['id']) ?>"
                                                   class="dropdown-item"
                                                   onclick="return confirm('Bạn có chắc muốn hủy booking này?')">
                                                    <i data-feather="x-circle" class="font-small-4 me-50"></i>
                                                    Hủy booking
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= \Uri::create('admin/bookings/delete/' . $row['id']) ?>"
                                               class="dropdown-item"
                                               onclick="return confirm('Bạn có chắc muốn xóa booking này?')">
                                                <i data-feather="trash" class="font-small-4 me-50"></i>
                                                Xóa
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between mx-2 row mb-1 mt-2">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_info" role="status" aria-live="polite">
                            Showing <?= $pagination['start'] ?> to <?= $pagination['end'] ?>
                            of <?= $pagination['total_records'] ?> entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6" style="flex-basis: content">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <li class="paginate_button page-item previous">
                                        <a href="<?= \Uri::create('admin/bookings', array_merge($_GET, array('page' => $pagination['current_page'] - 1))) ?>"
                                           class="page-link">&laquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="paginate_button page-item previous disabled"><span
                                                class="page-link">&laquo;</span>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                                    <li class="paginate_button page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                        <a href="<?= \Uri::create('admin/bookings', array_merge($_GET, array('page' => $i))) ?>"
                                           class="page-link"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <li class="paginate_button page-item next">
                                        <a href="<?= \Uri::create('admin/bookings', array_merge($_GET, array('page' => $pagination['current_page'] + 1))) ?>"
                                           class="page-link">&raquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="paginate_button page-item next disabled"><span
                                                class="page-link">&raquo;</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
