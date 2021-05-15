<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class OrderChargeInfoVo extends BaseVo {
	public $orderId;
	public $oldMegaId;
	public $subTotalAmount;
	public $taxAmount;
	public $discountAmount;
	public $shippingAmount;
	public $grandTotalAmount;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'order_id' => 'orderId',
			'old_mega_id' => 'oldMegaId',
			'sub_total_amount' => 'subTotalAmount',
			'tax_amount' => 'taxAmount',
			'discount_amount' => 'discountAmount',
			'shipping_amount' => 'shippingAmount',
			'grand_total_amount' => 'grandTotalAmount' 
		);
		$this->columnMap = array (
			"orderId" => array (
				"COLUMN_NAME" => "order_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"oldMegaId" => array (
				"COLUMN_NAME" => "old_mega_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"subTotalAmount" => array (
				"COLUMN_NAME" => "sub_total_amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"taxAmount" => array (
				"COLUMN_NAME" => "tax_amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"discountAmount" => array (
				"COLUMN_NAME" => "discount_amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"shippingAmount" => array (
				"COLUMN_NAME" => "shipping_amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"grandTotalAmount" => array (
				"COLUMN_NAME" => "grand_total_amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			)
		);
	}
}