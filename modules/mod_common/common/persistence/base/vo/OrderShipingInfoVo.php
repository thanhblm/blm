<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class OrderShipingInfoVo extends BaseVo {
	public $orderId;
	public $shipBy;
	public $shipDate;
	public $trackingCode;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'order_id' => 'orderId',
			'ship_by' => 'shipBy',
			'ship_date' => 'shipDate',
			'tracking_code' => 'trackingCode' 
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
			"shipBy" => array (
				"COLUMN_NAME" => "ship_by",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"shipDate" => array (
				"COLUMN_NAME" => "ship_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"trackingCode" => array (
				"COLUMN_NAME" => "tracking_code",
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