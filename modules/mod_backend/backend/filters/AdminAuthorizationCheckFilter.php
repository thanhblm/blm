<?php

namespace backend\filters;

use common\helper\PermissionHelper;
use core\config\ApplicationConfig;
use core\filters\Filter;
use core\utils\ActionUtil;
use core\utils\RouteUtil;

class AdminAuthorizationCheckFilter implements Filter {
	public function init($filterConfig) {
	}
	public function doFilter($filterChain) {
		$actionPath = RouteUtil::getRoute ()->getPath ();
		\DatoLogUtil::info ( "Entering Admin authorization |actionPath: " . $actionPath );
		$hasPermission = PermissionHelper::hasAdminPermission ( $actionPath );
		if ($hasPermission) {
			$filterChain->doFilter ();
			return;
		} else {
			if (! PermissionHelper::checkAdminUserLogin ()) {
				$rtype = isset ( $_REQUEST ['rtype'] ) ? $_REQUEST ['rtype'] : "";
				$newUri = "admin/access/denied";
				if ($rtype === "json") {
					$contextPath = ! empty ( ApplicationConfig::get ( 'web.context' ) ) ? ApplicationConfig::get ( 'web.context' ) : "";
					$newUri = $contextPath . "/" . $newUri;
					RouteUtil::setUri ( $newUri );
					$filterChain->doFilter ();
				} else {
					header ( 'location:' . ActionUtil::getFullPathAlias ( "admin/login" ) );
				}
				return;
			} else {
				// redirect to access denied
				$rtype = isset ( $_REQUEST ['rtype'] ) ? $_REQUEST ['rtype'] : "";
				$newUri = "admin/access/denied";
				if ($rtype === "json") {
					$contextPath = ! empty ( ApplicationConfig::get ( 'web.context' ) ) ? ApplicationConfig::get ( 'web.context' ) : "";
					$newUri = $contextPath . "/" . $newUri;
					RouteUtil::setUri ( $newUri );
					$filterChain->doFilter ();
				} else {
					header ( 'location:' . ActionUtil::getFullPathAlias ( $newUri ) );
				}
				return;
			}
		}
	}
}