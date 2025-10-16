<!DOCTYPE html>
<html class="loading " lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Login Page</title>
    <link rel="apple-touch-icon" href="<?= \Uri::base() ?>assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= \Uri::base() ?>assets/images/logo/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/core.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/dark-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/bordered-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/semi-dark-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/core/menu/menu-types/vertical-menu.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/plugins/forms/form-validation.css">
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/pages/authentication.css">
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/overrides.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/vendors/css/extensions/toastr.min.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/core.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/dark-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/bordered-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/themes/semi-dark-layout.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/core/menu/menu-types/vertical-menu.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/plugins/forms/form-validation.css">
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/base/pages/authentication.css">
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/overrides.css" />
    <link rel="stylesheet" href="<?= \Uri::base() ?>assets/css/style.css" />
</head>
<body class="vertical-layout vertical-menu-modern   blank-page blank-page"
      data-menu="vertical-menu-modern"
      data-col="blank-page"
      data-framework="laravel"
      data-asset-path="">

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <div class="content-wrapper">
        <div class="content-body">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
    </div>
</div>
<script src="<?= \Uri::base() ?>assets/vendors/js/vendors.min.js"></script>
<script src="<?= \Uri::base() ?>assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="<?= \Uri::base() ?>assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/app-menu.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/app.js"></script>
<script src="<?= \Uri::base() ?>assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?= \Uri::base() ?>assets/js/scripts/extensions/ext-component-toastr.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/scripts.js"></script>
<script src="<?= \Uri::base() ?>assets/js/scripts/pages/auth-login.js"></script>

<script type="text/javascript">
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
    <?php $__flash_success = \Fuel\Core\Session::get_flash('success'); ?>
    <?php $__flash_error = \Fuel\Core\Session::get_flash('error'); ?>
    <?php if ($__flash_success): ?>
    toastr.success(<?= json_encode($__flash_success) ?>);
    <?php endif; ?>
    <?php if ($__flash_error): ?>
    toastr.error(<?= json_encode($__flash_error) ?>);
    <?php endif; ?>
</script>

</body>

</html>
