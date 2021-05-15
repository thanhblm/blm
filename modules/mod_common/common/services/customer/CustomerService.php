<?php

namespace common\services\customer;

use common\persistence\extend\dao\CustomerExtendDao;
use common\services\base\BaseService;
use common\persistence\extend\vo\CustomerExtendVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\dao\CustomerChangePasswordBaseDao;
use common\persistence\base\vo\CustomerChangePasswordVo;
use core\database\SqlMapClient;
use common\persistence\base\dao\CustomerBaseDao;

class CustomerService extends BaseService{
	private $extendDao;
	private $changePassDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->extendDao = new CustomerExtendDao($this->context);
		$this->changePassDao = new CustomerChangePasswordBaseDao();
	}
	public function selectByKey(CustomerVo $vo) {
		$this->extendDao = new CustomerExtendDao($this->context);
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(CustomerVo $vo){
		$this->extendDao = new CustomerExtendDao($this->context);
		return $this->extendDao->selectByFilter( $vo );
	}
	public function countByFilter(CustomerVo $vo){
		return $this->extendDao->countByFilter( $vo );
	}
	public function createCustomer(CustomerVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}
	public function updateCustomer(CustomerVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}
	public function search(CustomerExtendVo $vo){
		return $this->extendDao->search($vo);
	}
	public function searchCount(CustomerExtendVo $vo){
		return $this->extendDao->searchCount($vo);
	}
	public function deleteCustomer(CustomerExtendVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}
	
	public function selectAll(){
		return $this->extendDao->selectAll();
	}
	
	public function rePassword(CustomerVo $vo){
		$sqlClient = new SqlMapClient( $this->context );
		$customerBaseDao = new CustomerExtendDao( $this->context, $sqlClient );
		$changePassCustomerBaseDao = new CustomerChangePasswordBaseDao( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			$customerBaseDao->updateDynamicByKey($vo);
			$customerChangePassVo = new CustomerChangePasswordVo();
			$customerChangePassVo->customerId = $vo->id;
			$customerBaseDao->deleteChangePass($customerChangePassVo);
			$sqlClient->endTransaction ();
		} catch (Exception $e) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	
	public function customerChangePassInstall(CustomerChangePasswordVo $vo){
		return $this->changePassDao->insertDynamic($vo);
	}
	
	public function customerChangePassSelectByFilter(CustomerChangePasswordVo $vo){
		return $this->changePassDao->selectByFilter($vo);
	}
	
	public function delCustomerChangePass(CustomerChangePasswordVo $vo){
		return $this->changePassDao->deleteByKey($vo);
	}
}