<?php
namespace common\persistence\extend\vo;



use common\persistence\base\vo\BlogRegionVo;

class BlogRegionExtendVo extends BlogRegionVo{
	public $name;
	public $select;
	
	function __construct(){
		parent::__construct();
		$this->resultMap['name'] = "name";
	}
}