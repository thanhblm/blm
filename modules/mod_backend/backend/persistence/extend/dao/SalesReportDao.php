<?php

namespace backend\persistence\extend\dao;

use backend\persistence\extend\mapping\SalesReportMapping;
use backend\persistence\extend\vo\SalesReportFilterVo;
use core\database\BaseDao;
use core\database\SqlMapClient;

class SalesReportDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getOverviewByFilter(SalesReportFilterVo $filter) {
		$result = $this->executeSelectList ( SalesReportMapping::class, 'getOverviewByFilter', $filter );
		return $result;
	}
	final public function getOrderByFilter(SalesReportFilterVo $filter) {
		$result = $this->executeSelectList ( SalesReportMapping::class, 'getOrderByFilter', $filter );
		return $result;
	}
	final public function getTopProductByFilter(SalesReportFilterVo $filter) {
		$result = $this->executeSelectList ( SalesReportMapping::class, 'getTopProductByFilter', $filter );
		return $result;
	}
	final public function getTopCountryFilter(SalesReportFilterVo $filter) {
		$result = $this->executeSelectList ( SalesReportMapping::class, 'getTopCountryFilter', $filter );
		return $result;
	}
	final public function getDistinctTopCountryByFilter(SalesReportFilterVo $filter) {
		$result = $this->executeSelectList ( SalesReportMapping::class, 'getDistinctTopCountryByFilter', $filter );
		return $result;
	}
}