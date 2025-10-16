<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý Phòng</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                        href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Phòng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title">Search &amp; Filter</h4>
                <div class="row">
                    <form method="GET" action="<?= \Uri::create('admin/rooms') ?>" class="row g-1">
                        <div class="col-md-3">
                            <select name="hotel_id" class="form-select" onchange="this.form.submit()">
                                <option value="0">Tất cả khách sạn</option>
                                <?php foreach ($hotels as $h): ?>
                                    <option value="<?= $h['id'] ?>" <?= ($hotel_filter ?? 0) == $h['id'] ? 'selected' : '' ?>>
                                        <?= $h['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>>Hoạt
                                    động
                                </option>
                                <option value="inactive" <?= ($status_filter ?? '') === 'inactive' ? 'selected' : '' ?>>
                                    Tạm dừng
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label>Hiển thị <select name="DataTables_Table_0_length"
                                                        aria-controls="DataTables_Table_0" class="form-select"
                                                        fdprocessedid="z51dla">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> bản ghi</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                            <form method="GET" action="<?= \Uri::create('admin/rooms') ?>"
                                  class="d-flex justify-content-end">
                                <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                    <div class="me-1">
                                        <input type="hidden" name="status" value="">
                                        <div class="dataTables_filter">
                                            <input type="search" name="q" class="form-control w-auto"
                                                   placeholder="Tìm theo tên phòng..."
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
                                    <div class="dt-buttons">
                                        <a href="<?= \Uri::create('admin/rooms/create') ?>"
                                           class="btn btn-primary ms-1">Add new</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="user-list-table table dataTable no-footer dtr-column" id="DataTables_Table_0"
                           role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1066px;">
                        <thead class="table-light">
                        <tr role="row">
                            <th>#</th>
                            <th>Tên phòng</th>
                            <th>Khách sạn</th>
                            <th>Loại phòng</th>
                            <th>Diện tích</th>
                            <th>Giường</th>
                            <th>View</th>
                            <th>Giá</th>
                            <th>Sức chứa</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
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
                                    <td><?= $row['name'] ?></td>
                                    <td><?= htmlspecialchars($row['hotel_name']) ?></td>
                                    <td>
                                        <?php
                                        $room_types = Model_Room::get_room_type_options();
                                        echo $room_types[$row['room_type']] ?? $row['room_type'];
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['size'] ?: 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['bed_type'] ?: 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['view_type'] ?: 'N/A') ?></td>
                                    <td><?= number_format($row['price']) ?> VNĐ</td>
                                    <td><?= (int)$row['capacity'] ?> người</td>
                                    <td>
                                        <?php
                                        $badge_class = Model_Room::get_status_badge_class($row['status']);
                                        $status_text = Model_Room::get_status_options()[$row['status']] ?? $row['status'];
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
                                                <a href="<?= \Uri::create('admin/rooms/edit/' . $row['id']) ?>"
                                                   class="dropdown-item">
                                                    <i data-feather="edit-2" class="font-small-4 me-50"></i>
                                                    Sửa
                                                </a>
                                                <a href="<?= \Uri::create('admin/rooms/toggle/' . $row['id']) ?>"
                                                   class="dropdown-item js-room-toggle"
                                                   data-url="<?= \Uri::create('admin/rooms/toggle/' . $row['id']) ?>">
                                                    <i data-feather="<?= $row['status'] == 'active' ? 'pause' : 'play' ?>"
                                                       class="font-small-4 me-50"></i>
                                                    <?= $row['status'] == 'active' ? 'Tạm dừng' : 'Kích hoạt' ?>
                                                </a>
                                                <a href="<?= \Uri::create('admin/rooms/delete/' . $row['id']) ?>"
                                                   class="dropdown-item js-room-delete"
                                                   data-url="<?= \Uri::create('admin/rooms/delete/' . $row['id']) ?>">
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
                                of <?= $pagination['total'] ?> entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6" style="flex-basis: content">
                            <div class="dataTables_paginate paging_simple_numbers">
                                <ul class="pagination">
                                    <?php if ($pagination['current_page'] > 1): ?>
                                        <li class="paginate_button page-item previous">
                                            <a href="<?= \Uri::create('admin/rooms', array_merge($_GET, array('page' => $pagination['current_page'] - 1))) ?>"
                                               class="page-link">&laquo;</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="paginate_button page-item previous disabled"><span class="page-link">&laquo;</span>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++): ?>
                                        <li class="paginate_button page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                            <a href="<?= \Uri::create('admin/rooms', array_merge($_GET, array('page' => $i))) ?>"
                                               class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                        <li class="paginate_button page-item next">
                                            <a href="<?= \Uri::create('admin/rooms', array_merge($_GET, array('page' => $pagination['current_page'] + 1))) ?>"
                                               class="page-link">&raquo;</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="paginate_button page-item next disabled"><span class="page-link">&raquo;</span>
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
</div>


