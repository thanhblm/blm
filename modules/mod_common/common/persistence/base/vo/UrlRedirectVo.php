<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class UrlRedirectVo extends BaseVo {
	public $id;
	public $oldUrl;
	public $newUrl;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'old_url' => 'oldUrl',
			'new_url' => 'newUrl',
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
			"oldUrl" => array (
				"COLUMN_NAME" => "old_url",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"newUrl" => array (
				"COLUMN_NAME" => "new_url",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
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