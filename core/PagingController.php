<?php

namespace core;

use core\config\ApplicationConfig;
use core\utils\AppUtil;

class PagingController extends Controller{
	public $page;
	public $pageSize;
	public $orderBy;
	public $filter;
	public $pageSizes;

	public function __construct(){
		parent::__construct();
		$pageSizes = ApplicationConfig::get("page.size.list");
		if (AppUtil::isEmptyString($pageSizes)) {
			$this->pageSizes = array(
				5,
				10,
				20,
				50,
				100
			);
		} else {
			$this->pageSizes = explode(",", $pageSizes);
		}
	}

	public function buildBaseFilter($defaultOrderBy = null){
		// Set default value for filter.
		// Default order by.
		if (AppUtil::isEmptyString($this->orderBy)) {
			$this->orderBy = $defaultOrderBy;
		}
		// Default current page is 1.
		if (AppUtil::isEmptyString($this->page)) {
			$this->page = 1;
		}
		// Default page size is 10.
		if (AppUtil::isEmptyString($this->pageSize)) {
			$this->pageSize = null != ApplicationConfig::get("page.default.page.size") ? ApplicationConfig::get("page.default.page.size") : 10;
		}
		// Create a filter.
		$filter = AppUtil::cloneObj($this->filter);
		$filter->order_by = $this->orderBy;
		return $filter;
	}

	public function getNLinks(){
		return null != ApplicationConfig::get("page.default.nlinks") ? ApplicationConfig::get("page.default.nlinks") : 5;
	}
}