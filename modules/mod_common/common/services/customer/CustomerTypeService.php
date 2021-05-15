<?php

namespace common\services\customer;

use common\persistence\base\vo\CustomerTypeVo;
use common\persistence\extend\dao\CustomerTypeExtendDao;
use common\services\base\BaseService;

class CustomerTypeService extends  BaseService{
	private $extendDao;
	public function __construct() {
		$this->extendDao = new CustomerTypeExtendDao();
	}
	public function selectByKey(CustomerTypeVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(CustomerTypeVo $vo){
		return $this->extendDao->selectByFilter( $vo );
	}
	public function countByFilter(CustomerTypeVo $vo){
		return $this->extendDao->countByFilter( $vo );
	}
	public function createCustomerType(CustomerTypeVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}
	public function updateCustomerType(CustomerTypeVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}
	public function search(CustomerTypeVo $vo){
		return $this->extendDao->search($vo);
	}
	public function searchCount(CustomerTypeVo $vo){
		return $this->extendDao->searchCount($vo);
	}
	public function deleteCustomerType(CustomerTypeVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}
	public function selectAll(){
		return $this->extendDao->selectAll();
	}
}