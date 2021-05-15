<?php

namespace common\services\tax_shipping_zone;

use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\dao\TaxShippingZoneInfoBaseDao;
use common\persistence\base\vo\StateVo;
use common\persistence\base\vo\TaxShippingZoneInfoVo;
use common\persistence\base\vo\TaxShippingZoneVo;
use common\persistence\extend\dao\StateExtendDao;
use common\persistence\extend\dao\TaxShippingZoneExtendDao;
use common\persistence\extend\dao\TaxShippingZoneInfoExtendDao;
use common\persistence\extend\vo\TaxShippingZoneExtendVo;
use common\persistence\extend\vo\TaxShippingZoneInfoExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class TaxShippingZoneService extends BaseService {
	private $taxShippingZoneDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->taxShippingZoneDao = new TaxShippingZoneExtendDao ();
	}
	public function getTaxShippingZoneByKey(TaxShippingZoneVo $filter) {
		return $this->taxShippingZoneDao->selectByKey ( $filter );
	}
	public function selectByName(TaxShippingZoneVo $filter) {
		return $this->taxShippingZoneDao->selectByFilter ( $filter );
	}
	public function getTaxShippingZoneByFilter(TaxShippingZoneExtendVo $filter) {
		return $this->taxShippingZoneDao->getByFilter ( $filter );
	}
	public function countTaxShippingZoneByFilter(TaxShippingZoneExtendVo $filter) {
		return $this->taxShippingZoneDao->getCountByFilter ( $filter );
	}
	public function updateTaxShippingZone(TaxShippingZoneVo $taxShippingZoneVo, BaseArray $taxShippingZoneInfos) {
		$sqlClient = new SqlMapClient ( $this->context );
		$sqlClient->startTransaction ();
		$taxShippingZoneDao = new TaxShippingZoneExtendDao ( $this->context, $sqlClient );
		$taxShippingZoneInfoDao = new TaxShippingZoneInfoBaseDao ( $this->context, $sqlClient );
		try {
			// delete all location of this tax shipping zone
			$filter = new TaxShippingZoneInfoVo ();
			$filter->taxShippingZoneId = $taxShippingZoneVo->id;
			$taxShippingZoneInfoVos = $taxShippingZoneInfoDao->selectByFilter ( $filter );
			foreach ( $taxShippingZoneInfoVos as $taxShippingZoneInfoVo ) {
				$taxShippingZoneInfoDao->deleteByKey ( $taxShippingZoneInfoVo );
			}
			// insert all new location of this tax shipping zone
			foreach ( $taxShippingZoneInfos->getArray () as $taxShippingZoneInfo ) {
				$taxShippingZoneInfo->taxShippingZoneId = $taxShippingZoneVo->id;
				$taxShippingZoneInfoVo = new TaxShippingZoneInfoVo ();
				AppUtil::copyProperties ( $taxShippingZoneInfo, $taxShippingZoneInfoVo );
				$taxShippingZoneInfoDao->insertDynamic ( $taxShippingZoneInfoVo );
			}
			// update tax shipping zone
			$taxShippingZoneDao->updateDynamicByKey ( $taxShippingZoneVo );
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return 1;
	}
	public function deleteTaxShippingZone(TaxShippingZoneVo $taxShippingZoneVo) {
		$sqlClient = new SqlMapClient ( $this->context );
		$sqlClient->startTransaction ();
		$taxShippingZoneDao = new TaxShippingZoneExtendDao ( $this->context, $sqlClient );
		$taxShippingZoneInfoDao = new TaxShippingZoneInfoExtendDao ( $this->context, $sqlClient );
		try {
			// delete all location of this tax shipping zone
			$filter = new TaxShippingZoneInfoVo ();
			$filter->taxShippingZoneId = $taxShippingZoneVo->id;
			$taxShippingZoneInfoVos = $taxShippingZoneInfoDao->selectByFilter ( $filter );
			foreach ( $taxShippingZoneInfoVos as $taxShippingZoneInfoVo ) {
				$taxShippingZoneInfoDao->deleteByKey ( $taxShippingZoneInfoVo );
			}
			// delete tax shipping zone
			$taxShippingZoneDao->deleteByKey ( $taxShippingZoneVo );
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return 1;
	}
	public function createTaxShippingZone(TaxShippingZoneVo $taxShippingZoneVo, BaseArray $taxShippingZoneInfos) {
		$sqlClient = new SqlMapClient ( $this->context );
		$sqlClient->startTransaction ();
		$taxShippingZoneDao = new TaxShippingZoneExtendDao ( $this->context, $sqlClient );
		$taxShippingZoneInfoDao = new TaxShippingZoneInfoExtendDao ( $this->context, $sqlClient );
		try {
			$taxShippingZoneId = $taxShippingZoneDao->insertDynamic ( $taxShippingZoneVo );
			// insert all new location
			foreach ( $taxShippingZoneInfos->getArray () as $taxShippingZoneInfo ) {
				$taxShippingZoneInfo->taxShippingZoneId = $taxShippingZoneId;
				$taxShippingZoneInfoVo = new TaxShippingZoneInfoVo ();
				AppUtil::copyProperties ( $taxShippingZoneInfo, $taxShippingZoneInfoVo );
				$taxShippingZoneInfoVo->id = null;
				$taxShippingZoneInfoDao->insertDynamic ( $taxShippingZoneInfoVo );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return 1;
	}
	public function getStateByFilter(StateVo $filter) {
		$stateDao = new StateBaseDao ();
		return $stateDao->selectByFilter ( $filter );
	}
	public function getTaxShippingZoneInfoById(TaxShippingZoneInfoExtendVo $filter) {
		$taxShippingZoneInfoDao = new TaxShippingZoneInfoExtendDao ();
		return $taxShippingZoneInfoDao->getByFilter ( $filter );
	}
	public function selectAll() {
		return $this->taxShippingZoneDao->selectAll ();
	}
	public function getStateListByCountryList($countryArray) {
		$stateDao = new StateExtendDao ();
		$result = array ();
		foreach ( $countryArray as $countryId ) {
			$filter = new StateVo ();
			$filter->country = $countryId;
			$filter->order_by='name asc';
			$result [$countryId] = $stateDao->selectByFilter ( $filter );
		}
		return $result;
	}
}