<?php

namespace common\services\permission;

use common\filter\permission\PermissionFilter;
use common\persistence\extend\dao\PermissionExtendDao;
use common\persistence\base\vo\PermissionVo;
use common\persistence\extend\dao\PermissionActionExtendDao;
use common\persistence\extend\vo\PermissionActionExtendVo;

class PermissionService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new PermissionExtendDao ();
	}
	public function selectById(PermissionVo $filter) {
		return $this->extendDao->selectByKey ( $filter );
	}
	public function selectByFilter(PermissionVo $filter) {
		return $this->extendDao->selectByFilter ( $filter );
	}
	public function countByFilter(PermissionVo $filter) {
		return $this->extendDao->countByFilter ( $filter );
	}
	public function update(PermissionVo $filter) {
		return $this->extendDao->updateDynamicByKey ( $filter );
	}
	public function insert(PermissionVo $filter) {
		return $this->extendDao->insertDynamic ( $filter );
	}
	public function delete(PermissionVo $filter) {
		return $this->extendDao->deleteByKey ( $filter );
	}
	public function selectBykey(PermissionVo $filter) {
		return $this->extendDao->selectByKey ( $filter );
	}
	public function search(PermissionFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(PermissionFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
	public function getListPermission() {
		return $this->extendDao->getListPermission ();
	}
	public function getAll() {
		return $this->extendDao->selectAll ();
	}
	public function getListPermissionActionForAuthodrization(PermissionActionExtendVo $vo) {
		$permissionActionExtendDao  = new PermissionActionExtendDao();
		return $permissionActionExtendDao->getListPermissionActionForAuthodrization($vo);
	}
}