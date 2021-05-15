<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class RegionShippingMethodVo extends BaseVo {
	public $id;
	public $shippingMethodId;
	public $regionId;
	public $status;
	public $settingInfo;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'shipping_method_id' => 'shippingMethodId',
			'region_id' => 'regionId',
			'status' => 'status',
			'setting_info' => 'settingInfo' 
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
			"shippingMethodId" => array (
				"COLUMN_NAME" => "shipping_method_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"regionId" => array (
				"COLUMN_NAME" => "region_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('active','inactive')",
				"EXTRA" => ""
			),
			"settingInfo" => array (
				"COLUMN_NAME" => "setting_info",
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