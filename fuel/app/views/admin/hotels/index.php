<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý Khách sạn</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Khách sạn</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <!-- Statistics -->
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75"><?= count($rows) ?></h3>
                            <span>Tổng khách sạn</span>
                        </div>
                        <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user font-medium-4"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75"><?= count(array_filter($rows->as_array(), function($row) { return $row['status'] == 'active'; })) ?></h3>
                            <span>Đang hoạt động</span>
                        </div>
                        <div class="avatar bg-light-success p-50">
                            <i data-feather="check-circle" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75"><?= count(array_filter($rows->as_array(), function($row) { return $row['status'] == 'inactive'; })) ?></h3>
                            <span>Tạm dừng</span>
                        </div>
                        <div class="avatar bg-light-warning p-50">
                            <i data-feather="pause-circle" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">
                                <?= number_format(count($rows->as_array()) ? array_sum(array_column($rows->as_array(), 'rating')) / count($rows->as_array()) : 0, 1) ?>
                            </h3>
                            <span>Đánh giá TB</span>
                        </div>
                        <div class="avatar p-50" style="background-color: #ffcc00;">
                            <i data-feather="star" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotel List -->
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title">Search &amp; Filter</h4>
                <div class="row">
                    <div class="col-md-4 user_status">
                        <label class="form-label" for="FilterTransaction">Trạng thái</label>
                        <form method="GET" action="<?= \Uri::create('admin/hotels') ?>" id="statusFilter">
                            <input type="hidden" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>">
                            <input type="hidden" name="category" value="<?= htmlspecialchars($category_filter ?? '') ?>">
                            <select id="FilterTransaction" name="status" class="form-select text-capitalize mb-md-0 mb-2" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" <?= ($status_filter ?? '') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                <option value="inactive" <?= ($status_filter ?? '') == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-4 user_status">
                        <label class="form-label" for="CategoryFilter">Loại khách sạn</label>
                        <form method="GET" action="<?= \Uri::create('admin/hotels') ?>" id="categoryFilter">
                            <input type="hidden" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>">
                            <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter ?? '') ?>">
                            <select id="CategoryFilter" name="category" class="form-select text-capitalize mb-md-0 mb-2" onchange="this.form.submit()">
                                <option value="">Tất cả loại</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= ($category_filter ?? '') == $category['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label>Hiển thị <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> bản ghi</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                            <form method="GET" action="<?= \Uri::create('admin/hotels') ?>" class="d-flex justify-content-end">
                                <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                    <div class="me-1">
                                        <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter ?? '') ?>">
                                        <input type="hidden" name="category" value="<?= htmlspecialchars($category_filter ?? '') ?>">
                                        <div class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" name="q" class="form-control" placeholder="Tìm theo tên khách sạn ..." value="<?= htmlspecialchars($keyword ?? '') ?>" aria-controls="DataTables_Table_0">
                                            </label>
                                            <button type="submit" class="btn btn-primary ms-2 waves-effect waves-float waves-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="dt-buttons d-inline-flex mt-50">
                                        <a href="<?= \Uri::create('admin/hotels/create') ?>" class="dt-button add-new btn btn-primary waves-effect waves-float waves-light">
                                            <span>Add New</span>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="user-list-table table dataTable no-footer dtr-column" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1066px;">
                        <thead class="table-light">
                            <tr role="row">
                                <th class="control sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label=""></th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 50px;">STT</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 200px;">Khách sạn</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">Loại</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;">Sao</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">Tỉnh/Thành phố</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;">Đánh giá</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;">Trạng thái</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;">Ngày tạo</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rows as $key => $row): ?>
                                    <?php
                                        $full_address = $row['address'];
                                        $words = explode(' ', $full_address);
                                        $short_address = implode(' ', array_slice($words, 0, 7));
                                        if (count($words) > 7) $short_address .= '...';
                                    ?>
                                    <tr>
                                        <td class="control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1"><?= $key + 1 ?></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="d-flex flex-column">
                                                    <a href="<?= \Uri::create('admin/hotels/edit/' . $row['id']) ?>" class="user_name text-truncate text-body">
                                                        <span class="fw-bolder"><?= $row['name'] ?></span>
                                                    </a>
                                                    <small class="emp_post text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['category_name'])): ?>
                                                <div class="d-flex align-items-center">
                                                    <span><?= $row['category_name'] ?></span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa phân loại</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i data-feather="star" class="font-medium-3 <?= $i <= $row['star_rating'] ? 'text-warning' : 'text-muted' ?> me-1"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-truncate align-middle"><?= $row['province_name'] ?: 'N/A' ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i data-feather="star" class="font-medium-3 text-warning me-50"></i>
                                                <span><?= number_format($row['rating'], 1) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill badge-light-<?= $row['status'] == 'active' ? 'success' : 'secondary' ?>">
                                                <?= $row['status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                            </span>
                                        </td>
                                        <td><span class="text-nowrap"><?= date('d/m/Y', strtotime($row['created_at'])) ?></span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="<?= \Uri::create('admin/hotels/edit/' . $row['id']) ?>" class="dropdown-item">
                                                        <i data-feather="edit-2" class="font-small-4 me-50"></i>
                                                        Sửa
                                                    </a>
                                                    <a href="<?= \Uri::create('admin/hotels/toggle/' . $row['id']) ?>" class="dropdown-item js-hotel-toggle" data-url="<?= \Uri::create('admin/hotels/toggle/' . $row['id']) ?>">
                                                        <i data-feather="<?= $row['status'] == 'active' ? 'pause' : 'play' ?>" class="font-small-4 me-50"></i>
                                                        <?= $row['status'] == 'active' ? 'Tạm dừng' : 'Kích hoạt' ?>
                                                    </a>
                                                    <a href="<?= \Uri::create('admin/hotels/delete/' . $row['id']) ?>" class="dropdown-item js-hotel-delete" data-url="<?= \Uri::create('admin/hotels/delete/' . $row['id']) ?>">
                                                        <i data-feather="trash" class="font-small-4 me-50"></i>
                                                        Xóa
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                     <div class="d-flex justify-content-between mx-2 row mb-1">
                         <div class="col-sm-12 col-md-6">
                             <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                 Showing <?= $pagination['start'] ?> to <?= $pagination['end'] ?> of <?= $pagination['total'] ?> entries
                             </div>
                         </div>
                         <div class="col-sm-12 col-md-6">
                             <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                 <ul class="pagination">
                                     <?php if ($pagination['current_page'] > 1): ?>
                                        <li class="paginate_button page-item previous">
                                            <a href="<?= \Uri::create('admin/hotels', array(), array_merge($_GET, array('page' => $pagination['current_page'] - 1))) ?>" class="page-link">&laquo;</a>
                                         </li>
                                     <?php else: ?>
                                         <li class="paginate_button page-item previous disabled">
                                             <span class="page-link">&laquo;</span>
                                         </li>
                                     <?php endif; ?>

                                     <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++): ?>
                                        <li class="paginate_button page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                            <a href="<?= \Uri::create('admin/hotels', array(), array_merge($_GET, array('page' => $i))) ?>" class="page-link"><?= $i ?></a>
                                         </li>
                                     <?php endfor; ?>

                                     <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                        <li class="paginate_button page-item next">
                                            <a href="<?= \Uri::create('admin/hotels', array(), array_merge($_GET, array('page' => $pagination['current_page'] + 1))) ?>" class="page-link">&raquo;</a>
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
</div>
