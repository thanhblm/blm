<?php
namespace common\services\attribute;
use common\persistence\base\dao\ProductAttributeBaseDao;
use common\persistence\base\vo\ProductAttributeVo;
use common\services\base\BaseService;

class ProductAttributeService extends BaseService {
	public $attributeDao;
	public function __construct() {
		parent::__construct ();
		$this->attributeDao = new ProductAttributeBaseDao();
	}
	
	public function getByFilter(ProductAttributeVo $vo){
		return  $this->attributeDao->selectByFilter($vo);
	}
	
	public function countByFilter(ProductAttributeVo $vo){
		return  $this->attributeDao->countByFilter($vo);
	}
	
	public function add(ProductAttributeVo $Vo){
		return  $this->attributeDao->insertDynamic($Vo);
	}
	
	public function selectByKey(ProductAttributeVo $Vo){
		return  $this->attributeDao->selectByKey($Vo);
	}
	
	public function update(ProductAttributeVo $Vo){
		return  $this->attributeDao->updateDynamicByKey($Vo);
	}
	
	public function delete(ProductAttributeVo $Vo){
		return  $this->attributeDao->deleteByKey($Vo);
	}

	public function getAllProductAttribute (){
		return$this->attributeDao->selectAll();
	}
	
	
}
