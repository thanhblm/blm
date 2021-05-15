<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class CountryVo extends BaseVo {
	public $id;
	public $name;
	public $iso2;
	public $iso3;
	public $ison;
	public $isor1;
	public $isor2;
	public $nameLocal;
	public $continent;
	public $lat;
	public $lng;
	public $phonePrefix;
	public $languages;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'name' => 'name',
			'iso2' => 'iso2',
			'iso3' => 'iso3',
			'ison' => 'ison',
			'isor1' => 'isor1',
			'isor2' => 'isor2',
			'name_local' => 'nameLocal',
			'continent' => 'continent',
			'lat' => 'lat',
			'lng' => 'lng',
			'phone_prefix' => 'phonePrefix',
			'languages' => 'languages' 
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
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "150",
				"COLUMN_TYPE" => "varchar(150)",
				"EXTRA" => ""
			),
			"iso2" => array (
				"COLUMN_NAME" => "iso2",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"iso3" => array (
				"COLUMN_NAME" => "iso3",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"ison" => array (
				"COLUMN_NAME" => "ison",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"isor1" => array (
				"COLUMN_NAME" => "isor1",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"isor2" => array (
				"COLUMN_NAME" => "isor2",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"nameLocal" => array (
				"COLUMN_NAME" => "name_local",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"continent" => array (
				"COLUMN_NAME" => "continent",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"lat" => array (
				"COLUMN_NAME" => "lat",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "double",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "double",
				"EXTRA" => ""
			),
			"lng" => array (
				"COLUMN_NAME" => "lng",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "double",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "double",
				"EXTRA" => ""
			),
			"phonePrefix" => array (
				"COLUMN_NAME" => "phone_prefix",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"languages" => array (
				"COLUMN_NAME" => "languages",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			)
		);
	}
}