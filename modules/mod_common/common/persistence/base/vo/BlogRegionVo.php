<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class BlogRegionVo extends BaseVo {
	public $blogId;
	public $regionId;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'blog_id' => 'blogId',
			'region_id' => 'regionId' 
		);
		$this->columnMap = array (
			"blogId" => array (
				"COLUMN_NAME" => "blog_id",
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