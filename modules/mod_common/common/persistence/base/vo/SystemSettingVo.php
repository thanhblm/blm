<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class SystemSettingVo extends BaseVo {
	public $id;
	public $name;
	public $systemSettingGroupId;
	public $value;
	public $type;
	public $description;
	public $valueList;
	public $allowNull;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'name' => 'name',
			'system_setting_group_id' => 'systemSettingGroupId',
			'value' => 'value',
			'type' => 'type',
			'description' => 'description',
			'value_list' => 'valueList',
			'allow_null' => 'allowNull',
			'cr_date' => 'crDate',
			'cr_by' => 'crBy',
			'md_date' => 'mdDate',
			'md_by' => 'mdBy' 
		);
		$this->columnMap = array (
			"id" => array (
				"COLUMN_NAME" => "id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => "auto_increment"
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"systemSettingGroupId" => array (
				"COLUMN_NAME" => "system_setting_group_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"value" => array (
				"COLUMN_NAME" => "value",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "TEXT",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
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
			),
			"valueList" => array (
				"COLUMN_NAME" => "value_list",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"allowNull" => array (
				"COLUMN_NAME" => "allow_null",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(1)",
				"EXTRA" => ""
			),
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"crBy" => array (
				"COLUMN_NAME" => "cr_by",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"mdDate" => array (
				"COLUMN_NAME" => "md_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"mdBy" => array (
				"COLUMN_NAME" => "md_by",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			)
		);
	}
}