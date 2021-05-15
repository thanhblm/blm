<?php

use api\controllers\ControllerHelper;
use common\helper\SettingHelper;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\Decorator;
use core\utils\ActionUtil;

$regions = RequestUtil::get('regions');
$regionId = RequestUtil::get("regionId");
$seoInfoVo = RequestUtil::get("seoInfoVo");
//renderLayout
$pageVo = RequestUtil::get('pageVo');
$templateVo = RequestUtil::get('templateVo');
$languageCode = RequestUtil::get('languageCode');
$template = RequestUtil::get('template');
$languages = RequestUtil::get('languages');
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie6"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie7"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie8"> <![endif]-->
<!--[if IE 9 ]>
<html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en"><!--<![endif]-->
<html>
<head>
    <?php
    foreach ($languages as $lang) {
        ?>
        <link rel="alternate" hreflang="<?= $lang->localeName ?>"
              href="<?= RouteUtil::getRoute()->getWebRoot() . "/" . $lang->code . "/" . ControllerHelper::getRequestActionPath() ?>">
        <?php
    }
    ?>
    <title>
        <?php
        if (isset($seoInfoVo) && $seoInfoVo != null && !AppUtil::isEmptyString($seoInfoVo->title)) {
            echo $seoInfoVo->title;
        } else {
            echo SettingHelper::getSettingValue("Name");
        }
        ?>
    </title>
    <link rel="canonical" href="<?= AppUtil::getFullUrl() ?>">
    <meta property="og:title"
          content="<?= isset($seoInfoVo) && $seoInfoVo != null && !AppUtil::isEmptyString($seoInfoVo->title) ? $seoInfoVo->title : SettingHelper::getSettingValue("Name") ?>">
    <meta name="keywords" content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->keywords : "" ?>">
    <meta name="description" content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->description : "" ?>">
    <meta property="og:description"
          content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->description : "" ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ETOVIET">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Standard Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= AppUtil::resource_url("layouts/blm/images/favicon.ico") ?>"/>

    <!-- For iPhone 4 Retina display: -->
    <link rel="apple-touch-icon-precomposed"
          href="<?= AppUtil::resource_url("layouts/blm/images/apple-touch-icon-114x114-precomposed.png") ?>">

    <!-- For iPad: -->
    <link rel="apple-touch-icon-precomposed"
          href="<?= AppUtil::resource_url("layouts/blm/images/apple-touch-icon-72x72-precomposed.png") ?>">

    <!-- For iPhone: -->
    <link rel="apple-touch-icon-precomposed"
          href="<?= AppUtil::resource_url("layouts/blm/images/apple-touch-icon-57x57-precomposed.png") ?>">

    <!-- Library - Google Font Familys -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css"
          href="<?= AppUtil::resource_url("layouts/blm/revolution/css/settings.css") ?>">
    <!-- Library -->
    <link href="<?= AppUtil::resource_url("layouts/blm/css/lib.css") ?>" rel="stylesheet">

    <!-- Custom - Common CSS -->
    <link rel="stylesheet" href="<?= AppUtil::resource_url("layouts/blm/css/rtl.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("layouts/blm/css/style.css") ?>">

    <!--[if lt IE 9]>
    <script src="<?= AppUtil::resource_url("layouts/blm/js/html5/respond.min.js") ?>"></script>
    <![endif]-->
    <script type="text/javascript" src="<?= AppUtil::resource_url("global/plugins/jquery.min.js") ?>"></script>
</head>
<body data-offset="200" data-spy="scroll" data-target=".ownavigation">

<!-- end push menu-->
<?php include 'includes/frontend-header.php'; ?>
<div class="main-container">
    <?php include Decorator::getBodyPath() ?>
</div>
<!--FOOTER-->
<?php include "includes/frontend-footer.php" ?>
<!--END FOOTER-->
<script type="text/javascript">
    var urlShoppingCartUpdate = "<?=ActionUtil::getFullPathAlias("home/cart/item/cart/update") ?>?rtype=json";
    var urlReloadCart = "<?=ActionUtil::getFullPathAlias("home/cart/reload") ?>?rtype=json";
    var urlCheckoutItemRemove = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/update") ?>?rtype=json";
</script>
<!-- JQuery v1.12.4 -->
<script src="<?= AppUtil::resource_url("layouts/blm/js/jquery-1.12.4.min.js") ?>"></script>

<!-- Library - Js -->
<script src="<?= AppUtil::resource_url("layouts/blm/js/popper.min.js") ?>"></script>
<script src="<?= AppUtil::resource_url("layouts/blm/js/lib.js") ?>"></script>

<!-- REVOLUTION JS FILES -->
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/jquery.themepunch.tools.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/jquery.themepunch.revolution.min.js") ?>"></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.actions.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.carousel.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.kenburn.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.layeranimation.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.migration.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.navigation.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.parallax.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.slideanims.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("layouts/blm/revolution/js/extensions/revolution.extension.video.min.js") ?>"></script>

<!-- Library - Theme JS -->
<script src="<?= AppUtil::resource_url("layouts/blm/js/functions.js") ?>"></script>
<script type="text/javascript" async
        src="<?= AppUtil::resource_url("global/plugins/jquery.blockui.min.js") ?>"></script>
<script type="text/javascript" async
        src="<?= AppUtil::resource_url("global/plugins/bootstrap-sweetalert/sweetalert.min.js") ?>"></script>
<script type="text/javascript" async
        src="<?= AppUtil::resource_url("global/plugins/bootstrap-toastr/toastr.min.js") ?>"></script>
<script type="text/javascript"
        src="<?= AppUtil::resource_url("global/plugins/jquery-slimscroll/jquery.slimscroll.min.js") ?>"></script>
<script type="text/javascript" src="<?= AppUtil::resource_url("global/js/app.js") ?>"></script>
<script type="text/javascript" async src="<?= AppUtil::resource_url("global/js/plugin.init.js") ?>"></script>
<script type="text/javascript" src="<?= AppUtil::resource_url("global/js/dato.common.js") ?>"></script>
<script type="text/javascript">
    function changeLanguage(lang) {
        var url = "<?=ActionUtil::getFullPathAlias("language/change")?>?rtype=json";
        var data =
            {
                "langCode": lang,
                "url": window.location.href
            };
        simpleAjaxPost(guid(), url, data, onChangeLanguageSuccess);
    }

    function onChangeLanguageSuccess(res) {
        window.location.href = res.extra.url;
    }
</script>
</body>
</html>