<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class OrderTotalVo extends BaseVo {
	public $id;
	public $orderId;
	public $type;
	public $title;
	public $subtitle;
	public $value;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'order_id' => 'orderId',
			'type' => 'type',
			'title' => 'title',
			'subtitle' => 'subtitle',
			'value' => 'value' 
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
			"orderId" => array (
				"COLUMN_NAME" => "order_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('discount','subtotal','coupon','taxtotal','shipping','total')",
				"EXTRA" => ""
			),
			"title" => array (
				"COLUMN_NAME" => "title",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"subtitle" => array (
				"COLUMN_NAME" => "subtitle",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"value" => array (
				"COLUMN_NAME" => "value",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "double",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "double",
				"EXTRA" => ""
			)
		);
	}
}