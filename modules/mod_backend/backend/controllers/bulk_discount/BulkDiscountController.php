<?php

namespace backend\controllers\bulk_discount;

use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\extend\vo\BulkDiscountProductExtendVo;
use common\services\bulk_discount\BulkDiscountService;
use common\services\product\ProductService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\ValidateUtil;

class BulkDiscountController extends PagingController {
	private $bulkDiscountService;
	private $productService;
	public $id;
	public $bulkDiscounts;
	public $bulkDiscount;
	public $products;
	public $bulkDiscountProducts;
	public $index;
	public function __construct() {
		parent::__construct ();
		$this->filter = new BulkDiscountVo ();
		$this->bulkDiscount = new BulkDiscountVo ();
		$this->bulkDiscountService = new BulkDiscountService ();
		$this->productService = new ProductService ();
		$this->bulkDiscountProducts = new BaseArray ( BulkDiscountProductExtendVo::class );
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Bulk Discount Management";
	}
	public function listView() {
		$this->getBulkDiscounts ();
		return "success";
	}
	public function search() {
		$this->getBulkDiscounts ();
		return "success";
	}
	public function addProduct() {
		$this->getProductList ();
		return "success";
	}
	public function addView() {
		$this->bulkDiscount->status='active';
		$this->getProductList ();
		return "success";
	}
	public function add() {
		$this->getProductList ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		$this->formatToDatetime ();
		$this->bulkDiscountService->addBulkDiscount ( $this->bulkDiscount, $this->bulkDiscountProducts );
		$this->addActionMessage ( Lang::get ( "Bulk Discount is created success" ) );
		return "success";
	}
	public function editView() {
		$this->getProductList ();
		$this->getBulkDiscountDetails ();
		return "success";
	}
	public function edit() {
		$this->getProductList ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		$this->formatToDatetime ();
		$this->bulkDiscountService->updateBulkDiscount ( $this->bulkDiscount, $this->bulkDiscountProducts );
		$this->addActionMessage ( Lang::get ( "Bulk Discount is updated successfully" ) );
		return "success";
	}
	public function copyView() {
		$this->getProductList ();
		$this->getBulkDiscountDetails ();
		$this->bulkDiscount->id = null;
		return "success";
	}
	public function copy() {
		$this->getProductList ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		$this->formatToDatetime ();
		$this->bulkDiscountService->addBulkDiscount ( $this->bulkDiscount, $this->bulkDiscountProducts );
		$this->addActionMessage ( Lang::get ( "Bulk Discount is cloned success" ) );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Bulk discount for deleting" ) );
		}
		$bulkDiscountVo = new BulkDiscountVo ();
		$bulkDiscountVo->id = $this->id;
		$this->bulkDiscount = $this->bulkDiscountService->getBulkDiscountByKey ( $bulkDiscountVo );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Bulk discount for deleting" ) );
		}
		$bulkDiscountVo = new BulkDiscountVo ();
		$bulkDiscountVo->id = $this->id;
		$this->bulkDiscountService->deleteBulkDiscount ( $bulkDiscountVo );
		$this->addActionMessage ( Lang::get ( "The Bulk discount deleted successfully" ) );
		return "success";
	}
	protected function getBulkDiscountDetails() {
		if (AppUtil::isEmptyString ( $this->id )) {
			$this->id = - 1;
		}
		$bulkDiscountVo = new BulkDiscountVo ();
		$bulkDiscountVo->id = $this->id;
		$this->bulkDiscount = $this->bulkDiscountService->getBulkDiscountByKey ( $bulkDiscountVo );
		if($this->bulkDiscount->status===null){
			$this->bulkDiscount->status='active';
		}
		$this->formatToShow ();
		$this->bulkDiscountProducts = $this->bulkDiscountService->getBulkDiscountProductByBulkDiscount ( $bulkDiscountVo );
	}
	private function formatToDatetime() {
		$this->bulkDiscount->validFrom = DateTimeUtil::string2MySqlDate ( $this->bulkDiscount->validFrom, DateTimeUtil::getDateFormat () );
		$this->bulkDiscount->validTo = DateTimeUtil::string2MySqlDate ( $this->bulkDiscount->validTo, DateTimeUtil::getDateFormat () );
	}
	private function formatToShow() {
		$this->bulkDiscount->validFrom = DateTimeUtil::mySqlStringDate2String ( $this->bulkDiscount->validFrom, DateTimeUtil::getDateFormat () );
		$this->bulkDiscount->validTo = DateTimeUtil::mySqlStringDate2String ( $this->bulkDiscount->validTo, DateTimeUtil::getDateFormat () );
	}
	private function getBulkDiscounts() {
		$filter = $this->buildFilter ();
		// Get total records of currencies.
		$count = $this->bulkDiscountService->countBulkDiscountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get currencies.
		$bulkDiscounts = $this->bulkDiscountService->getBulkDiscountByFilter ( $filter );
		// Convert some field to show.
		foreach ( $bulkDiscounts as $bulkDiscount ) {
			$bulkDiscount->status = AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $bulkDiscount->status );
		}
		$paging->records = $bulkDiscounts;
		$this->bulkDiscounts = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	private function validInput() {
		if (AppUtil::isEmptyString ( $this->bulkDiscount->name )) {
			$this->addFieldError ( "bulkDiscount[name]", Lang::get ( "Name is required." ) );
		}
		if (AppUtil::isEmptyString ( $this->bulkDiscount->discount )) {
			$this->addFieldError ( "bulkDiscount[discount]", Lang::get ( "Discount is required." ) );
		} else {
			if (! ValidateUtil::isInt ( $this->bulkDiscount->discount, 1, 99 )) {
				$this->addFieldError ( "bulkDiscount[discount]", Lang::get ( "Discount must be integer number in range [1-99]" ) );
			}
		}/*
		if ( AppUtil::isEmptyString ( $this->bulkDiscount->validFrom ) || ! ValidateUtil::isDate ( $this->bulkDiscount->validFrom )) {
			$this->addFieldError ( "bulkDiscount[validFrom]", Lang::get ( "From is invalid date" ) );
		}
		if ( AppUtil::isEmptyString ( $this->bulkDiscount->validTo ) || ! ValidateUtil::isDate ( $this->bulkDiscount->validTo )) {
			$this->addFieldError ( "bulkDiscount[validTo]", Lang::get ( "To is invalid date" ) );
		}*/
		if (AppUtil::isEmptyString ( $this->bulkDiscount->status )) {
			$this->addFieldError ( "bulkDiscount[status]", Lang::get ( "Status is required." ) );
		}
		if(count($this->bulkDiscountProducts->getArray())==0){
			$this->addActionError(Lang::get("Product discount is required"));
		}else{
			foreach ($this->bulkDiscountProducts->getArray() as $product){
				if(AppUtil::isEmptyString($product->productId) || AppUtil::isEmptyString($product->quantity)){
					$this->addActionError(Lang::get("Product quantity is required"));
					break;
				}
			}
		}
		
	}
	private function getProductList() {
		$this->products = $this->productService->getAllProducts ();
	}
}