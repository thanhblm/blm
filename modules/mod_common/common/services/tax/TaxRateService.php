<?php

namespace common\services\tax;

use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\base\vo\TaxRateVo;
use common\persistence\extend\dao\TaxRateExtendDao;
use common\persistence\extend\dao\TaxRateInfoExtendDao;
use common\persistence\extend\vo\TaxRateExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\Lang;

class TaxRateService extends BaseService {
	private $extendDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->extendDao = new TaxRateExtendDao ( $this->context );
	}
	public function selectByKey(TaxRateVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(TaxRateVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function countByFilter(TaxRateVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function createTaxRate(TaxRateVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function updateTaxRate(TaxRateVo $vo) {
		return $this->extendDao->updateDynamicByKey ( $vo );
	}
	public function search(TaxRateExtendVo $vo) {
		return $this->extendDao->search ( $vo );
	}
	public function searchCount(TaxRateExtendVo $vo) {
		return $this->extendDao->searchCount ( $vo );
	}
	public function deleteTaxRate(TaxRateVo $vo) {
		return $this->extendDao->deleteByKey ( $vo );
	}
	public function addTaxRate(TaxRateVo $vo, BaseArray $taxInfos) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$taxDao = new TaxRateExtendDao ( null, $sqlMapClient );
			$vo->name = Lang::get($vo->name);
			$taxRateId = $taxDao->insertDynamic ( $vo );
			$taxInfoDao = new TaxRateInfoExtendDao ( null, $sqlMapClient );
			foreach ( $taxInfos->getArray () as $taxInfo ) {
				$taxInfo->taxRateId = $taxRateId;
				$taxInfo->name = Lang::get ( $taxInfo->name );
				$taxInfoDao->insertDynamic ( $taxInfo );
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function updateWithInfo(TaxRateVo $vo, BaseArray $taxInfos) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$taxDao = new TaxRateExtendDao ( null, $sqlMapClient );
			$vo->name = Lang::get($vo->name);
			$taxDao->updateDynamicByKey ( $vo );
			$taxInfoDao = new TaxRateInfoExtendDao ( null, $sqlMapClient );
			$taxRateInfoVo = new TaxRateInfoVo ();
			$taxRateInfoVo->taxRateId = $vo->id;
			$taxInfoDao->deleteWithTaxRateId ( $taxRateInfoVo );
			foreach ( $taxInfos->getArray () as $taxInfo ) {
				$taxInfo->taxRateId = $vo->id;
				$taxInfo->name = Lang::get ( $taxInfo->name );
				$taxInfoDao->insertDynamic ( $taxInfo );
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function deleteWithInfo(TaxRateVo $vo) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$taxDao = new TaxRateExtendDao ( null, $sqlMapClient );
			$taxInfoDao = new TaxRateInfoExtendDao ( null, $sqlMapClient );
			$taxRateInfoVo = new TaxRateInfoVo ();
			$taxRateInfoVo->taxRateId = $vo->id;
			$taxInfoDao->deleteWithTaxRateId ( $taxRateInfoVo );
			$taxDao->deleteByKey ( $vo );
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function selectAll() {
		return $this->extendDao->selectAll ();
	}
	public function getTaxRateByClass(TaxRateVo $taxRateVo) {
		return $this->extendDao->getTaxRateByClass ( $taxRateVo );
	}
}