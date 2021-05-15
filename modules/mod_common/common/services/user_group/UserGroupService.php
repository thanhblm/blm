<?php

namespace common\services\user_group;

use common\filter\user_group\UserGroupFilter;
use common\persistence\base\dao\UserGroupBaseDao;
use common\persistence\base\vo\UserGroupPermissionVo;
use common\persistence\base\vo\UserGroupVo;
use common\persistence\extend\dao\UserGroupExtendDao;
use common\persistence\extend\dao\UserGroupPermissionExtendDao;
use core\BaseArray;
use core\database\SqlMapClient;

class UserGroupService {
	private $extendDao;
	private $userGroupPermissionDao;
	public function __construct() {
		$this->extendDao = new UserGroupExtendDao ();
		$this->userGroupPermissionDao = new UserGroupPermissionExtendDao ();
	}
	public function getUserGroupPermissions(UserGroupPermissionVo $filter) {
		return $this->userGroupPermissionDao->selectByFilter ( $filter );
	}
	public function selectById(UserGroupVo $userGroupVo) {
		return $this->extendDao->selectByKey ( $userGroupVo );
	}
	public function selectByFilter(UserGroupVo $userGroupVo) {
		return $this->extendDao->selectByFilter ( $userGroupVo );
	}
	public function countByFilter(UserGroupVo $userGroupVo) {
		return $this->extendDao->countByFilter ( $userGroupVo );
	}
	public function update(UserGroupVo $userGroupVo) {
		return $this->extendDao->updateDynamicByKey ( $userGroupVo );
	}
	public function insert(UserGroupVo $userGroupVo) {
		return $this->extendDao->insertDynamic ( $userGroupVo );
	}
	public function delete(UserGroupVo $userGroupVo) {
		return $this->extendDao->deleteByKey ( $userGroupVo );
	}
	public function selectBykey(UserGroupVo $userGroupVo) {
		return $this->extendDao->selectByKey ( $userGroupVo );
	}
	public function search(UserGroupFilter $userGroupFilter) {
		return $this->extendDao->search ( $userGroupFilter );
	}
	public function searchCount(UserGroupFilter $userGroupFilter) {
		return $this->extendDao->searchCount ( $userGroupFilter );
	}
	
	/**
	 * Add user group
	 * Add permission
	 *
	 * @param UserGroupVo $vo        	
	 * @param ListPermissionId $permissions
	 *        	array("permission_action_code@@permission_type")
	 */
	public function add(UserGroupVo $userGroupVo, BaseArray $permissions) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$uDao = new UserGroupBaseDao ( null, $sqlMapClient );
			$userGroupId = $uDao->insertDynamic ( $userGroupVo );
			$pgExtDao = new UserGroupPermissionExtendDao ( null, $sqlMapClient );
			foreach ( $permissions->getArray () as $permission ) {
				$pgVo = new UserGroupPermissionVo ();
				$pgVo->permissionType = $permission->permissionType;
				$pgVo->permissionActionCode = $permission->permissionActionCode;
				$pgVo->userGroupId = $userGroupId;
				$pgExtDao->insertDynamic ( $pgVo );
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	
	/**
	 * Edit user group
	 * Del all permission group and add new
	 *
	 * @param UserGroupVo $vo        	
	 * @param ListPermissionId $permissions        	
	 */
	public function edit(UserGroupVo $userGroupVo, BaseArray $permissions) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$uDao = new UserGroupBaseDao ( null, $sqlMapClient );
			$uDao->updateDynamicByKey ( $userGroupVo );
			$userGroupId = $userGroupVo->id;
			$pgExDao = new UserGroupPermissionExtendDao ( null, $sqlMapClient );
			$pgVo = new UserGroupPermissionVo ();
			$pgVo->userGroupId = $userGroupId;
			$pgExDao->delByUserGroup ( $pgVo );
			foreach ( $permissions->getArray () as $permission ) {
				$pgVo = new UserGroupPermissionVo ();
				$pgVo->permissionType = $permission->permissionType;
				$pgVo->permissionActionCode = $permission->permissionActionCode;
				$pgVo->userGroupId = $userGroupId;
				$pgExDao->insertDynamic ( $pgVo );
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function deleteUserGroup(UserGroupVo $userGroupVo) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$uDao = new UserGroupBaseDao ( null, $sqlMapClient );
			$userGroupId = $userGroupVo->id;
			$uDao->deleteByKey ( $userGroupVo );
			$pgExDao = new UserGroupPermissionExtendDao ( null, $sqlMapClient );
			$pgVo = new UserGroupPermissionVo ();
			$pgVo->userGroupId = $userGroupId;
			$pgExDao->delByUserGroup ( $pgVo );
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
}