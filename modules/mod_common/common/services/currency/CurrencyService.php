<?php

namespace common\services\currency;

use common\persistence\base\vo\CurrencyVo;
use common\persistence\extend\dao\CurrencyExtendDao;
use common\persistence\extend\vo\CurrencyExtendVo;

class CurrencyService {
	private $currencyDao;
	public function __construct() {
		$this->currencyDao = new CurrencyExtendDao ();
	}
	public function getAll() {
		return $this->currencyDao->selectAll ();
	}
	public function getByFilter(CurrencyExtendVo $filter) {
		return $this->currencyDao->getByFilter ( $filter );
	}
	public function getCountByFilter(CurrencyExtendVo $filter) {
		return $this->currencyDao->getCountByFilter ( $filter );
	}
	public function add(CurrencyVo $currencyVo) {
		return $this->currencyDao->insertDynamic ( $currencyVo );
	}
	public function update(CurrencyVo $currencyVo) {
		return $this->currencyDao->updateDynamicByKey ( $currencyVo );
	}
	public function delete(CurrencyVo $currencyVo) {
		return $this->currencyDao->deleteByKey ( $currencyVo );
	}
	public function getById(CurrencyVo $filter) {
		return $this->currencyDao->selectByKey ( $filter );
	}
}