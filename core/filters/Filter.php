<?php

namespace core\filters;

interface Filter {
	public function init($filterConfig);
	public function doFilter($filterChain);
}