<?php

namespace common\services\area;

use common\persistence\base\dao\AreaCategoryBaseDao;
use common\persistence\base\vo\AreaVo;
use common\persistence\extend\dao\AreaExtendDao;
use common\persistence\extend\vo\AreaExtendVo;

class AreaService{
	private $areaDao;

	public function __construct(){
		$this->areaDao = new AreaExtendDao();
	}

	public function getAll(){
		return $this->areaDao->selectAll();
	}

	public function selectByFilter(AreaVo $filter){
		return $this->areaDao->selectByFilter($filter);
	}

	public function countByFilter(AreaVo $filter){
		return $this->areaDao->countByFilter($filter);
	}

	public function add(AreaVo $contactVo){
		return $this->areaDao->insertDynamic($contactVo);
	}

	public function update(AreaVo $contactVo){
		return $this->areaDao->updateDynamicByKey($contactVo);
	}

	public function delete(AreaVo $contactVo){
		return $this->areaDao->deleteByKey($contactVo);
	}

	public function selectByKey(AreaVo $contactVo){
		return $this->areaDao->selectByKey($contactVo);
	}

	public function getAreaFull(AreaExtendVo $filter){
		return $this->areaDao->getAreaFull($filter);
	}

}