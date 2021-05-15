<?php

namespace backend\controllers\language;

use common\persistence\base\vo\LanguageVo;
use common\persistence\extend\vo\LanguageExtendVo;
use common\services\country\CountryService;
use common\services\language\LanguageService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;

class LanguageController extends PagingController {
	public $countries;
	public $languages;
	public $language;
	public $code;
	private $languageService;
	private $countryService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new LanguageExtendVo ();
		$this->language = new LanguageVo ();
		$this->languages = new Paging ();
		$this->languageService = new LanguageService ();
		$this->countryService = new CountryService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Language Management";
	}
	public function listView() {
		$this->getLanguages ();
		return "success";
	}
	public function search() {
		$this->getLanguages ();
		return "success";
	}
	public function addView() {
		$this->getCountries ();
		return "success";
	}
	public function add() {
		$this->getCountries ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->language->crDate = date ( 'Y-m-d H:i:s' );
		$this->language->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->language->mdDate = date ( 'Y-m-d H:i:s' );
		$this->language->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->language->flag = strtolower ( $this->language->flag );
		// Add to the database.
		$this->languageService->addLanguage ( $this->language );
		$this->addActionMessage ( "The language added successfully" );
		return "success";
	}
	public function editView() {
		$this->getCountries ();
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for editing" );
		}
		// Load language.
		$filter = new LanguageVo ();
		$filter->code = $this->code;
		$this->language = $this->languageService->getLanguageByCode ( $filter );
		$this->language->flag = strtolower ( $this->language->flag );
		return "success";
	}
	public function edit() {
		$this->getCountries ();
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->language->mdDate = date ( 'Y-m-d H:i:s' );
		$this->language->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->language->flag = strtolower ( $this->language->flag );
		$this->languageService->updateLanguage ( $this->language );
		$this->addActionMessage ( "The language updated successfully" );
		return "success";
	}
	public function copyView() {
		$this->getCountries ();
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for cloning" );
		}
		// Load language.
		$filter = new LanguageVo ();
		$filter->code = $this->code;
		$this->language = $this->languageService->getLanguageByCode ( $filter );
		$this->language->flag = strtolower ( $this->language->flag );
		return "success";
	}
	public function copy() {
		$this->getCountries ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Copy to the database.
		$this->language->crDate = date ( 'Y-m-d H:i:s' );
		$this->language->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->language->mdDate = date ( 'Y-m-d H:i:s' );
		$this->language->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->language->flag = strtolower ( $this->language->flag );
		$this->languageService->addLanguage ( $this->language );
		$this->addActionMessage ( "The language cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for deleting" );
		}
		// Load system setting group.
		$filter = new LanguageVo ();
		$filter->code = $this->code;
		$this->language = $this->languageService->getLanguageByCode ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->code )) {
			throw new \Exception ( "No code for deleting" );
		}
		// Delete the system setting group.
		$language = new LanguageVo ();
		$language->code = $this->code;
		$this->languageService->deleteLanguage ( $language );
		$this->addActionMessage ( "The language deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->language->code )) {
			$this->addFieldError ( "language[code]", "Code is required" );
		} else {
			// Check duplicate code when adding.
			if ($isAdding) {
				$filter = new LanguageVo ();
				$filter->code = $this->language->code;
				$vo = $this->languageService->getLanguageByCode ( $filter );
				if (! is_null ( $vo )) {
					$this->addFieldError ( "language[code]", "Code was existed" );
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->language->name )) {
			$this->addFieldError ( "language[name]", "Name is required" );
		}
		if (AppUtil::isEmptyString ( $this->language->localeName )) {
			$this->addFieldError ( "language[localeName]", "Name is required" );
		}
		if (AppUtil::isEmptyString ( $this->language->flag )) {
			$this->addFieldError ( "language[flag]", "Flag (the country code) is required" );
		}
		if (AppUtil::isEmptyString ( $this->language->status )) {
			$this->addFieldError ( "language[status]", "Status is required" );
		} else {
			if (! in_array ( $this->language->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "language[status]", "Status is invalid" );
			}
		}
	}
	protected function getCountries() {
		$this->countries = $this->countryService->getAll ();
		foreach ($this->countries as $country){
			$country->iso2 = strtolower($country->iso2);
		}
	}
	protected function getLanguages() {
		$filter = $this->buildFilter ();
		// Get total records of languages.
		$count = $this->languageService->countLanguageByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get languages.
		$languageVos = $this->languageService->getLanguageByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $languageVos );
		$this->languages = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "code asc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(LanguageExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->status = AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $mo->status );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		return $mo;
	}
	protected function format2Query(LanguageExtendVo $mo) {
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