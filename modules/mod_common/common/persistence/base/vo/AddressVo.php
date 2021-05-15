<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class AddressVo extends BaseVo {
	public $id;
	public $firstName;
	public $lastName;
	public $address;
	public $country;
	public $city;
	public $state;
	public $postalCode;
	public $phone;
	public $fax;
	public $latitude;
	public $longitude;
	public $email;
	public $type;
	public $groupId;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'first_name' => 'firstName',
			'last_name' => 'lastName',
			'address' => 'address',
			'country' => 'country',
			'city' => 'city',
			'state' => 'state',
			'postal_code' => 'postalCode',
			'phone' => 'phone',
			'fax' => 'fax',
			'latitude' => 'latitude',
			'longitude' => 'longitude',
			'email' => 'email',
			'type' => 'type',
			'group_id' => 'groupId',
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
			"firstName" => array (
				"COLUMN_NAME" => "first_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"lastName" => array (
				"COLUMN_NAME" => "last_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"address" => array (
				"COLUMN_NAME" => "address",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"country" => array (
				"COLUMN_NAME" => "country",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"city" => array (
				"COLUMN_NAME" => "city",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"state" => array (
				"COLUMN_NAME" => "state",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"postalCode" => array (
				"COLUMN_NAME" => "postal_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"phone" => array (
				"COLUMN_NAME" => "phone",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"fax" => array (
				"COLUMN_NAME" => "fax",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"latitude" => array (
				"COLUMN_NAME" => "latitude",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "double",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "double",
				"EXTRA" => ""
			),
			"longitude" => array (
				"COLUMN_NAME" => "longitude",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "double",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "double",
				"EXTRA" => ""
			),
			"email" => array (
				"COLUMN_NAME" => "email",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"type" => array (
				"COLUMN_NAME" => "type",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
				"EXTRA" => ""
			),
			"groupId" => array (
				"COLUMN_NAME" => "group_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
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
				"COLUMN_DEFAULT" => "0",
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
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			)
		);
	}
}