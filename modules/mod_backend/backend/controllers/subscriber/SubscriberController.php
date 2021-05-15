<?php

namespace backend\controllers\subscriber;

use common\persistence\base\vo\SubscriberVo;
use common\persistence\extend\vo\SubscriberExtendVo;
use common\services\subscriber\SubscriberService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use common\utils\ArrayUtil;
use core\utils\ValidateUtil;
use common\utils\FileUtil;
use common\helper\EmailHelper;

class SubscriberController extends PagingController {
	public $subscribers;
	public $subscriber;
	public $id;
	private $subscriberService;
	public $fileName;
	public $outputFileName;
	public function __construct() {
		parent::__construct ();
		$this->filter = new SubscriberExtendVo ();
		$this->subscriber = new SubscriberVo ();
		$this->subscribers = new Paging ();
		$this->subscriberService = new SubscriberService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Subscribers";
	}
	public function listView() {
		$this->getSubscribers ();
		return "success";
	}
	public function search() {
		$this->getSubscribers ();
		return "success";
	}
	public function addView() {
		$this->subscriber->status = "inactive";
		return "success";
	}
	public function add() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->subscriber->crDate = date ( 'Y-m-d H:i:s' );
		$this->subscriber->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
		$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->subscriberService->add ( $this->subscriber );
		$this->addActionMessage ( "The subscriber added successfully" );
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No subscriber for editing" );
		}
		// Load system setting group.
		$filter = new SubscriberVo ();
		$filter->id = $this->id;
		$this->subscriber = $this->subscriberService->getById ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
		$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->subscriberService->update ( $this->subscriber );
		$this->addActionMessage ( "The subscriber updated successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No subscriber for cloning" );
		}
		// Load subscriber.
		$filter = new SubscriberVo ();
		$filter->id = $this->id;
		$this->subscriber = $this->subscriberService->getById ( $filter );
		$this->subscriber->status = "inactive";
		// Set empty auto increase column.
		$this->subscriber->id = null;
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->subscriber->crDate = date ( 'Y-m-d H:i:s' );
		$this->subscriber->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
		$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->subscriberService->add ( $this->subscriber );
		$this->addActionMessage ( "The subscriber cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No subscriber for deleting" );
		}
		// Load system setting group.
		$filter = new SubscriberVo ();
		$filter->id = $this->id;
		$this->subscriber = $this->subscriberService->getById ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No subscriber for deleting" );
		}
		// Delete the system setting group.
		$filter = new SubscriberVo ();
		$filter->id = $this->id;
		$this->subscriberService->delete ( $filter );
		$this->addActionMessage ( "The subscriber deleted successfully" );
		return "success";
	}
	public function exportCsv() {
		set_time_limit (0);
		$pathExport = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "export.tmp.path" ) );
		try {
			$this->outputFileName= "subscribers_" . date ( "Ymd" ) . ".csv";
			$headMapping = array (
					"Id" => "id",
					"Email" =>'email',
					"First Name"=>'firstName',
					"Last Name"=>'lastName',
					"Status"=>'status',
					"Subscribed On"=>'crDate',
					"Created By"=>'crBy',
					"Last Modified On"=>'mdDate',
					"Last Modified By"=>'mdBy' 
			);
			$filterVo = $this->buildFilter();
			$filterVo->page = null;
			$this->fileName = FileUtil::exportCsv ( "subcribers_", $headMapping, $this->buildFilter (), $this->subscriberService, "getByFilter" );
		} catch ( \Exception $e ) {
			$this->addActionError ( $e->getMessage () );
			return "success";
		}
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", Lang::get ("Email cannot be empty" ));
		} else if (! ValidateUtil::isEmail ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", "Email is not valid" );
		} else if (! EmailHelper::isValidEmailMx ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", "Email mx is not valid" );
		}
		
		if (AppUtil::isEmptyString ( $this->subscriber->status )) {
			$this->addFieldError ( "subscriber[status]", "Status is required" );
		} else {
			if (! in_array ( $this->subscriber->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "subscriber[status]", "Status is invalid" );
			}
		}
	}
	protected function getSubscribers() {
		$filter = $this->buildFilter ();
		// Get total records of subscribers.
		$count = $this->subscriberService->getCountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get subscribers.
		$subscribers = $this->subscriberService->getByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $subscribers );
		$this->subscribers = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "crDate desc" );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(SubscriberExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		$statuses = ApplicationConfig::get ( "common.status.list" );
		$mo->status = AppUtil::arrayValue ( $statuses, $mo->status );
		return $mo;
	}
	protected function format2Query(SubscriberExtendVo $mo) {
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
	protected function getCsvFile($filename = "download.csv", $heading, $data) {
		$dir = ROOT . DS . "tmp" . DS . "subscriber" . DS;
		if (! file_exists ( $dir ))
			mkdir ( $dir );
		$fullFilePath =  $dir . $filename;
		$output = fopen ( $dir . $filename, 'w' );
		// output the column headings
		fputcsv ( $output, $heading );
		// loop over the rows, outputting them
		foreach ( $data as $key => $value ) {
			fputcsv ( $output, $value );
		}
		fclose ( $output );
		return $fullFilePath;
	}
}