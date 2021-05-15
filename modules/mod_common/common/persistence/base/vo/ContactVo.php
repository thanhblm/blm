<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ContactVo extends BaseVo {
	public $id;
	public $crDate;
	public $fullName;
	public $email;
	public $phone;
	public $countryCode;
	public $message;
	public $status;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'cr_date' => 'crDate',
			'full_name' => 'fullName',
			'email' => 'email',
			'phone' => 'phone',
			'country_code' => 'countryCode',
			'message' => 'message',
			'status' => 'status' 
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
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"fullName" => array (
				"COLUMN_NAME" => "full_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"email" => array (
				"COLUMN_NAME" => "email",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"phone" => array (
				"COLUMN_NAME" => "phone",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"countryCode" => array (
				"COLUMN_NAME" => "country_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"message" => array (
				"COLUMN_NAME" => "message",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "pending",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "7",
				"COLUMN_TYPE" => "enum('pending','viewed')",
				"EXTRA" => ""
			)
		);
	}
}