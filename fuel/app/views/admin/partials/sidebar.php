<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow expanded" data-scroll-to-active="true"
     style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="navbar-header expanded">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="<?= \Uri::create('/') ?>">
          <span class="brand-logo">
            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
              <defs>
                <linearGradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                  <stop stop-color="#000000" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </linearGradient>
                <linearGradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                  <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </linearGradient>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                  <g id="Group" transform="translate(400.000000, 178.000000)">
                    <path class="text-primary" id="Path"
                          d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                          style="fill:currentColor"></path>
                    <path id="Path1"
                          d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                          fill="url(#linearGradient-1)" opacity="0.2"></path>
                    <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                             points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                    <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                             points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                    <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                             points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                  </g>
                </g>
              </g>
            </svg>
          </span>
                    <h2 class="brand-text">Vuexy</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-x d-block d-xl-none text-primary toggle-icon font-medium-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-disc d-none d-xl-block collapse-toggle-icon primary font-medium-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content ps ps--active-y" style="height: 848.625px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php
            $current_controller = \Request::active()->controller;
            $current_action = \Request::active()->action;
            $is_dashboard = ($current_controller === 'Controller_Admin_Dashboard');
            $is_admins = ($current_controller === 'Controller_Admin_Admins');
            $is_hotels = ($current_controller === 'Controller_Admin_Hotels');
            $is_amenities = ($current_controller === 'Controller_Admin_Amenities');
            $is_rooms = ($current_controller === 'Controller_Admin_Rooms');
            $is_contacts = ($current_controller === 'Controller_Admin_Contacts');
            $is_blogs = ($current_controller === 'Controller_Admin_Blogs');
            $is_bookings = ($current_controller === 'Controller_Admin_Bookings');
            $is_room_availability = ($current_controller === 'Controller_Admin_Availability');
            $is_hotel_policies = ($current_controller === 'Controller_Admin_Policies');
            ?>
            <li class="nav-item <?= $is_dashboard ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/dashboard/index') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Dashboards</span>
                </a>
            </li>
            <li class="navigation-header">
                <span>Quản trị</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </li>

            <li class="nav-item <?= $is_admins ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/admins') ?>" class="d-flex align-items-center" target="_self">
                    <svg class="fi-sidebar-item-icon h-6 w-6 text-gray-400 dark:text-gray-500"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>
                    </svg>
                    <span class="menu-title text-truncate">Quản lý admin</span>
                </a>
            </li>

            <li class="navigation-header">
                <span>Khách sạn</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </li>

            <li class="nav-item <?= ($current_controller === 'Controller_Admin_Categories') ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/categories') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-tag">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                    <span class="menu-title text-truncate">Loại khách sạn</span>
                </a>
            </li>

            <li class="nav-item <?= $is_hotels ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/hotels') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Quản lý khách sạn</span>
                </a>
            </li>

            <li class="nav-item <?= $is_rooms ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/rooms') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-grid">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="menu-title text-truncate">Phòng</span>
                </a>
            </li>

            <li class="nav-item <?= $is_bookings ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/bookings') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span class="menu-title text-truncate">Booking</span>
                </a>
            </li>

            <li class="nav-item <?= $is_amenities ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/amenities') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-layers">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Tiện ích & Dịch vụ</span>
                </a>
            </li>

            <li class="nav-item <?= $is_room_availability ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/availability') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span class="menu-title text-truncate">Tình trạng phòng</span>
                </a>
            </li>

            <li class="nav-item <?= $is_hotel_policies ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/policies') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14,2 14,8 20,8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10,9 9,9 8,9"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Chính sách khách sạn</span>
                </a>
            </li>
            <li class="navigation-header">
                <span>Liên hệ</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </li>
            <li class="nav-item <?= $is_contacts ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/contacts') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-mail">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Liên hệ</span>
                </a>
            </li>

            <li class="navigation-header">
                <span>Tin tức</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </li>
            <li class="nav-item <?= $is_blogs ? 'sidebar-group-active open' : '' ?>">
                <a href="<?= \Uri::create('admin/blogs') ?>" class="d-flex align-items-center" target="_self">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14,2 14,8 20,8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10,9 9,9 8,9"></polyline>
                    </svg>
                    <span class="menu-title text-truncate">Blog</span>
                </a>
            </li>

        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 849px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 396px;"></div>
        </div>
    </div>
</div>