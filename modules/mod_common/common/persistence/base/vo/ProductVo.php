<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductVo extends BaseVo {
	public $id;
	public $categoryId;
	public $code;
	public $name;
	public $status;
	public $itemCode;
	public $barCode;
	public $weight;
	public $weightUnit;
	public $description;
	public $composition;
	public $featured;
	public $cbdAmount;
	public $pageId;
	public $images;
	public $userType;
	public $userId;
	public $taxRateId;
	public $isSeo;
	public $type;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'category_id' => 'categoryId',
			'code' => 'code',
			'name' => 'name',
			'status' => 'status',
			'item_code' => 'itemCode',
			'bar_code' => 'barCode',
			'weight' => 'weight',
			'weight_unit' => 'weightUnit',
			'description' => 'description',
			'composition' => 'composition',
			'featured' => 'featured',
			'cbd_amount' => 'cbdAmount',
			'page_id' => 'pageId',
			'images' => 'images',
			'user_type' => 'userType',
			'user_id' => 'userId',
			'tax_rate_id' => 'taxRateId',
			'is_seo' => 'isSeo',
			'type' => 'type',
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
			"categoryId" => array (
				"COLUMN_NAME" => "category_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
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
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "150",
				"COLUMN_TYPE" => "varchar(150)",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "active",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('active','inactive')",
				"EXTRA" => ""
			),
			"itemCode" => array (
				"COLUMN_NAME" => "item_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"barCode" => array (
				"COLUMN_NAME" => "bar_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"weight" => array (
				"COLUMN_NAME" => "weight",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"weightUnit" => array (
				"COLUMN_NAME" => "weight_unit",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
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
			),
			"featured" => array (
				"COLUMN_NAME" => "featured",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "3",
				"COLUMN_TYPE" => "enum('yes','no')",
				"EXTRA" => ""
			),
			"cbdAmount" => array (
				"COLUMN_NAME" => "cbd_amount",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "250",
				"COLUMN_TYPE" => "varchar(250)",
				"EXTRA" => ""
			),
			"pageId" => array (
				"COLUMN_NAME" => "page_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"images" => array (
				"COLUMN_NAME" => "images",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"userType" => array (
				"COLUMN_NAME" => "user_type",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "1",
				"COLUMN_TYPE" => "enum('0','1','2')",
				"EXTRA" => ""
			),
			"userId" => array (
				"COLUMN_NAME" => "user_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"taxRateId" => array (
				"COLUMN_NAME" => "tax_rate_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"isSeo" => array (
				"COLUMN_NAME" => "is_seo",
				"COLUMN_DEFAULT" => "no",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "3",
				"COLUMN_TYPE" => "enum('yes','no')",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"crBy" => array (
				"COLUMN_NAME" => "cr_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
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
			),
			"mdBy" => array (
				"COLUMN_NAME" => "md_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			)
		);
	}
}