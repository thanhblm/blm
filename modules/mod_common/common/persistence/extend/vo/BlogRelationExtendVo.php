<?php
namespace common\persistence\extend\vo;

use common\persistence\base\vo\BlogRelationVo;

class BlogRelationExtendVo extends BlogRelationVo{
	public $name;
	
	function __construct(){
		parent::__construct();
		$this->resultMap['name'] = "name";
	}
}