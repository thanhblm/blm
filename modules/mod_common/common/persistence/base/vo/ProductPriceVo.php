<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductPriceVo extends BaseVo {
	public $productId;
	public $currencyCode;
	public $price;
	public $minPrice;
	public $maxPrice;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'currency_code' => 'currencyCode',
			'price' => 'price',
			'min_price' => 'minPrice',
			'max_price' => 'maxPrice' 
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
			"currencyCode" => array (
				"COLUMN_NAME" => "currency_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
				"EXTRA" => ""
			),
			"price" => array (
				"COLUMN_NAME" => "price",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"minPrice" => array (
				"COLUMN_NAME" => "min_price",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"maxPrice" => array (
				"COLUMN_NAME" => "max_price",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			)
		);
	}
}