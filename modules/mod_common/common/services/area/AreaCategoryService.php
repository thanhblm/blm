<?php

namespace common\services\area;

use common\persistence\base\vo\AreaCategoryVo;
use common\persistence\extend\dao\AreaCategoryExtendDao;
use core\utils\AppUtil;

class AreaCategoryService{
	private $areaCategoryDao;

	public function __construct(){
		$this->areaCategoryDao = new AreaCategoryExtendDao();
	}

	public function deleteAreaCategoryByCatId($catId){
		if (AppUtil::isEmptyString($catId)) {
			return;
		}

		$areaCategoryVo = new AreaCategoryVo();
		$areaCategoryVo->categoryId = $catId;
		$this->areaCategoryDao->deleteAreaCategoryByCatId($areaCategoryVo);
	}

	public function selectByKey(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->selectByKey($areaCategoryVo);
		return $result;
	}

	public function selectAll(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->selectAll($areaCategoryVo);
		return $result;
	}

	public function selectByFilter(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->selectByFilter($areaCategoryVo);
		return $result;
	}

	public function countByFilter(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->countByFilter($areaCategoryVo);
		return $result;
	}

	public function insertDynamic(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->insertDynamic($areaCategoryVo);
		return $result;
	}

	public function insertDynamicWithId(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->insertDynamicWithId($areaCategoryVo);
		return $result;
	}

	public function updateDynamicByKey(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->updateDynamicByKey($areaCategoryVo);
		return $result;
	}

	public function deleteByKey(AreaCategoryVo $areaCategoryVo = null){
		$result = $this->areaCategoryDao->deleteByKey($areaCategoryVo);
		return $result;
	}
}