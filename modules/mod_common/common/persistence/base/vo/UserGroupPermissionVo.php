<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class UserGroupPermissionVo extends BaseVo {
	public $userGroupId;
	public $permissionActionCode;
	public $permissionType;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'user_group_id' => 'userGroupId',
			'permission_action_code' => 'permissionActionCode',
			'permission_type' => 'permissionType' 
		);
		$this->columnMap = array (
			"userGroupId" => array (
				"COLUMN_NAME" => "user_group_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"permissionActionCode" => array (
				"COLUMN_NAME" => "permission_action_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"permissionType" => array (
				"COLUMN_NAME" => "permission_type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
				"EXTRA" => ""
			)
		);
	}
}