<?php
// build menu
use common\services\backend_menu\BackendMenuService;
use common\utils\RenderUtil;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\utils\RouteUtil;
use core\utils\SessionUtil;

$backendMenuService = new BackendMenuService ();
$backendMenuList = SessionUtil::get ( ApplicationConfig::get ( "session.user.login.name" ) )->backendMenuList;
$viewPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['VIEW_PATH'];
?>
<div class="backend_menu">
	<div class="hor-menu">
		<?php
		if (! empty ( $backendMenuList )) {
			$template = $viewPath . '/layouts/default/includes/backend_menu_item_data.php';
			$params = array (
					'class' => array (
							'nav navbar-nav',
							'dropdown-menu pull-left',
							'dropdown-menu pull-left',
							'dropdown-menu pull-left' 
					) 
			);
			RenderUtil::recursive ( $backendMenuList, 0, 0, 0, true, $template, $params );
		}
		?>
	</div>
</div>
<div class="clear"></div>