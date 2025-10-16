<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Section Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="canvas-open">
    <i class="icon_menu"></i>
</div>
<div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
        <i class="icon_close"></i>
    </div>
    <div class="search-icon  search-switch">
        <i class="icon_search"></i>
    </div>
    <div class="header-configure-area">
        <div class="language-option">
            <img src="<?= \Uri::base() ?>assets/site/img/flag.jpg" alt="">
            <span>EN <i class="fa fa-angle-down"></i></span>
            <div class="flag-dropdown">
                <ul>
                    <li><a href="#">Zi</a></li>
                    <li><a href="#">Fr</a></li>
                </ul>
            </div>
        </div>
        <a href="#" class="bk-btn">Booking Now</a>
    </div>
    <nav class="mainmenu mobile-menu">
        <ul>
            <li class="<?= Uri::string() == '' ? 'active' : '' ?>">
                <a href="<?= Uri::create('/') ?>">Trang chủ</a>
            </li>
            <?php if (!empty($menu_categories)): ?>
                <li><a href="#">Khách sạn</a>
                    <ul class="dropdown">
                        <?php foreach ($menu_categories as $category): ?>
                            <li><a href="<?= Uri::create('category/' . $category['id']) ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="<?= Uri::create('hotels') ?>">Tất cả khách sạn</a></li>
                        <li><a href="<?= Uri::create('hotels/featured') ?>">Khách sạn nổi bật</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <li><a href="#">Phòng</a>
                <ul class="dropdown">
                        <li><a href="<?php echo Uri::create('room') ?>">Tất cả phòng</a></li>
                        <li><a href="<?php echo Uri::create('room/featured') ?>">Phòng nổi bật</a></li>
                    <?php 
                    $room_types = Model_Room::get_room_type_options();
                    foreach ($room_types as $type_key => $type_label):
                    ?>
                        <li>
                            <a href="<?php echo Uri::create('room/type/' . $type_key) ?>"><?php echo htmlspecialchars($type_label, ENT_QUOTES, 'UTF-8'); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="<?= Uri::string() == 'about-us' ? 'active' : '' ?>">
                <a href="<?= Uri::create('about-us') ?>">Giới thiệu</a>
            </li>
            <li class="<?= Uri::string() == 'new' ? 'active' : '' ?>">
                <a href="<?= Uri::create('new') ?>">Tin tức</a>
            </li>
            <li class="<?= Uri::string() == 'contact' ? 'active' : '' ?>">
                <a href="<?= Uri::create('contact') ?>">Liên hệ</a>
            </li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="top-social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-tripadvisor"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
    <ul class="top-widget">
        <li><i class="fa fa-phone"></i> (12) 345 67890</li>
        <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
    </ul>
</div>

<!-- Offcanvas Menu Section End -->
<header class="header-section">
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tn-left">
                        <li><i class="fa fa-phone"></i> (12) 345 67890</li>
                        <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="tn-right">
                        <div class="top-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                        <a href="#" class="bk-btn">Booking Now</a>
                        <div class="language-option">
                            <img src="<?= \Uri::base() ?>assets/site/img/flag.jpg" alt="">
                            <span>EN <i class="fa fa-angle-down"></i></span>
                            <div class="flag-dropdown">
                                <ul>
                                    <li><a href="#">Zi</a></li>
                                    <li><a href="#">Fr</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="<?= Uri::create('/') ?>">
                            <img src="<?= \Uri::base() ?>assets/site/img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <nav class="mainmenu">
                            <ul>
                                <li class="<?= Uri::string() == '' ? 'active' : '' ?>">
                                    <a href="<?= Uri::create('/') ?>">Trang chủ</a>
                                </li>
                                <?php if (!empty($menu_categories)): ?>
                                    <li><a href="#">Khách sạn</a>
                                        <ul class="dropdown">
                                        <li><a href="<?= Uri::create('hotels') ?>">All hotels</a></li>
                                        <li><a href="<?= Uri::create('hotels/featured') ?>">Featured hotels</a></li>
                                            <?php foreach ($menu_categories as $category): ?>
                                                <li><a href="<?= Uri::create('category/' . $category['id']) ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <li><a href="#">Phòng</a>
                                    <ul class="dropdown">
                                            <li><a href="<?php echo Uri::create('room') ?>">Tất cả phòng</a></li>
                                            <li><a href="<?php echo Uri::create('room/featured') ?>">Phòng nổi bật</a></li>
                                        <?php 
                                        $room_types = Model_Room::get_room_type_options();
                                        foreach ($room_types as $type_key => $type_label):
                                        ?>
                                            <li>
                                                <a href="<?php echo Uri::create('room/type/' . $type_key) ?>"><?php echo htmlspecialchars($type_label, ENT_QUOTES, 'UTF-8'); ?></a>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </li>
                                <li class="<?= Uri::string() == 'about-us' ? 'active' : '' ?>">
                                    <a href="<?= Uri::create('about-us') ?>">Giới thiệu</a>
                                </li>
                                <li class="<?= Uri::string() == 'new' ? 'active' : '' ?>">
                                    <a href="<?= Uri::create('new') ?>">Tin tức</a>
                                </li>
                                <li class="<?= Uri::string() == 'contact' ? 'active' : '' ?>">
                                    <a href="<?= Uri::create('contact') ?>">Liên hệ</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="nav-right search-switch">
                            <i class="icon_search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>