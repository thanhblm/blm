<?php

namespace backend\controllers\contact;

use common\persistence\base\vo\ContactVo;
use common\persistence\extend\vo\ContactExtendVo;
use common\services\contact\ContactService;
use common\services\country\CountryService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;

class ContactController extends PagingController {
	private $contactService;
	private $countryService;
	public $contacts;
	public $contact;
	public $id;
	public $countries;
	public function __construct() {
		parent::__construct ();
		$this->filter = new ContactExtendVo ();
		$this->contact = new ContactVo ();
		$this->contacts = new Paging ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Contacts";
		$this->contactService = new ContactService ();
		$this->countryService = new CountryService ();
	}
	public function listView() {
		$this->getCountries ();
		$this->getContacts ();
		return "success";
	}
	public function search() {
		$this->getCountries ();
		$this->getContacts ();
		return "success";
	}
	public function detailView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No contact for view" );
		}
		$filter = new ContactVo ();
		$filter->id = $this->id;
		$this->contact = $this->contactService->getById ( $filter );
		$this->contact->crDate = DateTimeUtil::mySqlStringDate2String ( $this->contact->crDate, DateTimeUtil::getDateTimeFormat () );
		$updateContact = new ContactVo ();
		$updateContact->id = $this->contact->id;
		$updateContact->status = "viewed";
		$this->contactService->update ( $updateContact );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No contact for deleting" );
		}
		$filter = new ContactVo ();
		$filter->id = $this->id;
		$this->contact = $this->contactService->getById ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No contact for deleting" );
		}
		$filter = new ContactVo ();
		$filter->id = $this->id;
		$this->contactService->delete ( $filter );
		$this->addActionMessage ( "The contact deleted successfully" );
		return "success";
	}
	protected function getCountries() {
		$this->countries = $this->countryService->getAll ();
	}
	protected function getContacts() {
		$filter = $this->buildFilter ();
		// Get total records of contacts.
		$count = $this->contactService->getCountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get contacts.
		$contacts = $this->contactService->getByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $contacts );
		$this->contacts = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "crDate desc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(ContactExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$statuses = ApplicationConfig::get ( "contact.status.list" );
		$mo->status = AppUtil::arrayValue ( $statuses, $mo->status );
		return $mo;
	}
	protected function format2Query(ContactExtendVo $mo) {
		$vo = AppUtil::cloneObj ( $mo );
		$vo->crDateFrom = DateTimeUtil::appendTime ( $vo->crDateFrom );
		$vo->crDateTo = DateTimeUtil::appendTime ( $vo->crDateTo, false );
		$vo->crDateFrom = DateTimeUtil::string2MySqlDate ( $vo->crDateFrom, DateTimeUtil::getDateTimeFormat () );
		$vo->crDateTo = DateTimeUtil::string2MySqlDate ( $vo->crDateTo, DateTimeUtil::getDateTimeFormat () );
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