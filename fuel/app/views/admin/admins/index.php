<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Quản lý admin</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= \Uri::create('admin/dashboard/index') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- users list start -->
        <section class="app-user-list">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="fw-bolder mb-75"><?= count($rows) ?></h3>
                                <span>Tổng Admin</span>
                            </div>
                            <div class="avatar bg-light-primary p-50">
                                <span class="avatar-content">
                                    <i data-feather="users" class="font-medium-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="fw-bolder mb-75">
                                    <?= count(array_filter($rows->as_array(), fn($row) => $row['status'] == Model_Admin::STATUS_ACTIVE)) ?>
                                </h3>
                                <span>Admin Hoạt động</span>
                            </div>
                            <div class="avatar bg-light-success p-50">
                                <span class="avatar-content">
                                    <i data-feather="user-check" class="font-medium-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="fw-bolder mb-75">
                                    <?= count(array_filter($rows->as_array(), fn($row) => $row['status'] == Model_Admin::STATUS_INACTIVE)) ?>
                                </h3>
                                <span>Admin Vô hiệu hóa</span>
                            </div>
                            <div class="avatar bg-light-warning p-50">
                                <span class="avatar-content">
                                    <i data-feather="user-x" class="font-medium-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="fw-bolder mb-75">
                                    <?= count(array_filter($rows->as_array(), fn($row) => $row['group'] == 100)) ?>
                                </h3>
                                <span>Administrator</span>
                            </div>
                            <div class="avatar bg-light-info p-50">
                                <span class="avatar-content">
                                    <i data-feather="shield" class="font-medium-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title">Search &amp; Filter</h4>
                    <div class="row">
                        <div class="col-md-4 user_role">
                            <label class="form-label" for="UserRole">Role</label>
                            <form method="GET" action="<?= \Uri::create('admin/admins') ?>" id="roleFilter">
                                <input type="hidden" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>">
                                <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter ?? '') ?>">
                                <select id="UserRole" name="role" class="form-select text-capitalize mb-md-0 mb-2" onchange="this.form.submit()">
                                    <option value="">All Roles</option>
                                    <option value="100" <?= ($role_filter ?? '') == '100' ? 'selected' : '' ?>>Administrator</option>
                                    <option value="50" <?= ($role_filter ?? '') == '50' ? 'selected' : '' ?>>Managers</option>
                                    <option value="1" <?= ($role_filter ?? '') == '1' ? 'selected' : '' ?>>Users</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4 user_status">
                            <label class="form-label" for="FilterTransaction">Status</label>
                            <form method="GET" action="<?= \Uri::create('admin/admins') ?>" id="statusFilter">
                                <input type="hidden" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>">
                                <input type="hidden" name="role" value="<?= htmlspecialchars($role_filter ?? '') ?>">
                                <select id="FilterTransaction" name="status" class="form-select text-capitalize mb-md-0 mb-2" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="active" <?= ($status_filter ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($status_filter ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                            <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start">
                                <div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select
                                                name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                                class="form-select" fdprocessedid="5ju2bk">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                            </div>

                            <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0">
                                <form method="GET" action="<?= \Uri::create('admin/admins') ?>"
                                      class="d-flex justify-content-end">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <input type="hidden" name="role"
                                                   value="<?= htmlspecialchars($role_filter ?? '') ?>">
                                            <input type="hidden" name="status"
                                                   value="<?= htmlspecialchars($status_filter ?? '') ?>">
                                            <div class="dataTables_filter">
                                                <label>Search:
                                                    <input type="search" name="q" class="form-control"
                                                           placeholder="Tìm theo tên, email..."
                                                           value="<?= htmlspecialchars($keyword ?? '') ?>"
                                                           aria-controls="DataTables_Table_0">
                                                </label>
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    <i data-feather="search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <a href="<?= \Uri::create('admin/admins/create') ?>"
                                               class="dt-button add-new btn btn-primary">
                                                <span>Add New</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="user-list-table table dataTable no-footer dtr-column" id="DataTables_Table_0"
                               role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1066px;">
                            <thead class="table-light">
                            <tr role="row">
                                <th class="control sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 0px; display: none;" aria-label=""></th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1" style="width: 10px;"
                                    aria-label="Name: activate to sort column ascending" aria-sort="descending">STT
                                </th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1" style="width: 272px;"
                                    aria-label="Name: activate to sort column ascending" aria-sort="descending">Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 112px;"
                                    aria-label="Role: activate to sort column ascending">Role
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 80px;"
                                    aria-label="Group: activate to sort column ascending">Group
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 163px;"
                                    aria-label="Created: activate to sort column ascending">Created
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 69px;"
                                    aria-label="Status: activate to sort column ascending">Status
                                </th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 73px;"
                                    aria-label="Actions">Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $key => $row): ?>
                                    <?php
                                    $full_name = $row['full_name'] ?: 'N/A';
                                    $group_name = '';
                                    $group_icon = '';
                                    switch($row['group']) {
                                        case 1:
                                            $group_name = 'User';
                                            $group_icon = 'feather-user';
                                            break;
                                        case 50:
                                            $group_name = 'Managers';
                                            $group_icon = 'feather-users';
                                            break;
                                        case 100:
                                            $group_name = 'Administrator';
                                            $group_icon = 'feather-shield';
                                            break;
                                        default:
                                            $group_name = 'Unknown';
                                            $group_icon = 'feather-help-circle';
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td class=" control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                          <?= $key + 1 ?>
                                        </td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar me-1">
                                                    <?php if (!empty($row['avatar'])): ?>
                                                        <img src="<?= \Uri::base() . 'uploads/avatars/' . $row['avatar'] ?>" 
                                                             alt="Avatar" class="round" width="32" height="32">
                                                    <?php else: ?>
                                                        <div class="avatar-content bg-primary text-white round" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                            <?= strtoupper(substr($full_name, 0, 1)) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="<?= \Uri::create('admin/admins/edit/' . $row['id']) ?>"
                                                       class="user_name text-truncate text-body">
                                                        <span class="fw-bolder"><?= $full_name ?></span>
                                                    </a>
                                                    <small class="emp_post text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-truncate align-middle">
                                                <i data-feather="<?= $group_icon ?>" class="font-medium-3 text-primary me-50"></i>
                                                <?= $group_name ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $row['group'] == 100 ? 'danger' : ($row['group'] == 50 ? 'warning' : 'secondary') ?>">
                                                <?= $group_name ?>
                                            </span>
                                        </td>
                                        <td><span class="text-nowrap"><?= date('d/m/Y', $row['created_at']) ?></span></td>
                                        <td>
                                            <span class="badge rounded-pill badge-light-<?= $row['status'] == 'active' ? 'success' : 'secondary' ?>">
                                                <?= $row['status'] == 'active' ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-sm dropdown-toggle hide-arrow"
                                                   data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-more-vertical font-small-4">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="<?= \Uri::create('admin/admins/edit/' . $row['id']) ?>" class="dropdown-item">
                                                        <i data-feather="edit" class="font-small-4 me-50"></i>
                                                        Edit
                                                    </a>
                                                    <a href="<?= \Uri::create('admin/admins/toggle/' . $row['id']) ?>"
                                                       class="dropdown-item js-admin-toggle"
                                                       data-url="<?= \Uri::create('admin/admins/toggle/' . $row['id']) ?>">
                                                        <i data-feather="<?= $row['status'] == 'active' ? 'user-x' : 'user-check' ?>" class="font-small-4 me-50"></i>
                                                        <?= $row['status'] == 'active' ? 'Deactivate' : 'Activate' ?>
                                                    </a>
                                                    <a href="<?= \Uri::create('admin/admins/reset_password/' . $row['id']) ?>"
                                                       class="dropdown-item js-admin-reset"
                                                       data-url="<?= \Uri::create('admin/admins/reset_password/' . $row['id']) ?>">
                                                        <i data-feather="key" class="font-small-4 me-50"></i>
                                                        Reset Password
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between mx-2 row mb-1">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                     aria-live="polite">
                                    Showing <?= $pagination['start'] ?> to <?= $pagination['end'] ?> of <?= $pagination['total'] ?> entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        <?php if ($pagination['current_page'] > 1): ?>
                                            <li class="paginate_button page-item previous">
                                                <a href="<?= \Uri::create('admin/admins', array_merge($_GET, array('page' => $pagination['current_page'] - 1))) ?>"
                                                   class="page-link">&laquo;</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="paginate_button page-item previous disabled">
                                                <span class="page-link">&laquo;</span>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++): ?>
                                            <li class="paginate_button page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                                <a href="<?= \Uri::create('admin/admins', array_merge($_GET, array('page' => $i))) ?>"
                                                   class="page-link"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                            <li class="paginate_button page-item next">
                                                <a href="<?= \Uri::create('admin/admins', array_merge($_GET, array('page' => $pagination['current_page'] + 1))) ?>"
                                                   class="page-link">&raquo;</a>
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
        </section>
        <!-- users list ends -->
    </div>
</div>