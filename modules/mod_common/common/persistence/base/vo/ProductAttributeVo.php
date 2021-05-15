<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductAttributeVo extends BaseVo {
	public $id;
	public $productId;
	public $attributeId;
	public $quantity;
	public $price;
	public $type;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'product_id' => 'productId',
			'attribute_id' => 'attributeId',
			'quantity' => 'quantity',
			'price' => 'price',
			'type' => 'type' 
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
			"productId" => array (
				"COLUMN_NAME" => "product_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"attributeId" => array (
				"COLUMN_NAME" => "attribute_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"quantity" => array (
				"COLUMN_NAME" => "quantity",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"price" => array (
				"COLUMN_NAME" => "price",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			)
		);
	}
}