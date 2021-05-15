<?php

namespace common\services\order;

use common\services\base\BaseService;



use common\persistence\base\dao\CartInfoBaseDao;
use common\persistence\base\vo\CartInfoVo;

class CartInfoService extends BaseService {
	private $cartInfoDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->cartInfoDao = new CartInfoBaseDao();
	}
	public function getCartInfoByKey(CartInfoVo $filter){
		return $this->cartInfoDao->selectByKey($filter);
	}
	
	public function getCartInfoByFilter(CartInfoVo $filter) {
		return $this->cartInfoDao->selectByFilter( $filter );
	}
	public function countCartInfoByFilter(CartInfoVo $filter) {
		return $this->cartInfoDao->countByFilter($filter);
	}
	public function addCartInfo(CartInfoVo $filter) {
		return $this->cartInfoDao->insertDynamic($filter);
	}
	public function updateCartInfo(CartInfoVo $filter) {
		return $this->cartInfoDao->updateDynamicByKey($filter);
	}
	public function deleteCartInfo(CartInfoVo $filter) {
		return $this->cartInfoDao->deleteByKey($filter);
	}
}