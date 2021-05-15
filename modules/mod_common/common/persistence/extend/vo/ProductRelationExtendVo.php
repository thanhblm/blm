<?php
namespace common\persistence\extend\vo;

use common\persistence\base\vo\ProductRelationVo;

class ProductRelationExtendVo extends ProductRelationVo{
	public $name;
	
	function __construct(){
		parent::__construct();
		$this->resultMap['name'] = "name";
	}
}