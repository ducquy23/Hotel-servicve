<?= View::forge('site/partials/breadcrumb', isset($data) ? $data : array('breadcrumb_title' => isset($breadcrumb_title) ? $breadcrumb_title : 'Tin tức', 'breadcrumb_items' => isset($breadcrumb_items) ? $breadcrumb_items : array())) ?>
<section class="blog-section blog-page spad">
    <div class="container">
        <div class="row">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-lg-4 col-md-6">
                        <?php
                            $image = !empty($blog->featured_image) ? $blog->featured_image : \Uri::base().'assets/site/img/blog/blog-1.jpg';
                            if (!empty($blog->featured_image)) {
                                $is_absolute = preg_match('/^https?:\\/\\//', $blog->featured_image);
                                $starts_with_slash = substr($blog->featured_image, 0, 1) === '/';
                                if (!$is_absolute) {
                                    $image = \Uri::base() . ($starts_with_slash ? substr($blog->featured_image, 1) : $blog->featured_image);
                                }
                            }
                            $category = !empty($blog->category) ? $blog->category : 'News';
                            $title = htmlspecialchars($blog->title, ENT_QUOTES, 'UTF-8');
                            $published = $blog->get_published_date('d/m/Y');
                        ?>
                        <div class="blog-item set-bg" data-setbg="<?= $image ?>">
                            <div class="bi-text">
                                <span class="b-tag"><?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?></span>
                                <h4><a href="<?= \Uri::base().'new/'.(int)$blog->id ?>"><?= $title ?></a></h4>
                                <?php if ($published): ?>
                                    <div class="b-time"><i class="icon_clock_alt"></i> <?= $published ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12">
                    <p>Chưa có bài viết nào.</p>
                </div>
            <?php endif; ?>
            <?php if (!empty($total_pages) && $total_pages > 1): ?>
                <div class="col-lg-12">
                    <nav aria-label="News pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item<?= empty($has_prev) ? ' disabled' : '' ?>">
                                <a class="page-link" href="<?= !empty($has_prev) ? (\Uri::current().'?page='.(int)$prev_page) : '#' ?>" tabindex="-1" aria-disabled="<?= empty($has_prev) ? 'true' : 'false' ?>">&laquo;</a>
                            </li>
                            <?php for ($i = 1; $i <= (int)$total_pages; $i++): ?>
                                <li class="page-item<?= ($i == (int)$page) ? ' active' : '' ?>">
                                    <a class="page-link" href="<?= \Uri::current().'?page='.$i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item<?= empty($has_next) ? ' disabled' : '' ?>">
                                <a class="page-link" href="<?= !empty($has_next) ? (\Uri::current().'?page='.(int)$next_page) : '#' ?>">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
