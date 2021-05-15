<?php

namespace backend\controllers\currency;

use common\persistence\base\vo\CurrencyVo;
use common\persistence\extend\vo\CurrencyExtendVo;
use common\services\currency\CurrencyService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\ValidateUtil;

class CurrencyController extends PagingController {
	public $currencies;
	public $currency;
	public $code;
	private $currencyService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new CurrencyExtendVo ();
		$this->currency = new CurrencyVo ();
		$this->currencies = new Paging ();
		$this->currencyService = new CurrencyService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Currencies";
	}
	public function listView() {
		$this->getCurrencies ();
		return "success";
	}
	public function search() {
		$this->getCurrencies ();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->currency->crDate = date ( 'Y-m-d H:i:s' );
		$this->currency->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->currency->mdDate = date ( 'Y-m-d H:i:s' );
		$this->currency->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->currencyService->add ( $this->currency );
		$this->addActionMessage ( "The currency added successfully" );
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for editing" );
		}
		// Load system setting group.
		$filter = new CurrencyVo ();
		$filter->code = $this->code;
		$this->currency = $this->currencyService->getById ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->currency->mdDate = date ( 'Y-m-d H:i:s' );
		$this->currency->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->currencyService->update ( $this->currency );
		$this->addActionMessage ( "The currency updated successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for cloning" );
		}
		// Load currency.
		$filter = new CurrencyVo ();
		$filter->code = $this->code;
		$this->currency = $this->currencyService->getById ( $filter );
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save clone currency.
		$this->currency->crDate = date ( 'Y-m-d H:i:s' );
		$this->currency->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->currency->mdDate = date ( 'Y-m-d H:i:s' );
		$this->currency->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->currencyService->add ( $this->currency );
		$this->addActionMessage ( "The currency cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for deleting" );
		}
		// Load system setting group.
		$filter = new CurrencyVo ();
		$filter->code = $this->code;
		$this->currency = $this->currencyService->getById ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for deleting" );
		}
		// Delete the system setting group.
		$filter = new CurrencyVo ();
		$filter->code = $this->code;
		$this->currencyService->delete ( $filter );
		$this->addActionMessage ( "The currency deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->currency->code )) {
			$this->addFieldError ( "currency[code]", "Code is required" );
		} else {
			if ($isAdding) {
				$filter = new CurrencyExtendVo ();
				$filter->code = $this->currency->code;
				$currencies = $this->currencyService->getByFilter ( $filter );
				if (! empty ( $currencies && count ( $currencies ) > 0 )) {
					$this->addFieldError ( "currency[code]", "Code was existed" );
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->currency->name )) {
			$this->addFieldError ( "currency[name]", "Name is required" );
		}
		if (AppUtil::isEmptyString ( $this->currency->placement )) {
			$this->addFieldError ( "currency[placement]", "Placement is required" );
		} else {
			if (! in_array ( $this->currency->placement, array_keys ( ApplicationConfig::get ( "currency.placement.list" ) ) )) {
				$this->addFieldError ( "currency[placement]", "Placement is invalid" );
			}
		}
		if (AppUtil::isEmptyString ( $this->currency->decimal )) {
			$this->addFieldError ( "currency[decimal]", "Decimal is required" );
		} else {
			if (! ValidateUtil::isInt ( $this->currency->decimal, 0, 6 )) {
				$this->addFieldError ( "currency[decimal]", "Decimal must be a integer number" );
			}
		}
		if (AppUtil::isEmptyString ( $this->currency->status )) {
			$this->addFieldError ( "currency[status]", "Status is required" );
		} else {
			if (! in_array ( $this->currency->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "currency[status]", "Status is invalid" );
			}
		}
	}
	protected function getCurrencies() {
		$filter = $this->buildFilter ();
		// Get total records of currencies.
		$count = $this->currencyService->getCountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get currencies.
		$currencies = $this->currencyService->getByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $currencies );
		$this->currencies = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "code asc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(CurrencyExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		$placements = ApplicationConfig::get ( "currency.placement.list" );
		$mo->placement = AppUtil::arrayValue ( $placements, $mo->placement );
		$statuses = ApplicationConfig::get ( "common.status.list" );
		$mo->status = AppUtil::arrayValue ( $statuses, $mo->status );
		return $mo;
	}
	protected function format2Query(CurrencyExtendVo $mo) {
		$vo = AppUtil::cloneObj ( $mo );
		$vo->crDateFrom = DateTimeUtil::appendTime ( $vo->crDateFrom );
		$vo->crDateTo = DateTimeUtil::appendTime ( $vo->crDateTo, false );
		$vo->mdDateFrom = DateTimeUtil::appendTime ( $vo->mdDateFrom );
		$vo->mdDateTo = DateTimeUtil::appendTime ( $vo->mdDateTo, false );
		$vo->crDateFrom = DateTimeUtil::string2MySqlDate ( $vo->crDateFrom, DateTimeUtil::getDateTimeFormat () );
		$vo->crDateTo = DateTimeUtil::string2MySqlDate ( $vo->crDateTo, DateTimeUtil::getDateTimeFormat () );
		$vo->mdDateFrom = DateTimeUtil::string2MySqlDate ( $vo->mdDateFrom, DateTimeUtil::getDateTimeFormat () );
		$vo->mdDateTo = DateTimeUtil::string2MySqlDate ( $vo->mdDateTo, DateTimeUtil::getDateTimeFormat () );
		return $vo;
	}
	protected function formatList2Show($vos) {
		if (is_null ( $vos ) || count ( $vos ) == 0) {
			return array ();
		}
		$arr = array ();
		foreach ( $vos as $vo ) {
			$arr [] = $this->format2Show ( $vo );
		}
		return $arr;
	}
}