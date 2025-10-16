<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý Tiện ích</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tiện ích</li>
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
                <form method="GET" action="<?= \Uri::create('admin/amenities') ?>" class="row g-1">
                    <div class="col-md-3">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả nhóm</option>
                            <option value="general" <?= ($category_filter ?? '') === 'general' ? 'selected' : '' ?>>General</option>
                            <option value="room" <?= ($category_filter ?? '') === 'room' ? 'selected' : '' ?>>Room</option>
                            <option value="facility" <?= ($category_filter ?? '') === 'facility' ? 'selected' : '' ?>>Facility</option>
                            <option value="service" <?= ($category_filter ?? '') === 'service' ? 'selected' : '' ?>>Service</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="inactive" <?= ($status_filter ?? '') === 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <input type="search" name="q" class="form-control w-auto" placeholder="Tìm theo tên, mô tả..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                        <button type="submit" class="btn btn-primary ms-2 waves-effect waves-float waves-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </button>
                        <a href="<?= \Uri::create('admin/amenities/create') ?>" class="btn btn-primary ms-1">Add new</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Icon</th>
                            <th>Nhóm</th>
                            <th>Giá</th>
                            <th>Loại DV</th>
                            <th>24/7</th>
                            <th>Giờ hoạt động</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                        <?php else: $i = 1; foreach ($rows as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row['name'] ?></td>
                                <td>
                                    <?php if (!empty($row['icon']) && strpos($row['icon'], 'assets/img/icon-figma/') === 0): ?>
                                        <img src="<?= \Uri::base() . htmlspecialchars($row['icon']) ?>"
                                             alt="icon"
                                             style="width:24px;height:24px;object-fit:contain;border-radius:50%;background:#f3f3f3;">
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars(ucfirst($row['category'])) ?></td>
                                <td>
                                    <?php if (isset($row['price']) && $row['price'] > 0): ?>
                                        <?= number_format((float)$row['price'], 0, ',', '.') ?> VNĐ
                                    <?php else: ?>Miễn phí<?php endif; ?>
                                </td>
                                <td><?= isset($row['service_type']) ? ucfirst($row['service_type']) : '' ?></td>
                                <td>
                                    <span class="badge rounded-pill badge-light-<?= !empty($row['is_24h']) ? 'success' : 'secondary' ?>">
                                        <?= !empty($row['is_24h']) ? 'Có' : 'Không' ?>
                                    </span>
                                </td>
                                <td><?= !empty($row['operating_hours']) ? htmlspecialchars($row['operating_hours']) : '' ?></td>
                                <td>
                                    <span class="badge rounded-pill badge-light-<?= $row['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= $row['status'] === 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                    </span>
                                </td>
                                <td><?= !empty($row['created_at']) ? date('d/m/Y', is_numeric($row['created_at']) ? $row['created_at'] : strtotime($row['created_at'])) : '' ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="<?= \Uri::create('admin/amenities/edit/' . $row['id']) ?>" class="dropdown-item">
                                                <i data-feather="edit-2" class="font-small-4 me-50"></i> Sửa
                                            </a>
                                            <a href="<?= \Uri::create('admin/amenities/toggle/' . $row['id']) ?>" class="dropdown-item js-amenity-toggle" data-url="<?= \Uri::create('admin/amenities/toggle/' . $row['id']) ?>">
                                                <i data-feather="toggle-right" class="font-small-4 me-50"></i> Đổi trạng thái
                                            </a>
                                            <a href="<?= \Uri::create('admin/amenities/delete/' . $row['id']) ?>" class="dropdown-item js-amenity-delete" data-url="<?= \Uri::create('admin/amenities/delete/' . $row['id']) ?>">
                                                <i data-feather="trash" class="font-small-4 me-50"></i> Xóa
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
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                            Showing <?= $pagination['start'] ?> to <?= $pagination['end'] ?> of <?= $pagination['total'] ?> entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <ul class="pagination mb-0">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <li class="paginate_button page-item previous">
                                        <a href="<?= \Uri::create('admin/amenities', array(), array_merge($_GET, array('page' => $pagination['current_page'] - 1))) ?>" class="page-link">&laquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="paginate_button page-item previous disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++): ?>
                                    <li class="paginate_button page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                        <a href="<?= \Uri::create('admin/amenities', array(), array_merge($_GET, array('page' => $i))) ?>" class="page-link"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <li class="paginate_button page-item next">
                                        <a href="<?= \Uri::create('admin/amenities', array(), array_merge($_GET, array('page' => $pagination['current_page'] + 1))) ?>" class="page-link">&raquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="paginate_button page-item next disabled">
                                        <span class="page-link">&raquo;</span>
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


