<!-- Hero Section Begin -->
<?= View::forge('site/partials/hero-section', $data ?? array()) ?>
<!-- Hero Section End -->

<!-- About Us Section Begin -->
<?= View::forge('site/partials/section-about', $data ?? array()) ?>
<!-- About Us Section End -->

<!-- Services Section End -->
<?= View::forge('site/partials/section-service', ['amenities' => $amenities ?? []]) ?>
<!-- Services Section End -->

<!-- Home Room Section Begin -->
<?= View::forge('site/partials/home-room', ['home_rooms' => $home_rooms ?? []]) ?>
<!-- Home Room Section End -->

<!-- Home Hotel Section Begin -->
<?= View::forge('site/partials/home-hotel', ['home_hotels' => $home_hotels ?? []]) ?>
<!-- Home Hotel Section End -->

<!-- Testimonial Section Begin -->
<?= View::forge('site/partials/home-testimonial', $data ?? array()) ?>
<!-- Testimonial Section End -->

<!-- Blog Section Begin -->
<?= View::forge('site/partials/blog', ['home_blogs' => $home_blogs ?? []]) ?>
<!-- Blog Section End -->