<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PermissionVo extends BaseVo {
	public $permissionActionCode;
	public $type;
	public $name;
	public $description;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'permission_action_code' => 'permissionActionCode',
			'type' => 'type',
			'name' => 'name',
			'description' => 'description' 
		);
		$this->columnMap = array (
			"permissionActionCode" => array (
				"COLUMN_NAME" => "permission_action_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "150",
				"COLUMN_TYPE" => "varchar(150)",
				"EXTRA" => ""
			),
			"description" => array (
				"COLUMN_NAME" => "description",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			)
		);
	}
}