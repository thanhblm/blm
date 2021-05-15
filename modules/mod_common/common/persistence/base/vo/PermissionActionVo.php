<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PermissionActionVo extends BaseVo {
	public $code;
	public $name;
	public $actionType;
	public $action;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'code' => 'code',
			'name' => 'name',
			'action_type' => 'actionType',
			'action' => 'action' 
		);
		$this->columnMap = array (
			"code" => array (
				"COLUMN_NAME" => "code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"actionType" => array (
				"COLUMN_NAME" => "action_type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"action" => array (
				"COLUMN_NAME" => "action",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			)
		);
	}
}