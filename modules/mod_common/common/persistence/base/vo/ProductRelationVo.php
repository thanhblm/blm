<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductRelationVo extends BaseVo {
	public $productId;
	public $relateProductId;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'relate_product_id' => 'relateProductId' 
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
			"relateProductId" => array (
				"COLUMN_NAME" => "relate_product_id",
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