<?php

namespace common\services\admin;

use common\filter\user\UserFilter;
use common\persistence\base\vo\UserVo;
use common\persistence\extend\dao\UserExtendDao;

class UserService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new UserExtendDao();
	}
	public function selectByKey(UserVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(UserVo $vo){
		return $this->extendDao->selectByFilter( $vo );
	}
	public function countByFilter(UserVo $vo){
		return $this->extendDao->countByFilter( $vo );
	}
	public function createUser(UserVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}
	public function updateUser(UserVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}
	public function search(UserFilter $filter){
		return $this->extendDao->search($filter);
	}
	public function searchCount(UserFilter $filter){
		return $this->extendDao->searchCount($filter);
	}
	public function deleteUser(UserVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}
}