<?php echo \View::forge('site/partials/breadcrumb', array(
        'breadcrumb_title' => $breadcrumb_title ?? 'Phòng',
        'breadcrumb_items' => $breadcrumb_items ?? array(),
)); ?>
<section class="rooms-section spad">
    <div class="container">
        <div class="row">
            <?php if (!empty($rooms) && count($rooms) > 0): ?>
                <?php foreach ($rooms as $room): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            <?php
                            $image = $room['image_url'] ?? '';
                            if (!$image) {
                                $image = \Asset::get_file('images/rooms/default.jpg', 'img');
                            }
                            ?>
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($room['name']) ?>">
                            <div class="ri-text">
                                <h4><?= htmlspecialchars($room['name']) ?></h4>
                                <h3><?= number_format((float)$room['price'], 0, ',', '.') ?><span>/Pernight</span></h3>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="r-o">Khách sạn: </td>
                                        <td><?= htmlspecialchars($room['hotel_name'] ?? '') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td><?= (int)($room['capacity'] ?? 0) ?> người</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Giường:</td>
                                        <td><?= htmlspecialchars($room['bed_type'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Loại phòng:</td>
                                        <td><?= htmlspecialchars($room['room_type'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td><?= htmlspecialchars($room['size'] ?? '-') ?></td>
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
                    <div class="alert alert-info">Chưa có phòng nào.</div>
                </div>
            <?php endif; ?>
            <div class="col-lg-12">
                <div class="room-pagination">
                    <?php if (($total_pages ?? 0) > 1): ?>
                        <nav aria-label="Room pagination" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php if (!empty($has_prev) && !empty($prev_page)): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?= \Uri::create('room', array('page' => (int)$prev_page)) ?>"
                                           aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= (int)$total_pages; $i++): ?>
                                    <li class="page-item <?= ($i === (int)$page) ? 'active' : '' ?>">
                                        <a class="page-link"
                                           href="<?= \Uri::create('room', array('page' => $i)) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if (!empty($has_next) && !empty($next_page)): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?= \Uri::create('room', array('page' => (int)$next_page)) ?>"
                                           aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


