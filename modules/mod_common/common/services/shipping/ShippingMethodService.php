<?php

namespace common\services\shipping;

use common\filter\shipping\ShippingFilter;
use common\persistence\extend\dao\ShippingMethodExtendDao;
use common\persistence\base\vo\ShippingMethodVo;

class ShippingMethodService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new ShippingMethodExtendDao();
	}
	public function selectById(ShippingMethodVo $filter) {
		return $this->extendDao->selectByKey ( $filter );
	}
	public function selectByFilter(ShippingMethodVo $filter) {
		return $this->extendDao->selectByFilter ( $filter );
	}
	public function countByFilter(ShippingMethodVo $filter) {
		return $this->extendDao->countByFilter ( $filter );
	}
	public function update(ShippingMethodVo $filter) {
		return $this->extendDao->updateDynamicByKey ( $filter );
	}
	public function insert(ShippingMethodVo $filter) {
		return $this->extendDao->insertDynamic ( $filter );
	}
	public function delete(ShippingMethodVo $filter) {
		return $this->extendDao->deleteByKey ( $filter );
	}
	public function selectBykey(ShippingMethodVo $filter){
		return $this->extendDao->selectByKey($filter);
	}
	public function selectAll(){
		return $this->extendDao->selectAll();
	}
	
	public function search(ShippingFilter $filter){
		return $this->extendDao->search($filter);
	}
	
	public function searchCount(ShippingFilter $filter){
		return $this->extendDao->searchCount($filter);
	}

}