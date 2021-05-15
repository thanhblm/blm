<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class BlogRelationVo extends BaseVo {
	public $blogId;
	public $relateBlogId;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'blog_id' => 'blogId',
			'relate_blog_id' => 'relateBlogId' 
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
			"relateBlogId" => array (
				"COLUMN_NAME" => "relate_blog_id",
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