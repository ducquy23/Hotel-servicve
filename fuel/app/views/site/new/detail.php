<?= View::forge('site/partials/breadcrumb', isset($data) ? $data : array('breadcrumb_title' => isset($breadcrumb_title) ? $breadcrumb_title : 'Tin tức', 'breadcrumb_items' => isset($breadcrumb_items) ? $breadcrumb_items : array())) ?>
<section class="blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-text">
                    <div class="bd-title">
                        <h2><?= htmlspecialchars($blog->title, ENT_QUOTES, 'UTF-8') ?></h2>
                        <?php if ($blog->get_published_date()): ?>
                            <span class="b-time"><i class="icon_clock_alt"></i> <?= $blog->get_published_date('d/m/Y') ?></span>
                        <?php endif; ?>
                    </div>
                    <?php
                        $detail_image = '';
                        if (!empty($blog->featured_image)) {
                            $is_absolute = preg_match('/^https?:\\/\\//', $blog->featured_image);
                            $starts_with_slash = substr($blog->featured_image, 0, 1) === '/';
                            $detail_image = $is_absolute ? $blog->featured_image : (\Uri::base() . ($starts_with_slash ? substr($blog->featured_image, 1) : $blog->featured_image));
                        }
                        if (empty($detail_image)) {
                            $detail_image = \Uri::base().'assets/site/img/blog/blog-1.jpg';
                        }
                    ?>
                    <div class="bd-pic">
                        <img class="img-fluid" src="<?= $detail_image ?>" alt="<?= htmlspecialchars($blog->title, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="bd-more-text">
                        <?= $blog->content ?>
                    </div>
                </div>

                <?php if (!empty($related)): ?>
                <div class="related-post">
                    <h4>Bài viết liên quan</h4>
                    <div class="row">
                        <?php foreach ($related as $r): ?>
                            <div class="col-lg-4 col-md-6">
                                <?php
                                    $image = !empty($r->featured_image) ? $r->featured_image : \Uri::base().'assets/site/img/blog/blog-1.jpg';
                                    if (!empty($r->featured_image)) {
                                        $is_absolute = preg_match('/^https?:\\/\\//', $r->featured_image);
                                        $starts_with_slash = substr($r->featured_image, 0, 1) === '/';
                                        if (!$is_absolute) {
                                            $image = \Uri::base() . ($starts_with_slash ? substr($r->featured_image, 1) : $r->featured_image);
                                        }
                                    }
                                ?>
                                <div class="blog-item set-bg" data-setbg="<?= $image ?>">
                                    <div class="bi-text">
                                        <h5><a href="<?= \Uri::base().'new/'.(int)$r->id ?>"><?= htmlspecialchars($r->title, ENT_QUOTES, 'UTF-8') ?></a></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <div class="bs-item">
                        <h4>Danh mục</h4>
                        <ul>
                            <?php foreach (Model_Blog::get_category_options() as $key => $label): ?>
                                <li><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

