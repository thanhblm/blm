<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PageLangVo extends BaseVo {
	public $pageId;
	public $languageCode;
	public $name;
	public $description;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'page_id' => 'pageId',
			'language_code' => 'languageCode',
			'name' => 'name',
			'description' => 'description' 
		);
		$this->columnMap = array (
			"pageId" => array (
				"COLUMN_NAME" => "page_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"languageCode" => array (
				"COLUMN_NAME" => "language_code",
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
			)
		);
	}
}