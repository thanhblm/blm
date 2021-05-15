<?php

namespace backend\controllers\customer;

use common\persistence\base\vo\CustomerVo;
use common\persistence\extend\vo\CustomerExtendVo;
use common\services\customer\AccountTypeService;
use common\services\customer\CustomerService;
use common\services\customer\CustomerTypeService;
use common\services\language\LanguageService;
use common\services\price_level\PriceLevelService;
use common\utils\FileUtil;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
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
class CustomerController extends PagingController {
	public $customer;
	public $customerList; // pagging
	public $accountTypes;
	public $priceLevels;
	public $customerTypes;
	public $languages;
	public $cPassword;
	public $fileNameDownload;
	public $fullPathFile;
	public $saleRepList;
	private $customerSv;
	private $accountTypeSv;
	private $priceLevelSv;
	private $customerTypeSv;
	private $languageSv;
	public function __construct() {
		parent::__construct ();
		$this->customer = new CustomerExtendVo ();
		$this->customerSv = new CustomerService ();
		$this->filter = new CustomerExtendVo ();
		$this->accountTypeSv = new AccountTypeService ();
		$this->priceLevelSv = new PriceLevelService ();
		$this->customerTypeSv = new CustomerTypeService ();
		$this->languageSv = new LanguageService ();
	}
	public function listView() {
		$this->prepareDataView ();
		$this->getCustomers ();
		return "success";
	}
	public function search() {
		$this->prepareDataView ();
		$this->getCustomers ();
		return "success";
	}
	public function addView() {
		$this->prepareDataView ();
		return "success";
	}
	public function add() {
		$this->validAddData ();
		if ($this->hasErrors ()) {
			$this->prepareDataView ();
			return "success";
		}
		$this->prepareData ();
		if (! AppUtil::isEmptyString ( $this->customer->password )) {
			$encryptedType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptedType )) {
				$this->customer->password = "{" . $encryptedType . "}" . ($encryptedType ( $this->customer->password ));
			} else {
				$this->customer->password = $this->customer->password;
			}
		}
		
		$this->customerSv->createCustomer ( $this->customer );
		return "success";
	}
	public function editView() {
		$this->detail ();
		$this->prepareDataView ();
		return "success";
	}
	public function edit() {
		$this->validEditData ();
		if ($this->hasErrors ()) {
			$this->prepareDataView ();
			return "success";
		}
		$this->prepareData ();
		$customerVo = new CustomerVo ();
		$customerVo->id = $this->customer->id;
		$customerVo = $this->customerSv->selectByKey ( $customerVo );
		
		if (! AppUtil::isEmptyString ( $this->customer->password )) {
			$encryptedType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptedType )) {
				$this->customer->password = "{" . $encryptedType . "}" . ($encryptedType ( $this->customer->password ));
			} else {
				$this->customer->password = $this->customer->password;
			}
		} else {
			$this->customer->password = null;
		}
		$this->customer->crBy = null;
		$this->customer->crDate = null;
		$this->customerSv->updateCustomer ( $this->customer );
		return "success";
	}
	public function copyView() {
		$this->detail ();
		$this->customer->id = null;
		$this->prepareDataView ();
		return "success";
	}
	public function copy() {
		$this->validAddData ();
		if ($this->hasErrors ()) {
			$this->prepareDataView ();
			return "success";
		}
		$this->prepareData ();
		if (! AppUtil::isEmptyString ( $this->customer->password )) {
			$encryptedType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptedType )) {
				$this->customer->password = "{" . $encryptedType . "}" . ($encryptedType ( $this->customer->password ));
			} else {
				$this->customer->password = $this->customer->password;
			}
		}
		$this->customerSv->createCustomer ( $this->customer );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->customerSv->deleteCustomer ( $this->customer );
		return "success";
	}
	public function exportCSV() {
		set_time_limit ( 0 );
		$pathExport = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "export.tmp.path" ) );
		try {
			$this->fileNameDownload = "customers.csv";
			$headMapping = array (
					"Id" => "id",
					"User Name" => "userName",
					"First Name" => "firstName",
					"Last Name" => "lastName",
					"Email" => "email",
					"Phone" => "phone",
					"Fax" => "fax",
					"Price Level" => "priceLevelName",
					"Account Type" => "accountTypeName",
					"Customer Type" => "customerTypeName",
					"Sale Rep" => "saleRepId",
					"Language" => "languageCode",
					"Company Name" => "companyName",
					"Registration No." => "registrationNo",
					"Reseller Cert No." => "resellerCertNo",
					"VAT No." => "vatNo" 
			);
			$filterVo = $this->buildFilter ();
			$filterVo->page = null;
			$this->fullPathFile = FileUtil::exportCsv ( "customers_", $headMapping, $this->buildFilter (), $this->customerSv, "search" );
		} catch ( \Exception $e ) {
			$this->addActionError ( $e->getMessage () );
			$this->prepareDataView ();
			$this->getCustomers ();
			return "error";
		}
		return "success";
	}
	private function buildListSalseRep() {
		$customerVo = new CustomerVo ();
		$customerVo->accountTypeId = 2; // salse rep
		$this->saleRepList = $this->customerSv->selectByFilter ( $customerVo );
	}
	private function prepareData() {
		$this->customer->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->customer->crDate = date ( 'Y-m-d H:i:s' );
		$this->customer->mdDate = date ( 'Y-m-d H:i:s' );
		$this->customer->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		if (AppUtil::isEmptyString ( $this->customer->customerTypeId )) {
			$this->customer->customerTypeId = 1;
		}
		if (AppUtil::isEmptyString ( $this->customer->accountTypeId )) {
			$this->customer->accountTypeId = 1;
		}
		if (AppUtil::isEmptyString ( $this->customer->priceLevelId )) {
			$this->customer->priceLevelId = 0;
		}
	}
	private function prepareDataView() {
		$this->accountTypes = $this->accountTypeSv->selectAll ();
		$listPriceLevel = $this->priceLevelSv->selectAll ();
		$this->priceLevels = array ();
		foreach ( $listPriceLevel as $priceLevel ) {
			array_push ( $this->priceLevels, $priceLevel );
		}
		$this->customerTypes = $this->customerTypeSv->selectAll ();
		$this->languages = $this->languageSv->getAllLanguages ();
		$this->buildListSalseRep ();
	}
	private function validAddData() {
		$this->validAddForm ();
		if (! $this->hasErrors ()) {
			$filter = new CustomerVo ();
			$filter->email = $this->customer->email;
			$voResult = $this->customerSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0) {
				$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} has already existed", $this->customer->email ) );
			}
			
			$filter = new CustomerVo ();
			$filter->userName = $this->customer->userName;
			$voResult = $this->customerSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && ! empty ( $this->customer->userName )) {
				$this->addFieldError ( "customer[userName]", Lang::getWithFormat ( "{0} has already existed", $this->customer->userName ) );
			}
		}
	}
	private function validEditData() {
		$this->validEditForm ();
		if (! $this->hasErrors ()) {
			$filter = new CustomerVo ();
			$filter->id = $this->customer->id;
			$customerOld = $this->customerSv->selectByKey ( $filter );
			
			$filter = new CustomerVo ();
			$filter->email = $this->customer->email;
			$voResult = $this->customerSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && $customerOld->email != $this->customer->email) {
				$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} has already existed", $this->customer->email ) );
			}
			
			if (! AppUtil::isEmptyString ( $this->customer->userName )) {
				$filter = new CustomerVo ();
				$filter->userName = $this->customer->userName;
				$voResult = $this->customerSv->selectByFilter ( $filter );
				if (count ( $voResult ) > 0 && ! empty ( $this->customer->userName ) && $customerOld->userName != $this->customer->userName) {
					$this->addFieldError ( "customer[userName]", Lang::getWithFormat ( "{0} has already existed", $this->customer->userName ) );
				}
			}
		}
	}
	private function validEditForm() {
		if (AppUtil::isEmptyString ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->customer->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->customer->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is not a valid email mx address", $this->customer->email ) );
		}
		
		if (AppUtil::isEmptyString ( $this->customer->languageCode )) {
			$this->addFieldError ( "customer[languageCode]", Lang::get ( "Please select language code" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (strlen ( $this->customer->password ) < 3 && ! empty ( $this->customer->password )) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Your password must contain at least 3 characters" ) );
		}
		if ($this->customer->password != $this->cPassword && ! empty ( $this->customer->password )) {
			$this->addFieldError ( "cPassword", Lang::get ( "Invalid confirm password" ) );
		}
	}
	private function validAddForm() {
		if (AppUtil::isEmptyString ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->customer->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->customer->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is not a valid email mx address", $this->customer->email ) );
		}
		
		if (AppUtil::isEmptyString ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->password )) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Password can not be empty" ) );
		} else if (strlen ( $this->customer->password ) < 6) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Your password must contain at least 6 characters" ) );
		} else if ($this->customer->password != $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Invalid confirm password" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->customer->id )) {
			$this->addActionError ( Lang::get ( "You can't view a customer with empty id" ) );
		} elseif (! is_int ( intval ( $this->customer->id ) )) {
			$this->addActionError ( Lang::get ( "Customer id required integer" ) );
		} else {
			$customerDetail = $this->customerSv->selectBykey ( $this->customer );
			if (! isset ( $customerDetail )) {
				$this->addActionError ( Lang::getWithFormat ( "Not found customer with id {0}", $this->customer->id ) );
			} else {
				$this->customer = $customerDetail;
			}
		}
	}
	private function getCustomers() {
		$filter = $this->buildFilter ();
		$count = $this->customerSv->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$paging->records = $this->customerSv->search ( $filter );
		$this->customerList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "cr_date desc" );
		StringUtil::clearObject ( $filter );
		return $filter;
	}
}