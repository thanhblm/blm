<?php

namespace common\services\tax;

use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\extend\dao\TaxRateInfoExtendDao;
use common\services\base\BaseService;
use common\persistence\extend\vo\TaxRateInfoExtendVo;

class TaxRateInfoService extends BaseService{
	private $extendDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->extendDao = new TaxRateInfoExtendDao($this->context);
	}
	public function selectByKey(TaxRateInfoVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(TaxRateInfoVo $vo){
		return $this->extendDao->selectByFilter( $vo );
	}
	public function countByFilter(TaxRateInfoVo $vo){
		return $this->extendDao->countByFilter( $vo );
	}
	public function createTaxRateInfo(TaxRateInfoVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}
	public function updateTaxRateInfo(TaxRateInfoVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}
	public function search(TaxRateInfoExtendVo$vo){
		return $this->extendDao->search($vo);
	}
	public function searchCount(TaxRateInfoExtendVo $vo){
		return $this->extendDao->searchCount($vo);
	}
	public function deleteTaxRateInfo(TaxRateInfoVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}
	public function selectAll(){
		return $this->extendDao->selectAll();
	}
	public function selectByFilterWithPriority(TaxRateInfoExtendVo $vo){
		return $this->extendDao->selectByFilterWithPriority($vo);
	}
}