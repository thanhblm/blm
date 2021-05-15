<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class BulkDiscountProductVo extends BaseVo {
	public $bulkDiscountId;
	public $productId;
	public $quantity;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'bulk_discount_id' => 'bulkDiscountId',
			'product_id' => 'productId',
			'quantity' => 'quantity' 
		);
		$this->columnMap = array (
			"bulkDiscountId" => array (
				"COLUMN_NAME" => "bulk_discount_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"productId" => array (
				"COLUMN_NAME" => "product_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"quantity" => array (
				"COLUMN_NAME" => "quantity",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			)
		);
	}
}