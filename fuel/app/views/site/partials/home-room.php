<section class="hp-room-section">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Phòng nghỉ</span>
                        <h2>Không gian lưu trú đẳng cấp</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="hp-room-items">
            <div class="row">
                <?php if (!empty($home_rooms)): ?>
                    <?php foreach ($home_rooms as $room): ?>
                        <?php
                        $image = $room['image_url'] ?? '';
                        if (!$image) {
                            $image = \Asset::get_file('images/rooms/default.jpg', 'img');
                        }
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="hp-room-item set-bg" data-setbg="<?= htmlspecialchars($image) ?>">
                                <div class="hr-text">
                                    <h3><?= $room['name'] ?></h3>
                                    <h2><?= number_format((float)$room['price'], 0, ',', '.') ?><span>/đêm</span></h2>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="r-o">Khách sạn:</td>
                                            <td><?= $room['hotel_name'] ?? '' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td><?= htmlspecialchars($room['size'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td><?= (int)($room['capacity'] ?? 0) ?> người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td><?= htmlspecialchars($room['bed_type'] ?? '-') ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <a href="<?= \Uri::create('room/' . (int)$room['id']) ?>" class="primary-btn">More
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Chưa có phòng khả dụng.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>