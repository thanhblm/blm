<?php

namespace common\services\customer;

use common\persistence\base\vo\AccountTypeVo;
use common\persistence\extend\dao\AccountTypeExtendDao;
use common\services\base\BaseService;

class AccountTypeService extends  BaseService{
	private $extendDao;
	public function __construct() {
		$this->extendDao = new AccountTypeExtendDao();
	}
	public function selectByKey(AccountTypeVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectAll() {
		return $this->extendDao->selectAll( );
	}
	public function selectByFilter(AccountTypeVo $vo){
		return $this->extendDao->selectByFilter( $vo );
	}
	public function countByFilter(AccountTypeVo $vo){
		return $this->extendDao->countByFilter( $vo );
	}
	public function createAccountType(AccountTypeVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}
	public function updateAccountType(AccountTypeVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}
	public function search(AccountTypeVo $vo){
		return $this->extendDao->search($vo);
	}
	public function searchCount(AccountTypeVo $vo){
		return $this->extendDao->searchCount($vo);
	}
	public function deleteAccountType(AccountTypeVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}
}