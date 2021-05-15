<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class PageCacheVo extends BaseVo {
	public $pageId;
	public $languageCode;
	public $data;
	public $mdDate;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'page_id' => 'pageId',
			'language_code' => 'languageCode',
			'data' => 'data',
			'md_date' => 'mdDate' 
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
			"data" => array (
				"COLUMN_NAME" => "data",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"mdDate" => array (
				"COLUMN_NAME" => "md_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			)
		);
	}
}