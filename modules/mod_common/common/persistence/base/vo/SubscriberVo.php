<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class SubscriberVo extends BaseVo {
	public $id;
	public $email;
	public $firstName;
	public $lastName;
	public $status;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'email' => 'email',
			'first_name' => 'firstName',
			'last_name' => 'lastName',
			'status' => 'status',
			'cr_date' => 'crDate',
			'cr_by' => 'crBy',
			'md_date' => 'mdDate',
			'md_by' => 'mdBy' 
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
			"email" => array (
				"COLUMN_NAME" => "email",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"firstName" => array (
				"COLUMN_NAME" => "first_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"lastName" => array (
				"COLUMN_NAME" => "last_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "active",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('active','inactive')",
				"EXTRA" => ""
			),
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"crBy" => array (
				"COLUMN_NAME" => "cr_by",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"mdDate" => array (
				"COLUMN_NAME" => "md_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"mdBy" => array (
				"COLUMN_NAME" => "md_by",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			)
		);
	}
}