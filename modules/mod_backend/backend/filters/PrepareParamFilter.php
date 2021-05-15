<?php

namespace backend\filters;

use core\config\ApplicationConfig;
use core\filters\Filter;
use core\utils\SessionUtil;

class PrepareParamFilter implements Filter {
	public function init($filterConfig) {
	}
	public function doFilter($filterChain) {
		// recache system setting cache
		$settingCache = SessionUtil::remove(ApplicationConfig::get ( "cache.settings.name" ));
		$filterChain->doFilter ();
	}
}