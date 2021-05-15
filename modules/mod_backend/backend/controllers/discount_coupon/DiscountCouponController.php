<?php

namespace backend\controllers\discount_coupon;

use common\model\discount\ApplicableProductMo;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\extend\vo\DiscountCouponExtendVo;
use common\persistence\extend\vo\DiscountCouponProductExtendVo;
use common\services\discount_coupon\DiscountCouponService;
use common\services\product\ProductService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;
use core\Lang;

class DiscountCouponController extends PagingController {
	public $discountCoupons;
	public $discountCoupon;
	public $id;
	public $applicableList;
	public $applicableProducts;
	public $applicableProduct;
	private $discountCouponService;
	private $productService;
	public $productList;
	public $categoryList;
	public $selectList;
	public function __construct() {
		parent::__construct ();
		$this->filter = new DiscountCouponExtendVo ();
		$this->discountCoupon = new DiscountCouponExtendVo ();
		$this->discountCoupons = new Paging ();
		$this->discountCouponService = new DiscountCouponService ();
		$this->productService = new ProductService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Discount Coupon Management";
		$this->applicableList = new BaseArray ( ApplicableProductMo::class );
		$this->applicableProducts = new BaseArray ( DiscountCouponProductExtendVo::class );
	}
	public function listView() {
		$this->getDiscountCoupons ();
		return "success";
	}
	public function search() {
		$this->getDiscountCoupons ();
		return "success";
	}
	public function addView() {
		$this->discountCoupon->status='active';
		$this->discountCoupon->maxUse=0;
		$this->discountCoupon->usePerCustomer=0;
		$this->discountCoupon->userPerProduct="any_product";
		$this->discountCoupon->minOrderTotal=0;
		$this->getApplicableList ();
		return "success";
	}
	public function add() {
		$this->getApplicableList ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->discountCoupon->crDate = date ( 'Y-m-d H:i:s' );
		$this->discountCoupon->crBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->discountCoupon->mdDate = date ( 'Y-m-d H:i:s' );
		$this->discountCoupon->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->discountCoupon->applicableProducts = $this->applicableProducts;
		// Add to the database.
		$this->formatToDatetime ();
		$discountCouponId = $this->discountCouponService->createDiscountCoupon ( $this->discountCoupon );
		$this->addActionMessage ( "The discount coupon added successfully" );
		$this->addExtraData ( "discountCouponId", $discountCouponId );
		return "success";
	}
	public function editView() {
		$this->getApplicableList ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load discount counpon.
		$this->prepareDiscountCoupon ();
		return "success";
	}
	public function edit() {
		$this->getApplicableList ();
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->discountCoupon->mdDate = date ( 'Y-m-d H:i:s' );
		$this->discountCoupon->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->discountCoupon->applicableProducts = $this->applicableProducts;
		// Convert date time to update database.
		// Save to the database.
		$this->formatToDatetime ();
		$this->discountCouponService->updateDiscountCoupon ( $this->discountCoupon );
		$this->addActionMessage ( "The discount coupon updated successfully" );
		$this->formatToShow ();
		return "success";
	}
	public function copyView() {
		$this->getApplicableList ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load discount counpon.
		$this->prepareDiscountCoupon ();
		return "success";
	}
	public function copy() {
		$this->getApplicableList ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.

		$this->discountCoupon->crDate = date ( 'Y-m-d H:i:s' );
		$this->discountCoupon->crBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->discountCoupon->mdDate = date ( 'Y-m-d H:i:s' );
		$this->discountCoupon->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->discountCoupon->applicableProducts = $this->applicableProducts;
		$this->formatToDatetime ();
		$discountCouponId = $this->discountCouponService->createDiscountCoupon ( $this->discountCoupon );
		$this->addActionMessage ( "The discount coupon updated successfully" );
		$this->addExtraData ( "discountCouponId", $discountCouponId );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Load system setting group.
		$filter = new DiscountCouponVo ();
		$filter->id = $this->id;
		$this->discountCoupon = $this->discountCouponService->getDiscountCouponByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Delete the system setting group.
		$filter = new DiscountCouponVo ();
		$filter->id = $this->id;
		$this->discountCouponService->deleteDiscountCoupon ( $filter );
		$this->addActionMessage ( "The discount coupon deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->discountCoupon->name )) {
			$this->addFieldError ( "discountCoupon[name]", "Name is required" );
		}
		if (AppUtil::isEmptyString ( $this->discountCoupon->code )) {
			$this->addFieldError ( "discountCoupon[code]", "Code is required" );
		}else{
			if ($isAdding) {
				$filter = new DiscountCouponExtendVo();
				$filter->code = $this->discountCoupon->code;
				$voResult = $this->discountCouponService->getDiscountCouponByFilter( $filter );
				if(count ( $voResult ) > 0) {
					$this->addFieldError ( "discountCoupon[code]", Lang::getWithFormat ( "{0} has already existed", $this->discountCoupon->code ) );
				}
			} else {
				$filter = new DiscountCouponExtendVo();
				$filter->id = $this->discountCoupon->id;
				$discountOld = $this->discountCouponService->getDiscountCouponByKey( $filter );
				if ($discountOld->code != $this->discountCoupon->code) {
					$filter = new DiscountCouponExtendVo();
					$filter->code = $this->discountCoupon->code;
					$voResult = $this->discountCouponService->getDiscountCouponByFilter ( $filter );
					if (count ( $voResult ) > 0) {
						$this->addFieldError ( "discountCoupon[code]", Lang::getWithFormat ( "{0} has already existed", $this->discountCoupon->code ) );
					}
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->discountCoupon->discount )) {
			$this->addFieldError ( "discountCoupon[discount]", "Discount is required" );
		} else {
			if (! is_numeric ( $this->discountCoupon->discount )) {
				$this->addFieldError ( "discountCoupon[discount]", "Discount  must be a number" );
			}
		}

		if (AppUtil::isEmptyString ( $this->discountCoupon->maxUse )) {
			$this->addFieldError ( "discountCoupon[maxUse]", "Max use is required" );
		} else {
			if (! is_numeric ( $this->discountCoupon->maxUse )) {
				$this->addFieldError ( "discountCoupon[maxUse]", "Max use must be a number" );
			}
		}
		if (AppUtil::isEmptyString ( $this->discountCoupon->usePerCustomer )) {
			$this->addFieldError ( "discountCoupon[usePerCustomer]", "Use per customer is required" );
		} else {
			if (! is_numeric ( $this->discountCoupon->usePerCustomer )) {
				$this->addFieldError ( "discountCoupon[usePerCustomer]", "Use per customer be a number" );
			}
		}
		if (AppUtil::isEmptyString ( $this->discountCoupon->userPerProduct )) {
			$this->addFieldError ( "discountCoupon[userPerProduct]", "User per product is required" );
		}
		if (!AppUtil::isEmptyString ( $this->discountCoupon->code )) {
			/* $regex="/^[a-z0-9 .\-]+$/i";
			if(preg_match($regex, $this->discountCoupon->code)==false){
				$this->addFieldError ( "discountCoupon[code]", "Code cannot contain special characters" );
			} */
			if(strpos($this->discountCoupon->code, " ") !== false){
				$this->addFieldError ( "discountCoupon[code]", "Code cannot contain spaces" );
			}
		}

		/*if (!AppUtil::isEmptyString ( $this->discountCoupon->name )) {
			$regex="/^[a-z0-9 .\-]+$/i";
			if(preg_match($regex, $this->discountCoupon->name)==false){
				$this->addFieldError ( "discountCoupon[name]", "Name cannot contain special characters" );
			}
		}*/
		if( $this->discountCoupon->discount > 99 || $this->discountCoupon->discount< 1 ){
			$this->addFieldError ( "discountCoupon[discount]", "Discount value must between 1 and 99" );
		}
		if (! is_numeric ( $this->discountCoupon->minOrderTotal )) {
				$this->addFieldError ( "discountCoupon[minOrderTotal]", "Min order total use must be a number" );
		}
		if (AppUtil::isEmptyString ( $this->discountCoupon->status )) {
			$this->addFieldError ( "discountCoupon[status]", "Status is required" );
		}
	}
	protected function prepareDiscountCoupon() {
		$filter = new DiscountCouponVo ();
		$filter->id = $this->id;
		$this->discountCoupon = $this->discountCouponService->getDiscountCouponByKey ( $filter );
		$this->applicableProducts = $this->discountCouponService->getDiscountCouponProductBykey ( $filter );
		// Convert date time data to show.
		$this->formatToShow ();
	}
	protected function getApplicableList() {
		// Get all product categories.
		$this->productList = $this->productService->getAllProducts ();
		$this->categoryList = $this->productService->getAllCategories ();
		/*
		 * $result = new BaseArray ( ApplicableProductMo::class );
		 * foreach ( $categories as $category ) {
		 * $item = new ApplicableProductMo ();
		 * $item->id = $category->id;
		 * $item->name = $category->name;
		 * $item->type = 0; // Is category.
		 * $result->add ( $item );
		 * // Get all product of the category.
		 * $products = $this->productService->getProductsByCatId ( $category->id );
		 * foreach ( $products as $product ) {
		 * $item = new ApplicableProductMo ();
		 * $item->id = $product->id;
		 * $item->name = "------" . $product->name;
		 * $item->type = 1; // Is product.
		 * $result->add ( $item );
		 * }
		 * }
		 * $this->applicableList = $result;
		 */
	}
	protected function getDiscountCoupons() {
		$filter = $this->buildFilter ();
		// Get total records of discountCoupons.
		$count = $this->discountCouponService->countDiscountCouponByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get discountCoupons.
		$discountCouponVos = $this->discountCouponService->getDiscountCouponByFilter ( $filter );
		foreach ( $discountCouponVos as $discountCouponVo ) {
			// Convert date time data to show.
			$discountCouponVo->validFrom = DateTimeUtil::mySqlStringDate2String ( $discountCouponVo->validFrom, DateTimeUtil::getDateFormat () );
			$discountCouponVo->validTo = DateTimeUtil::mySqlStringDate2String ( $discountCouponVo->validTo, DateTimeUtil::getDateFormat () );
			$discountCouponVo->status = AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $discountCouponVo->status );
		}
		$paging->records = $discountCouponVos;
		$this->discountCoupons = $paging;
	}
	protected function buildFilter() {
		return $this->buildBaseFilter ( "id asc" );
	}
	public function addProductCategory() {
		if (RequestUtil::get ( "type" ) == 'product') {
			$this->selectList = $this->productService->getAllProducts ();
		} else {
			$this->selectList = $this->productService->getAllCategories ();
		}
		return 'success';
	}
	private function formatToDatetime() {
		if (AppUtil::isEmptyString ( $this->discountCoupon->validFrom )) {
			$this->discountCoupon->validFrom = date ( 'Y-m-d H:i:s' );
		} else {
			$this->discountCoupon->validFrom = DateTimeUtil::string2MySqlDate ( $this->discountCoupon->validFrom, DateTimeUtil::getDateFormat () );
		}
		if (! AppUtil::isEmptyString ( $this->discountCoupon->validTo )) {
			$this->discountCoupon->validTo = DateTimeUtil::string2MySqlDate ( $this->discountCoupon->validTo, DateTimeUtil::getDateFormat () );
		}
	}
	private function formatToShow() {
		$this->discountCoupon->validFrom = DateTimeUtil::mySqlStringDate2String ( $this->discountCoupon->validFrom, DateTimeUtil::getDateFormat () );
		$this->discountCoupon->validTo = DateTimeUtil::mySqlStringDate2String ( $this->discountCoupon->validTo, DateTimeUtil::getDateFormat () );
	}
}
