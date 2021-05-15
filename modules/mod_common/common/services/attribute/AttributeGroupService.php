<?php
namespace common\services\attribute;
use common\filter\attribute_group\AttributeGroupFilter;
use common\persistence\base\vo\AttrGroupVo;
use common\persistence\extend\dao\AttrGroupExtendDao;
use common\services\base\BaseService;
use core\config\ApplicationConfig;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class AttributeGroupService extends BaseService {
	public $attrGroupDao;
	public function __construct() {
		parent::__construct ();
		$this->attrGroupDao = new AttrGroupExtendDao();
	}
	
	public function getByFilter(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->selectByFilter($attrGroupVo);
	}
	public function getAll(){
		return  $this->attrGroupDao->selectAll();
	}

	public function getCountByFilter(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->countByFilter($attrGroupVo);
	}
	public function search(AttributeGroupFilter $filter){
		return  $this->attrGroupDao->search($filter);
	}
	public function searchCount(AttributeGroupFilter $filter){
		return  $this->attrGroupDao->searchCount($filter);
	}
	
	public function add(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->insertDynamic($attrGroupVo);
	}
	
	public function selectByKey(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->selectByKey($attrGroupVo);
	}
	
	public function update(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->updateDynamicByKey($attrGroupVo);
	}
	
	public function delete(AttrGroupVo $attrGroupVo){
		return  $this->attrGroupDao->deleteByKey($attrGroupVo);
	}
}
