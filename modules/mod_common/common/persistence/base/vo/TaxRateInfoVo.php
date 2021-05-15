<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class TaxRateInfoVo extends BaseVo {
	public $id;
	public $type;
	public $taxRateId;
	public $taxShippingZoneId;
	public $name;
	public $zoneMatch;
	public $rate;
	public $dynamicRate;
	public $priority;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'type' => 'type',
			'tax_rate_id' => 'taxRateId',
			'tax_shipping_zone_id' => 'taxShippingZoneId',
			'name' => 'name',
			'zone_match' => 'zoneMatch',
			'rate' => 'rate',
			'dynamic_rate' => 'dynamicRate',
			'priority' => 'priority' 
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
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "static",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "7",
				"COLUMN_TYPE" => "enum('dynamic','static')",
				"EXTRA" => ""
			),
			"taxRateId" => array (
				"COLUMN_NAME" => "tax_rate_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"taxShippingZoneId" => array (
				"COLUMN_NAME" => "tax_shipping_zone_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"zoneMatch" => array (
				"COLUMN_NAME" => "zone_match",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"rate" => array (
				"COLUMN_NAME" => "rate",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(10,2)",
				"EXTRA" => ""
			),
			"dynamicRate" => array (
				"COLUMN_NAME" => "dynamic_rate",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "20",
				"COLUMN_TYPE" => "varchar(20)",
				"EXTRA" => ""
			),
			"priority" => array (
				"COLUMN_NAME" => "priority",
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