<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class AuctionDetailVo extends BaseVo {
	public $auctionId;
	public $productQuantity;
	public $pricePerUnit;
	public $max days;
	public $approve;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'auction_id' => 'auctionId',
			'product_quantity' => 'productQuantity',
			'price_per_unit' => 'pricePerUnit',
			'max days' => 'max days',
			'approve' => 'approve' 
		);
		$this->columnMap = array (
			"auctionId" => array (
				"COLUMN_NAME" => "auction_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11) unsigned",
				"EXTRA" => ""
			),
			"productQuantity" => array (
				"COLUMN_NAME" => "product_quantity",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"pricePerUnit" => array (
				"COLUMN_NAME" => "price_per_unit",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"max days" => array (
				"COLUMN_NAME" => "max days",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"approve" => array (
				"COLUMN_NAME" => "approve",
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