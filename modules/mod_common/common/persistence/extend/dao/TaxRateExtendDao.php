<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\TaxRateBaseDao;
use common\persistence\base\vo\TaxRateVo;
use common\persistence\extend\mapping\TaxRateExtendMapping;
use common\persistence\extend\vo\TaxRateExtendVo;
use core\database\SqlMapClient;

class TaxRateExtendDao extends TaxRateBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(TaxRateExtendVo $taxRateExtentVo) {
		$result = $this->executeSelectList ( TaxRateExtendMapping::class, 'search', $taxRateExtentVo );
		return $result;
	}
	public function searchCount(TaxRateExtendVo $taxRateExtentVo) {
		$result = $this->executeCount ( TaxRateExtendMapping::class, 'searchCount', $taxRateExtentVo );
		return $result;
	}
	public function getTaxRateByClass(TaxRateVo $taxRateVo) {
		return $this->executeSelectList ( TaxRateExtendMapping::class, "getTaxRateByClass", $taxRateVo );
	}
}