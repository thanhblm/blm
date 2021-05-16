<?php
use common\helper\LayoutHelper;
use common\helper\SettingHelper;
use common\persistence\base\vo\ContainerVo;
use common\services\layout\ContainerService;
use common\template\extend\ModalTemplate;
use common\utils\RenderUtil;
use core\config\ApplicationConfig;
use core\Decorator;
use core\Lang;
use core\utils\AppUtil;
use core\utils\ActionUtil;
use core\utils\RouteUtil;
use core\utils\SessionUtil;
use core\utils\RequestUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;

$regions = RequestUtil::get('regions');
$regionId = RequestUtil::get("regionId");
$seoInfoVo = RequestUtil::get("seoInfoVo");
//renderLayout
$pageVo = RequestUtil::get('pageVo');
$templateVo = RequestUtil::get('templateVo');
$languageCode = RequestUtil::get('languageCode');
$template = RequestUtil::get('template');
$containerService = new ContainerService();
$languages = RequestUtil::get('languages');
?>
    <!DOCTYPE html>
    <html lang="en" style=""
          class="webkit chrome chrome56 win js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths orientation_landscape maxw_1440">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="canonical" href="<?= AppUtil::getFullUrl() ?>">
		<?php
		foreach ($languages as $lang) {
			?>
            <link rel="alternate" hreflang="<?= $lang->localeName ?>" href="<?= RouteUtil::getRoute()->getWebRoot() . "/" . $lang->code . "/" . ControllerHelper::getRequestActionPath() ?>">
			<?php
		}
		?>
        <style type="text/css">
            .cf-hidden {
                display: none;
            }

            .cf-invisible {
                visibility: hidden;
            }
        </style>
        <title>
			<?php
			if (isset($seoInfoVo) && $seoInfoVo != null && !AppUtil::isEmptyString($seoInfoVo->title)) {
				echo $seoInfoVo->title;
			} else {
				echo SettingHelper::getSettingValue("Name");
			}
			?>
        </title>
        <meta property="og:title" content="<?= isset($seoInfoVo) && $seoInfoVo != null && !AppUtil::isEmptyString($seoInfoVo->title) ? $seoInfoVo->title : SettingHelper::getSettingValue("Name") ?>">
        <meta name="keywords" content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->keywords : "" ?>">
        <meta name="description" content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->description : "" ?>">
        <meta property="og:description" content="<?= isset($seoInfoVo) && $seoInfoVo != null ? $seoInfoVo->description : "" ?>">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Endoca">
        <link rel="icon" type="image/png" href="<?= AppUtil::resource_url("layouts/blm/images/icon.png") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("layouts/blm/css/stylesheet.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("layouts/blm/css/dato.common.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("layouts/blm/css/custom/dato.custom.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("global/plugins/bootstrap-sweetalert/sweetalert.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("global/plugins/bootstrap-toastr/toastr.css") ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("global/plugins/jquery-ui/jquery-ui.min.css") ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("layouts/blm/css/style.css") ?>">

        <script type="text/javascript" src="<?= AppUtil::resource_url("global/plugins/jquery.min.js") ?>"></script>
        <script type="text/javascript" src="<?= AppUtil::resource_url("global/plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
        <script type="text/javascript" src="<?= AppUtil::resource_url("layouts/blm/js/template.js") ?>"></script>
        <script type="text/javascript" async src="<?= AppUtil::resource_url("layouts/blm/js/animation.js") ?>"></script>
        <script type="text/javascript" async src="<?= AppUtil::resource_url("global/plugins/jquery.blockui.min.js") ?>"></script>
        <script type="text/javascript" async src="<?= AppUtil::resource_url("global/plugins/bootstrap-sweetalert/sweetalert.min.js") ?>"></script>
        <script type="text/javascript" async src="<?= AppUtil::resource_url("global/plugins/bootstrap-toastr/toastr.min.js") ?>"></script>
        <script type="text/javascript" src="<?= AppUtil::resource_url("global/plugins/jquery-slimscroll/jquery.slimscroll.min.js") ?>"></script>

        <script type="text/javascript" src="<?= AppUtil::resource_url("global/js/app.js") ?>"></script>
        <script type="text/javascript" async src="<?= AppUtil::resource_url("global/js/plugin.init.js") ?>"></script>
        <script type="text/javascript" src="<?= AppUtil::resource_url("global/js/dato.common.js") ?>"></script>
        <style type="text/css">
            .fancybox-margin {
                margin-right: 17px;
            }
        </style>

        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("global/css/dato.layout.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?= AppUtil::resource_url("global/css/dato.common.css") ?>">
    </head>

    <body class="_home __homepage">
    <div class="wrapper jas-wrapper-fix">
		<?php include 'includes/frontend-header.php'; ?>
	
        <div class="cb"></div>

		<?php include Decorator::getBodyPath() ?>
        <div class="cb"></div>
    </div>
    <div class="cb"></div>
	<?php include 'includes/frontend-footer.php'; ?>
    <div class="cb"></div>
    </body>
    <script type="text/javascript">
		var urlShoppingCartUpdate = "<?=ActionUtil::getFullPathAlias("home/cart/item/cart/update") ?>?rtype=json";
		var urlReloadCart = "<?=ActionUtil::getFullPathAlias("home/cart/reload") ?>?rtype=json";
		var urlCheckoutItemRemove = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/update") ?>?rtype=json";
		$(document).ready(function(){
			$(".viewport").slimScroll({
				height: 'auto',
				alwaysVisible: true,
				color: '#81ad00',
				railOpacity: 1
			});
		});
		uuid = guid();
		divLoginId = "#login";
		modalLoginDiaglogId = "#modalLoginDialog";
		modalLogoutDiaglogId = "#modalLogoutDialog";

		formLogoutId = "#formLogoutId";
		formLoginId = "#formLoginId";

		btnLoginSubmit = "#btnLoginSubmit";
		btnLogoutSubmit = "#btnLogoutSubmit";

		gUrlLogin = "<?=ActionUtil::getFullPathAlias("home/login/view") ?>" + "?rtype=json";
		pUrlLogin = "<?=ActionUtil::getFullPathAlias("home/login") ?>" + "?rtype=json";
		gUrlLogout = "<?=ActionUtil::getFullPathAlias("home/logout/view") ?>" + "?rtype=json";
		pUrlLogout = "<?=ActionUtil::getFullPathAlias("home/logout") ?>" + "?rtype=json";

		function loginSuccess(modalLoginDiaglogId, btnLoginSubmit, res){
			showMessage("<?=Lang::get("Login successfully") ?>");
			$(modalLoginDiaglogId).modal("toggle");
			if (res.extra.isChangeLanguage) {
				changeLanguage(res.extra.languageCode);
			} else {
				location.reload();
			}
		}
		function loginError(modalLoginDiaglogId, btnLoginSubmit, res){
			$(divLoginId).html(res.content);
		}
		function logoutSuccess(modalLogoutDiaglogId, btnLogoutSubmit, res){
			showMessage("<?=Lang::get("Logout successfully!") ?>");
			$(modalLogoutDiaglogId).modal("toggle");
			<?php
			if (SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME) != null) {
				if (SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->isSaleRepChild == true) {
					echo "location.href = \"" . ActionUtil::getFullPathAlias('customer/salesrep') . "\";";
				} else {
					echo "location.reload();";
				}
			} else {
				echo "location.reload();";
			}
			?>

		}
		function showProfileDialog(){
			window.location.href = '<?=ActionUtil::getFullPathAlias("customer/detail") ?>';
		}
		function showLoginDialog(tabId){
			var dataTabId = typeof (tabId) !== "undefined" ? "&activeTab=" + tabId : "";
			simpleCUDModal(
				modalLoginDiaglogId,
				formLoginId,
				uuid,
				btnLoginSubmit,
				gUrlLogin + dataTabId,
				pUrlLogin,
				loginSuccess,
				loginError,
				loginError
			)
		}
		function showLogoutDialog(){
			simpleCUDModal(
				modalLogoutDiaglogId,
				formLogoutId,
				uuid,
				btnLogoutSubmit,
				gUrlLogout,
				pUrlLogout,
				logoutSuccess
			);
		}
    </script>
    <script data-cfasync="false" type="text/javascript" src="<?= AppUtil::resource_url("global/js/dato.cart.js") ?>"></script>
    </html>
