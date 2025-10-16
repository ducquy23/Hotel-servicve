<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2><?= isset($breadcrumb_title) ? $breadcrumb_title : 'About Us' ?></h2>
                    <div class="bt-option">
                        <?php
                        $items = isset($breadcrumb_items) ? $breadcrumb_items : array(
                            array('label' => 'Home', 'url' => \Uri::base()),
                            array('label' => isset($breadcrumb_title) ? $breadcrumb_title : 'About Us'),
                        );
                        $last_index = count($items) - 1;
                        foreach ($items as $index => $item):
                            if ($index !== $last_index && isset($item['url'])): ?>
                                <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
                            <?php else: ?>
                                <span><?= $item['label'] ?></span>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>