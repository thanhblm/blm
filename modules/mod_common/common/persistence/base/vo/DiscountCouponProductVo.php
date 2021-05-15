<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class DiscountCouponProductVo extends BaseVo {
	public $discountCouponId;
	public $itemId;
	public $itemType;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'discount_coupon_id' => 'discountCouponId',
			'item_id' => 'itemId',
			'item_type' => 'itemType' 
		);
		$this->columnMap = array (
			"discountCouponId" => array (
				"COLUMN_NAME" => "discount_coupon_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"itemId" => array (
				"COLUMN_NAME" => "item_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"itemType" => array (
				"COLUMN_NAME" => "item_type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			)
		);
	}
}