<?php

namespace common\services\payment;

use common\filter\payment\PaymentFilter;
use common\persistence\extend\dao\PaymentMethodExtendDao;
use common\persistence\base\vo\PaymentMethodVo;

class PaymentMethodService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new PaymentMethodExtendDao();
	}
	public function selectById(PaymentMethodVo $filter) {
		return $this->extendDao->selectByKey ( $filter );
	}
	public function selectByFilter(PaymentMethodVo $filter) {
		return $this->extendDao->selectByFilter ( $filter );
	}
	public function countByFilter(PaymentMethodVo $filter) {
		return $this->extendDao->countByFilter ( $filter );
	}
	public function update(PaymentMethodVo $filter) {
		return $this->extendDao->updateDynamicByKey ( $filter );
	}
	public function insert(PaymentMethodVo $filter) {
		return $this->extendDao->insertDynamic ( $filter );
	}
	public function delete(PaymentMethodVo $filter) {
		return $this->extendDao->deleteByKey ( $filter );
	}
	public function selectBykey(PaymentMethodVo $filter){
		return $this->extendDao->selectByKey($filter);
	}
	
	public function search(PaymentFilter $filter){
		return $this->extendDao->search($filter);
	}
	
	public function searchCount(PaymentFilter $filter){
		return $this->extendDao->searchCount($filter);
	}

}