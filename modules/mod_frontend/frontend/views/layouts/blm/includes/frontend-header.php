<?php

use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use core\config\ModuleConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\utils\SessionUtil;

$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) ['VIEW_PATH'] . DS . "endoca" . DS;
$countOrderProduct = 0;
if (!empty (SessionUtil::get("listOrderProduct"))) {
	$countOrderProduct = count(SessionUtil::get("listOrderProduct")->getArray());
}
$region = RequestUtil::get('region');
?>
<header class="navbar navbar-static-top bs-docs-nav">
	<div id="stickyNavigationContainer" class="responsive-parent nav-header navigationIndex">
		<div class="navigation-white"></div>
		<div class="container" style="padding-left: 0; padding-right: 0;">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" id="responsive-btn">
					<span class="sr-only"><?= Lang::get('Toggle navigation') ?></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button>
				
				<a class="navbar-brand" href="<?= ActionUtil::getFullPathAlias("/", new AliasUrlFriendly("")) ?>"><span class="sprite logo"></span></a>
			</div>
			<?php include 'frontend-menu.php'; ?>
		</div>
	</div>
</header>

<div id="header-content"></div>