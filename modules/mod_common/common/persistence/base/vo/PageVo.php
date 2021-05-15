<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PageVo extends BaseVo {
	public $id;
	public $templateId;
	public $action;
	public $name;
	public $description;
	public $cacheEnable;
	public $isSystem;
	public $isTemp;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'template_id' => 'templateId',
			'action' => 'action',
			'name' => 'name',
			'description' => 'description',
			'cache_enable' => 'cacheEnable',
			'is_system' => 'isSystem',
			'is_temp' => 'isTemp',
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
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => "auto_increment"
			),
			"templateId" => array (
				"COLUMN_NAME" => "template_id",
				"COLUMN_DEFAULT" => "1",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"action" => array (
				"COLUMN_NAME" => "action",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
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
			"cacheEnable" => array (
				"COLUMN_NAME" => "cache_enable",
				"COLUMN_DEFAULT" => "yes",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "3",
				"COLUMN_TYPE" => "enum('yes','no')",
				"EXTRA" => ""
			),
			"isSystem" => array (
				"COLUMN_NAME" => "is_system",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
				"EXTRA" => ""
			),
			"isTemp" => array (
				"COLUMN_NAME" => "is_temp",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
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