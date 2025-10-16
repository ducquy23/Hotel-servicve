<html class="loaded" lang="en" data-textdirection="ltr" style="--vh: 9.11px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="Ihk1VneSChgyKhICB89gu9VPtggrFEWnx7uchNN3">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Dashboard Ecommerce</title>
    <link rel="apple-touch-icon" href="<?= \Uri::base() ?>assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= \Uri::base() ?>assets/images/logo/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= \Uri::base() ?>assets/css/custom.css" rel="stylesheet">
    <?php if (!empty($page_styles)): foreach ($page_styles as $href): ?>
        <link rel="stylesheet" href="<?= \Uri::base() . $href ?>">
    <?php endforeach; endif; ?>
    <?= View::forge('admin/partials/styles', $data ?? array()) ?>
</head>
<body class="pace-done vertical-layout vertical-menu-modern navbar-floating footer-static default menu-expanded"
      data-open="click" data-menu="vertical-menu-modern" data-col="default" data-framework="laravel"
      data-asset-path="<?= \Uri::base() ?>">
<!-- BEGIN: Header-->
<?= View::forge('admin/partials/navbar', $data ?? array()) ?>
<!-- BEGIN: Main Menu-->
<?= View::forge('admin/partials/sidebar', $data ?? array()) ?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="container-xxl py-2">
        <?= isset($content) ? $content : ''; ?>
    </div>
</div>
<!-- BEGIN: Footer-->
<?= View::forge('admin/partials/footer', $data ?? array()) ?>
<!-- BEGIN: Vendor JS-->
<?= View::forge('admin/partials/scripts', $data ?? array()) ?>
<?php if (!empty($page_scripts)): foreach ($page_scripts as $src): ?>
<script src="<?= \Uri::base() . $src ?>"></script>
<?php endforeach; endif; ?>
<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14, height: 14
            });
        }
    })
</script>
</body>
</html>