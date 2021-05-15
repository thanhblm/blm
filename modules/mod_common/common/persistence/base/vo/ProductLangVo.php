<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductLangVo extends BaseVo {
	public $productId;
	public $languageCode;
	public $name;
	public $description;
	public $composition;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'language_code' => 'languageCode',
			'name' => 'name',
			'description' => 'description',
			'composition' => 'composition' 
		);
		$this->columnMap = array (
			"productId" => array (
				"COLUMN_NAME" => "product_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"languageCode" => array (
				"COLUMN_NAME" => "language_code",
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
			),
			"composition" => array (
				"COLUMN_NAME" => "composition",
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