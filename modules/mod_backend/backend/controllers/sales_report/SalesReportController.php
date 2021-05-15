<?php

namespace backend\controllers\sales_report;

use backend\persistence\extend\vo\CountryReportVo;
use backend\persistence\extend\vo\OverviewReportVo;
use backend\persistence\extend\vo\SalesReportFilterVo;
use backend\service\SalesReportService;
use common\persistence\extend\vo\CurrencyExtendVo;
use common\persistence\extend\vo\RegionExtendVo;
use common\services\currency\CurrencyService;
use common\services\order\OrderStatusService;
use common\services\region\RegionService;
use core\Controller;
use core\Lang;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\ValidateUtil;

class SalesReportController extends Controller {
	public $filter;
	public $regionList;
	public $showRegionList;
	public $orderStatusList;
	public $currencyList;
	public $countryList;
	public $overview;
	public $orders;
	public $topProducts;
	public $topCountries;
	private $salesReportService;
	public $inputFilePath;
	public $outputFileName;
	public function __construct() {
		parent::__construct ();
		$this->filter = new SalesReportFilterVo ();
		$this->salesReportService = new SalesReportService ();
	}
	public function show() {
		$this->prepareRegionList ();
		return "success";
	}
	public function export() {
		$this->validate ();
		$this->prepareRegionList ();
		if ($this->hasErrors ()) {
			return "input";
		}
		$this->prepareShowRegionList ();
		$this->prepareStatusList ();
		$this->prepareCurrencyList ();
		$this->convertFilterDate ();
		$this->getOverview ();
		$this->getTopCountries ();
		$this->getOrders ();
		$this->getTopProducts ();
		$this->getTopCountries ();
		$datas ["overview"] = $this->overview;
		$datas ["orderStatusList"] = $this->orderStatusList;
		$datas ["currencyList"] = $this->currencyList;
		$datas ["countryList"] = $this->countryList;
		$datas ["orderList"] = $this->orders;
		$datas ["topCountry"] = $this->topCountries;
		$datas ["topProduct"] = $this->topProducts;
		$datas ["filter"] = $this->filter;
		$this->inputFilePath = $this->salesReportService->exportReportExcel ( $datas, $this->showRegionList, "sale_reports" . AppUtil::getMicroTime () . ".xlsx" );
		$regionName = "";
		if (count ( $this->showRegionList ) > 1) {
			$regionName = "All";
		} else {
			$regionName = $this->showRegionList [0]->name;
		}
		$sdate = "";
		if (! AppUtil::isEmptyString ( $this->filter->startDate )) {
			$sdate = DateTimeUtil::mySqlStringDate2String ( $this->filter->startDate, "Y M d" );
		}
		if (! AppUtil::isEmptyString ( $this->filter->endDate )) {
			$sdate .= " - " . DateTimeUtil::mySqlStringDate2String ( $this->filter->endDate, "Y M d" );
		}
		$this->outputFileName = $sdate . " " . $regionName . " Sales Report.xlsx";
		return "success";
	}
	private function validate() {
		if (! ValidateUtil::isDate ( $this->filter->startDate )) {
			$this->addFieldError ( "filter.startDate", Lang::get ( "Invalid start date" ) );
		}
		if (! ValidateUtil::isDate ( $this->filter->endDate )) {
			$this->addFieldError ( "filter.endDate", Lang::get ( "Invalid end date" ) );
		}
		if (! ValidateUtil::isInt ( $this->filter->regionId )) {
			$this->addFieldError ( "filter.regionId", Lang::get ( "Invalid region" ) );
		}
	}
	private function convertFilterDate() {
		$this->filter->startDate = DateTimeUtil::appendTime ( $this->filter->startDate );
		$this->filter->startDate = DateTimeUtil::string2MySqlDate ( $this->filter->startDate, DateTimeUtil::getDateTimeFormat () );
		$this->filter->endDate = DateTimeUtil::appendTime ( $this->filter->endDate, false );
		$this->filter->endDate = DateTimeUtil::string2MySqlDate ( $this->filter->endDate, DateTimeUtil::getDateTimeFormat () );
	}
	private function prepareRegionList() {
		$filter = new RegionExtendVo ();
		$filter->status = "active";
		$regionService = new RegionService ();
		$this->regionList = $regionService->getByFilter ( $filter );
	}
	private function prepareShowRegionList() {
		$regionId = is_null ( $this->filter ) || is_null ( $this->filter->regionId ) ? 0 : $this->filter->regionId;
		$showRegionList = array ();
		foreach ( $this->regionList as $regionVo ) {
			if ($regionVo->id == $regionId) {
				$showRegionList [] = $regionVo;
			}
		}
		$this->showRegionList = (0 == $regionId) ? $this->regionList : $showRegionList;
	}
	private function prepareStatusList() {
		$orderStatusService = new OrderStatusService ();
		$this->orderStatusList = $orderStatusService->getSortedOrderStatuses ();
	}
	private function prepareCurrencyList() {
		$filter = new CurrencyExtendVo ();
		$filter->status = "active";
		$currencyService = new CurrencyService ();
		$this->currencyList = $currencyService->getByFilter ( $filter );
	}
	private function getOverview() {
		$overviewVos = $this->salesReportService->getOverviewByFilter ( $this->filter );
		$overviewMap = array ();
		foreach ( $this->orderStatusList as $orderStatus ) {
			foreach ( $this->showRegionList as $region ) {
				$noOfOrders = 0;
				foreach ( $this->currencyList as $currency ) {
					$found = null;
					foreach ( $overviewVos as $record ) {
						if ($record->orderStatusId === $orderStatus->id && $record->regionId === $region->id && $record->currencyCode === $currency->code) {
							$found = $record;
							break;
						}
					}
					if ($found == null) {
						$found = new OverviewReportVo ();
						$found->orderStatusId = $orderStatus->id;
						$found->regionId = $region->id;
						$found->currencyCode = $currency->code;
						$found->orderCount = 0;
					}
					$found->symbol = $currency->symbol;
					$noOfOrders += $found->orderCount;
					$key = $orderStatus->id . "_" . $region->id . "_" . $currency->code;
					$overviewMap [$key] = $found;
				}
				// Get number of orders of each status and region.
				$key = $orderStatus->id . "_" . $region->id . "_noOfOrders";
				$overviewMap [$key] = $noOfOrders;
			}
		}
		// Format data.
		foreach ( $overviewMap as $key => $value ) {
			if ($value instanceof OverviewReportVo) {
				$value->orderTotal = AppUtil::formatNumber ( $value->orderTotal, $value->symbol, 2 );
			}
		}
		$this->overview = $overviewMap;
	}
	private function getOrders() {
		$this->orders = $this->salesReportService->getOrderByFilter ( $this->filter );
	}
	private function getTopProducts() {
		$this->topProducts = $this->salesReportService->getTopProductByFilter ( $this->filter );
	}
	private function getDistinctCountries($countryReportVos) {
		/*
		$countryCodes = array();
		$countryVos = array ();
		foreach ( $countryReportVos as $countryReportVo ) {
			if (! in_array ( $countryReportVo->code, $countryCodes )) {
				$newCountryReportVo = new CountryReportVo ();
				$newCountryReportVo->id = $countryReportVo->id;
				$newCountryReportVo->code = $countryReportVo->code;
				$newCountryReportVo->name = $countryReportVo->name;
				$newCountryReportVo->currencyCode = $countryReportVo->currencyCode;
				$countryVos [] = $newCountryReportVo;
				$countryCodes[] = $countryReportVo->code;
			}
		}
		$this->countryList = $countryVos;
		*/
		$this->countryList = $this->salesReportService->getDistinctTopCountryByFilter($this->filter);
	}
	private function getTopCountries() {
		// Get top countries data.
		$countryReportVos = $this->salesReportService->getTopCountryFilter ( $this->filter );
		// Get country list.
		$this->getDistinctCountries ( $countryReportVos );
		// Create top country report data map.
		$topCountryMap = array ();
		foreach ( $this->countryList as $country ) {
			$noOfOrders = 0;
			$totalPaid = 0;
			foreach ( $this->currencyList as $currency ) {
				$found = null;
				foreach ( $countryReportVos as $countryReportVo ) {
					if ($country->code === $countryReportVo->code && $currency->code === $countryReportVo->currencyCode) {
						$found = $countryReportVo;
						break;
					}
				}
				if ($found == null) {
					$found = new CountryReportVo ();
					$found->id = $country->id;
					$found->code = $country->code;
					$found->name = $country->name;
					$found->currencyCode = $currency->code;
					$found->orderCount = 0;
					$found->paidAmount = 0;
				}
				$found->symbol = $currency->symbol;
				$totalPaid += $found->paidAmount;
				$noOfOrders += $found->orderCount;
				$key = $country->code . "_" . $currency->code;
				$topCountryMap [$key] = $found;
			}
			$topCountryMap [$country->code . "_noOfOrders"] = $noOfOrders;
			$topCountryMap [$country->code . "_totalPaid"] = $totalPaid;
		}
		// Format data.
		foreach ( $topCountryMap as $key => $value ) {
			if ($value instanceof CountryReportVo) {
				$value->paidAmount = AppUtil::formatNumber ( $value->paidAmount, $value->symbol, 2 );
			}
		}
		$this->topCountries = $topCountryMap;
	}
	private function formatNumber($number, $symbol, $decimals = 0, $dec_point = ".", $thousands_sep = ",") {
		return $symbol . number_format ( $number, $decimals, $dec_point, $thousands_sep );
	}
}