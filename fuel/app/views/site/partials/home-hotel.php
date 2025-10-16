<section class="hp-hotel-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title mt-5">
                    <span>Điểm dừng chân</span>
                    <h2>Hệ thống khách sạn đẳng cấp</h2>
                </div>
            </div>
        </div>
        <div class="hp-room-items">
            <div class="row">
                <?php if (!empty($home_hotels)): ?>
                    <?php foreach ($home_hotels as $hotel): ?>
                        <?php
                        $image_path = $hotel['image_path'] ?? '';
                        if (!$image_path) {
                            $image_path = \Asset::get_file('images/hotels/default.jpg', 'img');
                        }
                        $is_absolute = (strpos($image_path, 'http://') === 0) || (strpos($image_path, 'https://') === 0);
                        $bg_url = $is_absolute ? $image_path : (\Uri::base() . ltrim($image_path, '/'));
                        $star = (int)($hotel['star_rating'] ?? 0);
                        $rating = (float)($hotel['rating'] ?? 0);
                        ?>
                        <div class="col-lg-3 col-md-6 mt-5 mb-5">
                            <div class="hp-room-item set-bg" data-setbg="<?php echo htmlspecialchars($bg_url, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="hr-text">
                                    <h3><?php echo $hotel['name'] ?? ''; ?></h3>
                                    <div class="hotel-info">
                                        <div class="hotel-rating mb-2">
                                            <span class="stars" style="color: #ffd700; font-size: 16px;"><?php echo str_repeat('★', max(0, min(5, $star))); ?><?php echo str_repeat('☆', max(0, 5 - max(0, min(5, $star)))); ?></span>
                                            <span class="rating-score" style="color: #fff; margin-left: 8px; font-weight: bold;"><?php echo number_format($rating, 1); ?>/5</span>
                                        </div>
                                        <?php if (!empty($hotel['description'])): ?>
                                            <p class="hotel-description"><?php echo mb_strimwidth($hotel['description'], 0, 100, '...', 'UTF-8'); ?></p>
                                        <?php endif; ?>
                                        <table class="hotel-details">
                                            <tbody>
                                                <tr>
                                                    <td class="r-o">Địa chỉ:</td>
                                                    <td><?php echo mb_strimwidth($hotel['address'] ?? 'Chưa cập nhật', 0, 30, '...', 'UTF-8'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="r-o">Hạng sao:</td>
                                                    <td><?php echo $star; ?> sao</td>
                                                </tr>
                                                <tr>
                                                    <td class="r-o">Đánh giá:</td>
                                                    <td><?php echo number_format($rating, 1); ?>/5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="<?php echo \Uri::create('hotels'); ?>" class="primary-btn">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Chưa có khách sạn khả dụng.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


