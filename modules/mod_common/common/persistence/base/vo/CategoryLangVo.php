<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class CategoryLangVo extends BaseVo {
	public $categoryId;
	public $languageCode;
	public $name;
	public $description;
	public $introduction;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'category_id' => 'categoryId',
			'language_code' => 'languageCode',
			'name' => 'name',
			'description' => 'description',
			'introduction' => 'introduction' 
		);
		$this->columnMap = array (
			"categoryId" => array (
				"COLUMN_NAME" => "category_id",
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
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
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
			"introduction" => array (
				"COLUMN_NAME" => "introduction",
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