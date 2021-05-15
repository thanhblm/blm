<?php

namespace common\services\price_level;

use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\extend\dao\PriceLevelExtendDao;
use common\persistence\extend\vo\PriceLevelExtendVo;

class PriceLevelService {
	private $priceLevelDao;
	public function __construct() {
		$this->priceLevelDao = new PriceLevelExtendDao ();
	}
	public function getPriceLevelByKey(PriceLevelVo $filter) {
		return $this->priceLevelDao->selectByKey ( $filter );
	}
	public function selectByName(PriceLevelVo $filter) {
		return $this->priceLevelDao->selectByFilter ( $filter );
	}
	public function getPriceLevelByFilter(PriceLevelExtendVo $filter) {
		return $this->priceLevelDao->getByFilter ( $filter );
	}
	public function countPriceLevelByFilter(PriceLevelExtendVo $filter) {
		return $this->priceLevelDao->getCountByFilter ( $filter );
	}
	public function updatePriceLevel(PriceLevelVo $priceLevelVo) {
		return $this->priceLevelDao->updateDynamicByKey ( $priceLevelVo );
	}
	public function deletePriceLevel(PriceLevelVo $priceLevelVo) {
		return $this->priceLevelDao->deleteByKey ( $priceLevelVo );
	}
	public function createPriceLevel(PriceLevelVo $priceLevelVo) {
		return $this->priceLevelDao->insertDynamic ( $priceLevelVo );
	}
	public function selectAll() {
		return $this->priceLevelDao->selectAll ();
	}
	public function selectByKey(PriceLevelVo $priceLevelVo) {
		return $this->priceLevelDao->selectByKey( $priceLevelVo );
	}
	public function getPriceLevelByCustomerId(CustomerVo $customerVo) {
		return $this->priceLevelDao->getPriceLevelByCustomerId( $customerVo );
	}
}