<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class AreaCategoryVo extends BaseVo {
	public $areaId;
	public $categoryId;
	public $description;
	public $image;
	public $status;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'area_id' => 'areaId',
			'category_id' => 'categoryId',
			'description' => 'description',
			'image' => 'image',
			'status' => 'status' 
		);
		$this->columnMap = array (
			"areaId" => array (
				"COLUMN_NAME" => "area_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"categoryId" => array (
				"COLUMN_NAME" => "category_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"description" => array (
				"COLUMN_NAME" => "description",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"image" => array (
				"COLUMN_NAME" => "image",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "active",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('active','inactive')",
				"EXTRA" => ""
			)
		);
	}
}