<?php

namespace backend\controllers\address;

use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\AddressExtendVo;
use common\services\address\AddressService;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\utils\FileUtil;
use common\utils\StringUtil;
use core\common\Paging;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use common\helper\EmailHelper;

/**
 * *
 *
 * @author TANDT
 *        
 */
class AddressController extends PagingController {
	public $address;
	public $addressList; // pagging
	public $fileNameDownload;
	public $listCountry;
	public $listState;
	private $addressSv;
	private $countrySv;
	private $stateSv;
	public function __construct() {
		parent::__construct ();
		$this->address = new AddressExtendVo ();
		$this->addressSv = new AddressService ();
		$this->filter = new AddressExtendVo ();
		$this->stateSv = new StateService();
		$this->countrySv = new CountryService();
	}
	public function listView() {
		$this->getAddresss ();
		return "success";
	}
	public function search() {
		$this->getAddresss ();
		return "success";
	}
	public function addView() {
		$this->address  = $this->address;
		$this->prepareDataView();
		return "success";
	}
	public function add() {
		$this->validAddForm ();
		$this->prepareDataView();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		$this->addressSv->createAddress ( $this->address );
		return "success";
	}
	public function editView() {
		$this->detail ();
		$this->prepareDataView();
		return "success";
	}
	public function edit() {
		$this->validEditData();
		if ($this->hasErrors ()) {
			$this->prepareDataView();
			return "success";
		}
		$this->prepareData ();
		$this->address->crBy = null;
		$this->address->crDate = null;
		$this->addressSv->updateAddress ( $this->address );
		return "success";
	}
	public function copyView() {
		$this->detail ();
		$this->address->id = null;
		return "success";
	}
	public function copy() {
		$this->validAddData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		if (! AppUtil::isEmptyString ( $this->address->password )) {
			$this->address->password = sha1 ( $this->address->password );
		}
		$this->addressSv->createAddress ( $this->address );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->addressSv->deleteAddress ( $this->address );
		return "success";
	}
	public function exportCSV() {
		try {
			$listAddress = $this->addressSv->selectAll ();
			$fileNameDownload = FileUtil::exportCsvFromObjects ( $listAddress, AddressVo::class );
		} catch ( \Exception $e ) {
			$this->addActionError ( $e->getMessage () );
			$this->prepareDataView ();
			$this->getAddresss ();
			return "error";
		}
		$this->fileNameDownload = $fileNameDownload;
		return "success";
	}
	
	public function changeCountry(){
		$state = new StateVo();
		$state->country = AppUtil::defaultIfEmpty($this->address->country, 0);
		$this->listState= $this->stateSv->selectByFilter($state);
		return "success";
	}
	
	private function prepareDataView(){
		$this->listCountry = $this->countrySv->getAll();
		$state = new StateVo();
		$state->country = AppUtil::defaultIfEmpty($this->address->country, 0);
		$this->listState = $this->stateSv->selectByFilter($state);
	}
	
	private function prepareData() {
		$this->address->type = 2;
		$this->address->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->address->crDate = date ( 'Y-m-d H:i:s' );
		$this->address->mdDate = date ( 'Y-m-d H:i:s' );
		$this->address->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
	}
	private function validEditData() {
		$this->validEditForm ();
		if (! $this->hasErrors ()) {
			$filter = new AddressVo ();
			$filter->id = $this->address->id;
			$addressOld = $this->addressSv->selectByKey ( $filter );
			
			if(!isset($addressOld->id)){
				$this->addFieldError ( "address[id]", Lang::getWithFormat ( "Not found with id {0} !", $this->address->id) );
			}
		}
	}
	private function validEditForm() {
		if (AppUtil::isEmptyString ( $this->address->id )) {
			$this->addFieldError ( "address[id]", Lang::get ( "ID address can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->address )) {
			$this->addFieldError ( "address[address]", Lang::get ( "Address can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->address->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		} else if(! EmailHelper::isValidEmailMx($this->address->email)){
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid mx email address", $this->address->email ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->country ) ||  "0" == $this->address->country) {
			$this->addFieldError ( "address[country]", Lang::get ( "Please select a country" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->phone )) {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone can not be empty" ) );
		} elseif (! StringUtil::validPhone( $this->address->phone)) {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone is not valid" ) );
		}
		if( $this->address->country==411 || $this->address->country==384){
			if (AppUtil::isEmptyString ( $this->address->state )) {
				$this->addFieldError ( "address[state]", Lang::get ( "State can not be empty" ) );
			}
		}
	}
	private function validAddForm() {
		if (AppUtil::isEmptyString ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->address->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		} else if (! EmailHelper::isValidEmailMx($this->address->email)){
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->country ) ||  "0" == $this->address->country) {
			$this->addFieldError ( "address[country]", Lang::get ( "Please select a country" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->state ) ||  "0" == $this->address->state) {
			$this->addFieldError ( "address[state]", Lang::get ( "Please select a state" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->phone )) {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone can not be empty" ) );
		} elseif (! StringUtil::validPhone( $this->address->phone)) {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone is not valid" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->address )) {
			$this->addFieldError ( "address[address]", Lang::get ( "Address can not be empty" ) );
		} 
		
		if( $this->address->country==411 || $this->address->country==384){
			if (AppUtil::isEmptyString ( $this->address->state )) {
				$this->addFieldError ( "address[state]", Lang::get ( "State can not be empty" ) );
			}
		}
		
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->address->id )) {
			$this->addActionError ( Lang::get ( "You can't view a address with empty id" ) );
		} elseif (! is_int ( intval ( $this->address->id ) )) {
			$this->addActionError ( Lang::get ( "Address id required integer" ) );
		} else {
			$addressDetail = $this->addressSv->selectBykey ( $this->address );
			if (! isset ( $addressDetail )) {
				$this->addActionError ( Lang::getWithFormat ( "Not found address with id {0}", $this->address->id ) );
			} else {
				$this->address = $addressDetail;
			}
		}
	}
	private function getAddresss() {
		$filter = $this->buildFilter ();
		$filter->groupId = $this->address->groupId;
		$count = $this->addressSv->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$paging->records = $this->addressSv->search ( $filter );
		$this->addressList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		StringUtil::clearObject ( $filter );
		$filter->type = 2;
		return $filter;
	}
}