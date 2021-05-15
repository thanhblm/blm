<?php

namespace common\services\discount_coupon;

use common\persistence\base\dao\DiscountCouponProductBaseDao;
use common\persistence\base\vo\DiscountCouponProductVo;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\extend\dao\DiscountCouponExtendDao;
use common\persistence\extend\dao\DiscountCouponProductExtendDao;
use common\persistence\extend\dao\OrderSurchargeExtendDao;
use common\persistence\extend\vo\CustomerSurchargeVo;
use common\persistence\extend\vo\DiscountCouponExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;

class DiscountCouponService extends BaseService {
	private $discountCouponDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->discountCouponDao = new DiscountCouponExtendDao ();
	}
	public function getDiscountCouponByKey(DiscountCouponVo $filter) {
		return $this->discountCouponDao->selectByKey ( $filter );
	}
	public function selectByName(DiscountCouponVo $filter) {
		return $this->discountCouponDao->selectByFilter ( $filter );
	}
	public function getDiscountCouponByFilter(DiscountCouponExtendVo $filter) {
		return $this->discountCouponDao->getByFilter ( $filter );
	}
	
	public function getDiscountCouponByProduct(DiscountCouponExtendVo $filter) {
		return $this->discountCouponDao->getDiscountCouponByProduct( $filter );
	}
	
	public function countDiscountCouponByFilter(DiscountCouponExtendVo $filter) {
		return $this->discountCouponDao->getCountByFilter ( $filter );
	}
	public function updateDiscountCoupon(DiscountCouponVo $discountCouponVo) {
		$sqlClient = new SqlMapClient ();
		$sqlClient->startTransaction ();
		$discountCouponDao = new DiscountCouponExtendDao ( $this->context, $sqlClient );
		$discountCouponProductDao = new DiscountCouponProductBaseDao ( $this->context, $sqlClient );
		try {
			$discountCouponDao->updateDynamicByKey ( $discountCouponVo );
			// delete old applicableProducts
			$filter = new DiscountCouponProductVo ();
			$filter->discountCouponId = $discountCouponVo->id;
			$discountCouponProducts = $discountCouponProductDao->selectByFilter ( $filter );
			foreach ( $discountCouponProducts as $discountCouponProductVo ) {
				$discountCouponProductDao->deleteByKey ( $discountCouponProductVo );
			}
			// insert new applicableProducts
			foreach ( $discountCouponVo->applicableProducts->getArray () as $applicableProduct ) {
				$applicableProduct->discountCouponId = $discountCouponVo->id;
				$discountCouponProductDao->insertDynamic ( $applicableProduct );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return 1;
	}
	public function deleteDiscountCoupon(DiscountCouponVo $discountCouponVo) {
		$sqlClient = new SqlMapClient ();
		$sqlClient->startTransaction ();
		$discountCouponDao = new DiscountCouponExtendDao ( $this->context, $sqlClient );
		$discountCouponProductDao = new DiscountCouponProductBaseDao ( $this->context, $sqlClient );
		try {
			// delete all relative applicableProducts in discount_coupon_product tbl
			$filter = new DiscountCouponProductVo ();
			$filter->discountCouponId = $discountCouponVo->id;
			$discountCouponProducts = $discountCouponProductDao->selectByFilter ( $filter );
			foreach ( $discountCouponProducts as $discountCouponProductVo ) {
				$discountCouponProductDao->deleteByKey ( $discountCouponProductVo );
			}
			$discountCouponDao->deleteByKey ( $discountCouponVo );
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return 1;
	}
	public function createDiscountCoupon(DiscountCouponVo $discountCouponVo) {
		$sqlClient = new SqlMapClient ();
		$sqlClient->startTransaction ();
		$discountCouponDao = new DiscountCouponExtendDao ( $this->context, $sqlClient );
		$discountCouponProductDao = new DiscountCouponProductBaseDao ( $this->context, $sqlClient );
		try {
			$discountCouponId = $discountCouponDao->insertDynamic ( $discountCouponVo );
			foreach ( $discountCouponVo->applicableProducts->getArray () as $applicableProduct ) {
				$applicableProduct->discountCouponId = $discountCouponId;
				$discountCouponProductDao->insertDynamic ( $applicableProduct );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return $discountCouponId;
	}
	public function getDiscountCouponProductBykey(DiscountCouponVo $discountCouponVo) {
		$applicableProducts = new BaseArray ( DiscountCouponProductVo::class );
		$discountCouponProductDao = new DiscountCouponProductExtendDao ();
		$filter = new DiscountCouponProductVo ();
		$filter->discountCouponId = $discountCouponVo->id;
		$discountCouponProducts = $discountCouponProductDao->selectByFilter ( $filter );
		foreach ( $discountCouponProducts as $discountCouponProductVo ) {
			$applicableProducts->add ( $discountCouponProductVo );
		}
		return $applicableProducts;
	}
	public function getAllDiscountCouponProduct(DiscountCouponProductVo $discountCouponProductVo) {
		$discountCouponProductDao = new DiscountCouponProductBaseDao ();
		return $discountCouponProductDao->selectByFilter ( $discountCouponProductVo );
	}
	public function getByCode(DiscountCouponVo $discountCouponVo) {
		return $this->discountCouponDao->getByCode ( $discountCouponVo );
	}
	public function getDiscountCouponUseByCustomer(CustomerSurchargeVo $customerSurchargeVo) {
		$orderSurchargeDao = new OrderSurchargeExtendDao ();
		return $orderSurchargeDao->getDiscountCouponUseByCustomer ( $customerSurchargeVo );
	}
}