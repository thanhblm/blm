<?php
namespace common\services\attribute;
use common\filter\attribute_group\AttributeFilter;
use common\persistence\extend\dao\AttributeExtendDao;
use common\persistence\extend\dao\ProductAttributeExtendDao;
use common\persistence\extend\vo\AttributeExtendVo;
use common\services\base\BaseService;
use core\database\SqlMapClient;
use core\config\ApplicationConfig;

class AttributeService extends BaseService {
	public $attributeDao;
	public function __construct() {
		parent::__construct ();
		$this->attributeDao = new AttributeExtendDao();
	}
	
	public function getByFilter(AttributeExtendVo $Vo){
		return  $this->attributeDao->selectByFilter($Vo);
	}
	
	public function getCountByFilter(AttributeExtendVo $Vo){
		return  $this->attributeDao->countByFilter($Vo);
	}
	public function search(AttributeFilter $filter){
		return  $this->attributeDao->search($filter);
	}
	public function searchCount(AttributeFilter $filter){
		return  $this->attributeDao->searchCount($filter);
	}
	
	public function searchByKey(AttributeFilter $filter){
		return  $this->attributeDao->searchByKey($filter);
	}
	
	public function add(AttributeExtendVo $Vo){
		return  $this->attributeDao->insertDynamic($Vo);
	}
	
	public function selectByKey(AttributeExtendVo $Vo){
		return  $this->attributeDao->selectByKey($Vo);
	}
	
	public function update(AttributeExtendVo $Vo){
		return  $this->attributeDao->updateDynamicByKey($Vo);
	}
	
	public function delete(AttributeExtendVo $Vo){
		return  $this->attributeDao->deleteByKey($Vo);
	}

	public function remove($productId,$attributeId){
		$productAttributeDao = new ProductAttributeExtendDao();
		return $productAttributeDao->deleteProductAttributeByAttributeId($productId,$attributeId);
	}

	//$listId is array ID;
	public function getByIds($listId){
		return  $this->attributeDao->getByIds($listId);
	}
	
}
