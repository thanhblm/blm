<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class RegionCountryVo extends BaseVo {
	public $regionId;
	public $countryId;
	public $stateId;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'region_id' => 'regionId',
			'country_id' => 'countryId',
			'state_id' => 'stateId' 
		);
		$this->columnMap = array (
			"regionId" => array (
				"COLUMN_NAME" => "region_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"countryId" => array (
				"COLUMN_NAME" => "country_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"stateId" => array (
				"COLUMN_NAME" => "state_id",
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