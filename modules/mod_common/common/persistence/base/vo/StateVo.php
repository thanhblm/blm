<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class StateVo extends BaseVo {
	public $id;
	public $iso2;
	public $name;
	public $nameLocal;
	public $country;
	public $countryIso;
	public $lat;
	public $lng;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'iso2' => 'iso2',
			'name' => 'name',
			'name_local' => 'nameLocal',
			'country' => 'country',
			'country_iso' => 'countryIso',
			'lat' => 'lat',
			'lng' => 'lng' 
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
			"iso2" => array (
				"COLUMN_NAME" => "iso2",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
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
			"country" => array (
				"COLUMN_NAME" => "country",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"countryIso" => array (
				"COLUMN_NAME" => "country_iso",
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
			)
		);
	}
}