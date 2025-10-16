<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Hotel News</span>
                    <h2>Our Blog & Event</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($home_blogs)): ?>
                <?php foreach ($home_blogs as $index => $blog): ?>
                    <?php if ($index < 6): ?>
                        <div class="col-lg-4">
                            <div class="blog-item set-bg"
                                 data-setbg="<?= htmlspecialchars($blog['featured_image'] ?: (\Uri::base() . 'assets/site/img/blog/blog-1.jpg')) ?>">
                                <div class="bi-text">
                                    <span class="b-tag">News</span>
                                    <h4>
                                        <a href="<?= \Uri::create('new/' . (int)$blog['id']) ?>"><?= htmlspecialchars($blog['title']) ?></a>
                                    </h4>
                                    <div class="b-time"><i
                                                class="icon_clock_alt"></i> <?= date('d/m/Y', strtotime($blog['published_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">Chưa có bài viết.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>