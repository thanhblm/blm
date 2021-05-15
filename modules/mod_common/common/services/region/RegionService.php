<?php

namespace common\services\region;

use common\persistence\base\dao\PaymentMethodBaseDao;
use common\persistence\base\dao\RegionCountryBaseDao;
use common\persistence\base\dao\RegionPaymentMethodBaseDao;
use common\persistence\base\dao\RegionShippingMethodBaseDao;
use common\persistence\base\dao\ShippingMethodBaseDao;
use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\RegionCountryVo;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\dao\RegionCountryExtendDao;
use common\persistence\extend\dao\RegionExtendDao;
use common\persistence\extend\dao\RegionPaymentMethodExtendDao;
use common\persistence\extend\dao\RegionShippingMethodExtendDao;
use common\persistence\extend\dao\StateExtendDao;
use common\persistence\extend\vo\RegionExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;

class RegionService extends BaseService {
	private $regionDao;
	private $stateDao;
	private $shippingMethodDao;
	private $paymentMethodDao;
	private $regionShippingMethodDao;
	private $regionPaymentMethodDao;
	private $regionCountryDao;
	private $sqlMapClient;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->regionDao = new RegionExtendDao ();
		$this->stateDao = new StateBaseDao ();
		$this->shippingMethodDao = new ShippingMethodBaseDao ();
		$this->paymentMethodDao = new PaymentMethodBaseDao ();
		$this->regionCountryDao = new RegionCountryBaseDao ();
		$this->regionShippingMethodDao = new RegionShippingMethodExtendDao ();
		$this->regionPaymentMethodDao = new RegionPaymentMethodExtendDao ();
	}
	public function getAll() {
		return $this->regionDao->selectAll ();
	}
	public function getByFilter(RegionExtendVo $filter) {
		return $this->regionDao->getByFilter ( $filter );
	}
	public function getCountByFilter(RegionExtendVo $filter) {
		return $this->regionDao->getCountByFilter ( $filter );
	}
	public function add(RegionVo $regionVo) {
		return $this->regionDao->insertDynamic ( $regionVo );
	}
	public function update(RegionVo $regionVo) {
		return $this->regionDao->updateDynamicByKey ( $regionVo );
	}
	public function delete(RegionVo $regionVo) {
		return $this->regionDao->deleteByKey ( $regionVo );
	}
	public function addRegion(RegionVo $regionVo, BaseArray $regionCountries, BaseArray $regionShippingMethods, BaseArray $regionPaymentMethods) {
		$sqlMapClient = new SqlMapClient ( $this->context );
		$regionDao = new RegionExtendDao ( $this->context, $sqlMapClient );
		$regionCountryDao = new RegionCountryBaseDao ( $this->context, $sqlMapClient );
		$regionShippingMethodDao = new RegionShippingMethodBaseDao ( $this->context, $sqlMapClient );
		$regionPaymentMethodDao = new RegionPaymentMethodBaseDao ( $this->context, $sqlMapClient );
		$sqlMapClient->startTransaction ();
		try {
			// Check if fallback region of the current region is Yes or No?
			// If the fallback region of the current region is Yes then update all other region to No.
			if ("yes" === $regionVo->fallbackRegion) {
				$updateFilter = new RegionVo ();
				$updateFilter->fallbackRegion = "no";
				$regionDao->updateAll( $updateFilter );
			}
			$regionId = $regionDao->insertDynamic ( $regionVo );
			foreach ( $regionCountries->getArray () as $regionCountry ) {
				$regionCountry->regionId = $regionId;
				$regionCountryDao->insertDynamic ( $regionCountry );
			}
			foreach ( $regionShippingMethods->getArray () as $regionShippingMethod ) {
				$regionShippingMethod->regionId = $regionId;
				$regionShippingMethod->settingInfo = base64_decode ( $regionShippingMethod->settingInfo );
				$regionShippingMethodDao->insertDynamic ( $regionShippingMethod );
			}
			foreach ( $regionPaymentMethods->getArray () as $regionPaymentMethod ) {
				$regionPaymentMethod->regionId = $regionId;
				$regionPaymentMethod->settingInfo = base64_decode ( $regionPaymentMethod->settingInfo );
				$regionPaymentMethodDao->insertDynamic ( $regionPaymentMethod );
			}
			$sqlMapClient->endTransaction ();
			return $regionId;
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function updateRegion(RegionVo $regionVo, BaseArray $regionCountries, BaseArray $regionShippingMethods, BaseArray $regionPaymentMethods) {
		$sqlMapClient = new SqlMapClient ( $this->context );
		$regionDao = new RegionExtendDao ( $this->context, $sqlMapClient );
		$regionCountryExtendDao = new RegionCountryExtendDao ( $this->context, $sqlMapClient );
		$regionShippingMethodExtendDao = new RegionShippingMethodExtendDao ( $this->context, $sqlMapClient );
		$regionPaymentMethodExtendDao = new RegionPaymentMethodExtendDao ( $this->context, $sqlMapClient );
		$sqlMapClient->startTransaction ();
		try {
			// Check if fallback region of the current region is Yes or No?
			// If the fallback region of the current region is Yes then update all other region to No.
			if ("yes" === $regionVo->fallbackRegion) {
				$updateFilter = new RegionVo();
				$updateFilter->fallbackRegion = "no";
				$regionDao->updateAll( $updateFilter );
			}
			$regionDao->updateDynamicByKey ( $regionVo );
			// delete old and insert new region country by regionId
			$regionCountryVo = new RegionCountryVo ();
			$regionCountryVo->regionId = $regionVo->id;
			$regionCountryExtendDao->deleteRegionCountryByFilter ( $regionCountryVo );
			foreach ( $regionCountries->getArray () as $regionCountry ) {
				$regionCountry->regionId = $regionVo->id;
				$regionCountryExtendDao->insertDynamic ( $regionCountry );
			}
			// delete old and insert new region shipping method by regionId
			$regionShippingMethodVo = new RegionShippingMethodVo ();
			$regionShippingMethodVo->regionId = $regionVo->id;
			$regionShippingMethodExtendDao->deleteRegionShippingMethodByFilter ( $regionShippingMethodVo );
			foreach ( $regionShippingMethods->getArray () as $regionShippingMethod ) {
				$regionShippingMethod->regionId = $regionVo->id;
				$regionShippingMethod->settingInfo = base64_decode ( $regionShippingMethod->settingInfo );
				$regionShippingMethodExtendDao->insertDynamic ( $regionShippingMethod );
			}
			// delete old and insert new region payment method by regionId
			$regionPaymentMethodVo = new RegionPaymentMethodVo ();
			$regionPaymentMethodVo->regionId = $regionVo->id;
			$regionPaymentMethodExtendDao->deleteRegionPaymentMethodByFilter ( $regionPaymentMethodVo );
			foreach ( $regionPaymentMethods->getArray () as $regionPaymentMethod ) {
				$regionPaymentMethod->regionId = $regionVo->id;
				$regionPaymentMethod->settingInfo = base64_decode ( $regionPaymentMethod->settingInfo );
				$regionPaymentMethodExtendDao->insertDynamic ( $regionPaymentMethod );
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function deleteRegion(RegionVo $regionVo) {
		$sqlMapClient = new SqlMapClient ( $this->context );
		$regionCountryExtendDao = new RegionCountryExtendDao ( $this->context, $sqlMapClient );
		$regionShippingMethodExtendDao = new RegionShippingMethodExtendDao ( $this->context, $sqlMapClient );
		$regionPaymentMethodExtendDao = new RegionPaymentMethodExtendDao ( $this->context, $sqlMapClient );
		$sqlMapClient->startTransaction ();
		try {
			$regionCountryVo = new RegionCountryVo ();
			$regionCountryVo->regionId = $regionVo->id;
			$regionCountryExtendDao->deleteRegionCountryByFilter ( $regionCountryVo );
			$regionShippingMethodVo = new RegionShippingMethodVo ();
			$regionShippingMethodVo->regionId = $regionVo->id;
			$regionShippingMethodExtendDao->deleteRegionShippingMethodByFilter ( $regionShippingMethodVo );
			$regionPaymentMethodVo = new RegionPaymentMethodVo ();
			$regionPaymentMethodVo->regionId = $regionVo->id;
			$regionPaymentMethodExtendDao->deleteRegionPaymentMethodByFilter ( $regionPaymentMethodVo );
			$this->regionDao->deleteByKey ( $regionVo );
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	public function getById(RegionVo $regionVo) {
		return $this->regionDao->selectByKey ( $regionVo );
	}
	public function getStateByFilter(StateVo $stateVo) {
		return $this->stateDao->selectByFilter ( $stateVo );
	}
	public function getStateByCountryId(StateVo $stateVo) {
		$stateExtendDao = new StateExtendDao ();
		return $stateExtendDao->getStateByCountryId ( $stateVo );
	}
	public function getAllShippingMethod() {
		$shippingMethodVo = new ShippingMethodVo ();
		$shippingMethodVo->status = "active";
		return $this->shippingMethodDao->selectByFilter ( $shippingMethodVo );
	}
	public function getAllPaymentMethod() {
		$paymentMethodVo = new PaymentMethodVo ();
		$paymentMethodVo->status = "active";
		return $this->paymentMethodDao->selectByFilter ( $paymentMethodVo );
	}
	public function getRegionCountryByFilter(RegionCountryVo $regionCountryVo) {
		return $this->regionCountryDao->selectByFilter ( $regionCountryVo );
	}
	public function addRegionCountry(RegionCountryVo $regionCountryVo) {
		return $this->regionCountryDao->insertDynamic ( $regionCountryVo );
	}
	public function updateRegionCountry(RegionCountryVo $regionCountryVo) {
		return $this->regionCountryDao->updateDynamicByKey ( $regionCountryVo );
	}
	public function deleteRegionCountry(RegionCountryVo $regionCountryVo) {
		return $this->regionCountryDao->deleteByKey ( $regionCountryVo );
	}
	public function getRegionShippingMethodByFilter(RegionShippingMethodVo $regionShippingMethodVo) {
		return $this->regionShippingMethodDao->selectByFilter ( $regionShippingMethodVo );
	}
	public function addRegionShippingMethod(RegionShippingMethodVo $regionShippingMethodVo) {
		return $this->regionShippingMethodDao->insertDynamic ( $regionShippingMethodVo );
	}
	public function updateRegionShippingMethod(RegionShippingMethodVo $regionShippingMethodVo) {
		return $this->regionShippingMethodDao->updateDynamicByKey ( $regionShippingMethodVo );
	}
	public function deleteRegionShippingMethod(RegionShippingMethodVo $regionShippingMethodVo) {
		return $this->regionShippingMethodDao->deleteByKey ( $regionShippingMethodVo );
	}
	public function getRegionPaymentMethodByFilter(RegionPaymentMethodVo $regionPaymentMethodVo) {
		return $this->regionPaymentMethodDao->selectByFilter ( $regionPaymentMethodVo );
	}
	public function addRegionPaymentMethod(RegionPaymentMethodVo $regionPaymentMethodVo) {
		return $this->regionPaymentMethodDao->insertDynamic ( $regionPaymentMethodVo );
	}
	public function updateRegionPaymentMethod(RegionPaymentMethodVo $regionPaymentMethodVo) {
		return $this->regionPaymentMethodDao->updateDynamicByKey ( $regionPaymentMethodVo );
	}
	public function deleteRegionPaymentMethod(RegionPaymentMethodVo $regionPaymentMethodVo) {
		return $this->regionPaymentMethodDao->deleteByKey ( $regionPaymentMethodVo );
	}
	public function getShippingMethodByRegion(RegionVo $regionVo) {
		return $this->regionShippingMethodDao->getShippingMethodByRegion ( $regionVo );
	}
	public function getPaymentMethodByRegion(Regionvo $regionVo) {
		return $this->regionPaymentMethodDao->getPaymentMethodByRegion ( $regionVo );
	}
}