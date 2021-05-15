<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class OrderSurchargeVo extends BaseVo {
	public $id;
	public $orderId;
	public $surchargeId;
	public $surchargeType;
	public $amount;
	public $data;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'order_id' => 'orderId',
			'surcharge_id' => 'surchargeId',
			'surcharge_type' => 'surchargeType',
			'amount' => 'amount',
			'data' => 'data' 
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
			"orderId" => array (
				"COLUMN_NAME" => "order_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"surchargeId" => array (
				"COLUMN_NAME" => "surcharge_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"surchargeType" => array (
				"COLUMN_NAME" => "surcharge_type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "13",
				"COLUMN_TYPE" => "enum('bulk_discount','price_level','coupon','shipping')",
				"EXTRA" => ""
			),
			"amount" => array (
				"COLUMN_NAME" => "amount",
				"COLUMN_DEFAULT" => "0.00",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
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
			)
		);
	}
}