<section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Tiện ích khách sạn</span>
                    <h2>Khám phá các tiện ích của chúng tôi</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($amenities)): ?>
                <?php foreach ($amenities as $amenity): ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="service-item">
                            <?php if (!empty($amenity['icon']) && strpos($amenity['icon'], 'assets/img/icon-figma/') === 0): ?>
                                <img src="<?= \Uri::base() . htmlspecialchars($amenity['icon']) ?>"
                                     alt="icon"
                                     style="width:24px;height:24px;object-fit:contain;border-radius:50%;background:#f3f3f3;">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                            <h4><?php echo $amenity['name']; ?></h4>
                            <p><?php echo $amenity['description']; ?></p>
                            <div class="amenity-info">
                                <div class="amenity-category">
                                    <?php 
                                    $category_names = array(
                                        'general' => 'Chung',
                                        'room' => 'Phòng',
                                        'facility' => 'Tiện ích',
                                        'service' => 'Dịch vụ'
                                    );
                                    $category_name = isset($category_names[$amenity['category']]) ? $category_names[$amenity['category']] : ucfirst($amenity['category']);
                                    ?>
                                    <span class="badge badge-info"><?php echo $category_name; ?></span>
                                </div>
                                <?php if (!empty($amenity['price']) && $amenity['price'] > 0): ?>
                                    <div class="amenity-price">
                                        <span class="price"><?php echo number_format($amenity['price'], 0, ',', '.'); ?> VNĐ</span>
                                    </div>
                                <?php else: ?>
                                    <div class="amenity-price">
                                        <span class="price free">Miễn phí</span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($amenity['operating_hours'])): ?>
                                    <div class="amenity-hours">
                                        <small class="text-muted">
                                            <i class="fa fa-clock"></i> <?php echo htmlspecialchars($amenity['operating_hours']); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12">
                    <div class="text-center">
                        <p>Chưa có tiện ích nào được cung cấp.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>