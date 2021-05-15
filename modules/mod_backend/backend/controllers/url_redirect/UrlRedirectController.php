<?php

namespace backend\controllers\url_redirect;

use common\persistence\base\vo\UrlRedirectVo;
use common\persistence\extend\vo\UrlRedirectExtendVo;
use common\services\url_redirect\UrlRedirectService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;

class UrlRedirectController extends PagingController {
	public $urlRedirects;
	public $urlRedirect;
	public $id;
	private $urlRedirectService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new UrlRedirectExtendVo ();
		$this->urlRedirect = new UrlRedirectVo ();
		$this->urlRedirects = new Paging ();
		$this->urlRedirectService = new UrlRedirectService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Url Redirects";
	}
	public function listView() {
		$this->getUrlRedirects ();
		return "success";
	}
	public function search() {
		$this->getUrlRedirects ();
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
		$this->urlRedirect->crDate = date ( 'Y-m-d H:i:s' );
		$this->urlRedirect->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->urlRedirect->mdDate = date ( 'Y-m-d H:i:s' );
		$this->urlRedirect->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->urlRedirectService->add ( $this->urlRedirect );
		$this->addActionMessage ( "The url redirect added successfully" );
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No url redirect for editing" );
		}
		// Load system setting group.
		$filter = new UrlRedirectVo ();
		$filter->id = $this->id;
		$this->urlRedirect = $this->urlRedirectService->getById ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->urlRedirect->mdDate = date ( 'Y-m-d H:i:s' );
		$this->urlRedirect->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->urlRedirectService->update ( $this->urlRedirect );
		$this->addActionMessage ( "The url redirect updated successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No url redirect for cloning" );
		}
		// Load urlRedirect.
		$filter = new UrlRedirectVo ();
		$filter->id = $this->id;
		$this->urlRedirect = $this->urlRedirectService->getById ( $filter );
		// Set empty auto increase column.
		$this->urlRedirect->id = null;
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->urlRedirect->crDate = date ( 'Y-m-d H:i:s' );
		$this->urlRedirect->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->urlRedirect->mdDate = date ( 'Y-m-d H:i:s' );
		$this->urlRedirect->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->urlRedirectService->add ( $this->urlRedirect );
		$this->addActionMessage ( "The url redirect cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No url redirect for deleting" );
		}
		// Load system setting group.
		$filter = new UrlRedirectVo ();
		$filter->id = $this->id;
		$this->urlRedirect = $this->urlRedirectService->getById ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No url redirect for deleting" );
		}
		// Delete the system setting group.
		$filter = new UrlRedirectVo ();
		$filter->id = $this->id;
		$this->urlRedirectService->delete ( $filter );
		$this->addActionMessage ( "The url redirect deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->urlRedirect->oldUrl )) {
			$this->addFieldError ( "urlRedirect[oldUrl]", "Old url is required" );
		} else {
			if ($isAdding) {
				$this->checkDuplicateOldUrl ();
			} else {
				// Get old url redirect info.
				$oldUrlRedirectVo = $this->urlRedirectService->getById ( $this->urlRedirect );
				// The old url is change?
				if ($oldUrlRedirectVo->oldUrl !== $this->urlRedirect->oldUrl) {
					$this->checkDuplicateOldUrl ();
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->urlRedirect->newUrl )) {
			$this->addFieldError ( "urlRedirect[newUrl]", "New url is required" );
		}
	}
	private function checkDuplicateOldUrl() {
		$filter = new UrlRedirectExtendVo ();
		$filter->oldUrl = $this->urlRedirect->oldUrl;
		$count = $this->urlRedirectService->getCountByFilter ( $filter );
		if ($count > 0) {
			$this->addFieldError ( "urlRedirect[oldUrl]", "The old url already exists" );
		}
	}
	protected function getUrlRedirects() {
		$filter = $this->buildFilter ();
		// Get total records of urlRedirects.
		$count = $this->urlRedirectService->getCountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get url redirects.
		$urlRedirects = $this->urlRedirectService->getByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $urlRedirects );
		$this->urlRedirects = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(UrlRedirectExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		return $mo;
	}
	protected function format2Query(UrlRedirectExtendVo $mo) {
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