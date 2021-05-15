<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductRegionVo extends BaseVo {
	public $productId;
	public $regionId;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'region_id' => 'regionId' 
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
			"regionId" => array (
				"COLUMN_NAME" => "region_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			)
		);
	}
}