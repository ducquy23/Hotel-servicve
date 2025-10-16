<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sona | Template</title>
    <?= View::forge('site/partials/styles', $data ?? array()) ?>
</head>

<body>
<!-- Header Section Begin -->
<?php
$global_menu_data = Func_Menu::get_global_menu_data();
$header_data = array_merge($data ?? array(), $global_menu_data);
?>
<?= View::forge('site/partials/header', $header_data) ?>
<!-- Header End -->


<?= isset($content) ? $content : ''; ?>

<!-- Footer Section Begin -->
<?= View::forge('site/partials/footer', $data ?? array()) ?>
<!-- Footer Section End -->
<?= View::forge('site/partials/search-model', $data ?? array()) ?>
<!-- Search model Begin -->

<!-- Search model end -->
<?= View::forge('site/partials/scripts', $data ?? array()) ?>

</body>

</html>