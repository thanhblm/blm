<?php
namespace common\persistence\extend\vo;



use common\persistence\base\vo\ProductRegionVo;

class ProductRegionExtendVo extends ProductRegionVo{
	public $name;
	public $select;
	
	function __construct(){
		parent::__construct();
		$this->resultMap['name'] = "name";
	}
}