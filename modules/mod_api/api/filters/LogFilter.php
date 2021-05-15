<?php

namespace api\filters;

use core\filters\Filter;

class LogFilter implements Filter {
	public function init($filterConfig) {
	}
	public function doFilter($filterChain) {
		$filterChain->doFilter();
	}
}