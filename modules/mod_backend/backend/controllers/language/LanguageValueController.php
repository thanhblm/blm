<?php

namespace backend\controllers\language;

use common\persistence\base\vo\LanguageValueVo;
use common\persistence\extend\vo\LanguageValueExtendVo;
use common\services\language\LanguageService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use common\utils\FileUtil;

class LanguageValueController extends PagingController {
	public $languageValues;
	public $languageValue;
	public $id;
	public $languages;
	public $fileNameDownload;
	public $fullPathFile;
	private $languageService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new LanguageValueExtendVo ();
		$this->languageValue = new LanguageValueVo ();
		$this->languageValues = new Paging ();
		$this->languageService = new LanguageService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Translation";
	}
	public function listView() {
		$this->getLanguges ();
		$this->getLanguageValues ();
		return "success";
	}
	public function search() {
		$this->getLanguges ();
		$this->getLanguageValues ();
		return "success";
	}
	public function editView() {
		$this->getLanguges ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load system setting group.
		$filter = new LanguageValueVo ();
		$filter->id = $this->id;
		$this->languageValue = $this->languageService->getLanguageValueById ( $filter );
		$this->languageValue->original = htmlentities($this->languageValue->original);
		$this->languageValue->destination = htmlentities($this->languageValue->destination);
		return "success";
	}
	public function edit() {
		$this->getLanguges ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->languageValue->key = md5 ( trim ( $this->languageValue->original ) );
		$this->languageValue->mdDate = date ( 'Y-m-d H:i:s' );
		$this->languageValue->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->languageValue->original = html_entity_decode($this->languageValue->original);
		$this->languageValue->destination = html_entity_decode($this->languageValue->destination);
		$this->languageService->updateLanguageValue ( $this->languageValue );
		$this->addActionMessage ( "The language value updated successfully" );
		return "success";
	}
	private function getLanguges() {
		$this->languages = $this->languageService->getAllLanguages ();
	}
	protected function validate() {
		if (AppUtil::isEmptyString ( $this->languageValue->id )) {
			$this->addActionError ( "No language value id" );
		}
		if (AppUtil::isEmptyString ( $this->languageValue->languageCode )) {
			$this->addFieldError ( "languageValue[languageCode]", "Language code is required" );
		}
		if (AppUtil::isEmptyString ( $this->languageValue->original )) {
			$this->addFieldError ( "languageValue[original]", "Original is required" );
		}
		if (AppUtil::isEmptyString ( $this->languageValue->destination )) {
			$this->addFieldError ( "languageValue[destination]", "Translation is required" );
		}
		// Get old language value info.
		$filter = new LanguageValueVo ();
		$filter->id = $this->languageValue->id;
		$vo = $this->languageService->getLanguageValueById ( $filter );
		$checkCondition = ! is_null ( $vo ) && ! ($vo->languageCode === $this->languageValue->languageCode && $vo->original === $this->languageValue->original);
		if ($checkCondition) {
			// Check duplicate code.
			$filter = new LanguageValueExtendVo ();
			$filter->languageCode = $this->languageValue->languageCode;
			$filter->original = $this->languageValue->original;
			$vos = $this->languageService->getLanguageValueByFilter ( $filter );
			if (! is_null ( $vos ) && count ( $vos ) > 0) {
				$this->addActionError ( "The original for this language code was existed" );
			}
		}
	}
	protected function getLanguageValues() {
		$filter = $this->buildFilter ();
		// Get total records of languages
		$count = $this->languageService->countLanguageValueByFilter ( AppUtil::cloneObj ( $filter ) );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get languages.
		$languageValueVos = $this->languageService->getLanguageValueByFilter ( AppUtil::cloneObj ( $filter ) );
		$paging->records = $this->formatList2Show ( $languageValueVos );
		$this->languageValues = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "languageCode asc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(LanguageValueExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		return $mo;
	}
	protected function format2Query(LanguageValueExtendVo $mo) {
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
	public function exportCSV() {
		set_time_limit ( 0 );
		$pathExport = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "export.tmp.path" ) );
		try {
			$this->fileNameDownload = "localization_" . date ( "Ymd" ) . ".csv";
			$headMapping = array (
					"Language Code" => "languageCode",
					"Original" => "original",
					"Translation" => "destination",
			);
			$filterVo = $this->buildFilter ();
			$filterVo->page = null;
			$this->fullPathFile = FileUtil::exportCsv ( "localization_", $headMapping, AppUtil::cloneObj($this->buildFilter()), $this->languageService, "getLanguageValueByFilter" );
		} catch ( \Exception $e ) {
			$this->addActionError ( $e->getMessage () );
			return "success";
		}
		return "success";
	}
}