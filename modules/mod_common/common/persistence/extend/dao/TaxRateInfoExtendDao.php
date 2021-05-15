<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\TaxRateInfoBaseDao;
use common\persistence\extend\mapping\TaxRateInfoExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\extend\vo\TaxRateInfoExtendVo;

class TaxRateInfoExtendDao extends TaxRateInfoBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(TaxRateInfoExtendVo $taxRateInfoVo) {
		$result = $this->executeSelectList ( TaxRateInfoExtendMapping::class, 'search', $taxRateInfoVo);
		return $result;
	}
	public function deleteWithTaxRateId(TaxRateInfoVo $taxRateInfoVo) {
		$result = $this->executeDelete( TaxRateInfoExtendMapping::class, 'deleteWithTaxRateId', $taxRateInfoVo);
		return $result;
	}
	public function searchCount(TaxRateInfoExtendVo $taxRateInfoVo) {
		$result = $this->executeCount( TaxRateInfoExtendMapping::class, 'searchCount', $taxRateInfoVo);
		return $result;
	}
	
	public function selectByFilterWithPriority(TaxRateInfoExtendVo $taxRateInfoVo) {
		$result = $this->executeSelectList( TaxRateInfoExtendMapping::class, 'selectByFilterWithPriority', $taxRateInfoVo);
		return $result;
	}
}