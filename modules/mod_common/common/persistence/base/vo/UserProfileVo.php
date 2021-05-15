<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class UserProfileVo extends BaseVo {
	public $userId;
	public $creditCardNumber;
	public $cvv;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'user_id' => 'userId',
			'credit_card_number' => 'creditCardNumber',
			'cvv' => 'cvv' 
		);
		$this->columnMap = array (
			"userId" => array (
				"COLUMN_NAME" => "user_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11) unsigned",
				"EXTRA" => ""
			),
			"creditCardNumber" => array (
				"COLUMN_NAME" => "credit_card_number",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(50)",
				"EXTRA" => ""
			),
			"cvv" => array (
				"COLUMN_NAME" => "cvv",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(3)",
				"EXTRA" => ""
			)
		);
	}
}