<?php

namespace core\filters;

class FilterChainImp implements FilterChain {
	private $currentIndex = null;
	private $filters = null;
	function __construct($filters) {
		$this->filters = $filters;
	}
	public function doFilter() {
		if (! isset ( $this->filters )) {
			return;
		}
		if (count ( $this->filters ) <= 0) {
			return;
		}
		if (! isset ( $this->currentIndex )) {
			$this->currentIndex = 0;
		} else {
			$this->currentIndex ++;
		}
		if ($this->currentIndex == count ( $this->filters )) {
			return;
		}
		$class = $this->filters [$this->currentIndex];
		$filter = new $class ();
		$filter->init ( $this->filters );
		$filter->doFilter ( $this );
	}
}