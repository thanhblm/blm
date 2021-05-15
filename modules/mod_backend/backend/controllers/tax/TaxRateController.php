<?php

namespace backend\controllers\tax;

use common\persistence\base\vo\TaxRateVo;
use common\persistence\extend\vo\TaxRateExtendVo;
use common\services\tax\TaxRateService;
use common\utils\FileUtil;
use common\utils\StringUtil;
use core\common\Paging;
use core\Lang;
use core\utils\AppUtil;
use common\persistence\base\vo\TaxRateInfoVo;
use common\persistence\extend\vo\TaxRateInfoExtendVo;
use common\services\tax\TaxRateInfoService;
use core\BaseArray;
use common\services\tax_shipping_zone\TaxShippingZoneService;
use core\PagingController;

/**
 * *
 *
 * @author TANDT
 *        
 */
class TaxRateController extends PagingController {
	public $taxRate;
	public $taxRateList; // pagging
	public $taxRateOldId;
	public $fileNameDownload;
	public $filterTaxInfo;
	public $taxRateInfo;
	public $taxRateInfoList; // pagging
	public $taxShippingZones;
	public $indexTaxInfo;
	public $taxOrderBy;
	private $taxRateInfoSv;
	private $taxShippingZoneSv;
	private $taxRateSv;
	public function __construct() {
		parent::__construct ();
		$this->taxRate = new TaxRateExtendVo ();
		$this->taxRateSv = new TaxRateService ();
		$this->filter = new TaxRateExtendVo ();
		$this->taxRateInfo = new TaxRateInfoExtendVo ();
		$this->taxRateInfoSv = new TaxRateInfoService ();
		$this->taxRateInfoList = new BaseArray ( TaxRateInfoVo::class );
		$this->taxShippingZoneSv = new TaxShippingZoneService ();
	}
	public function listView() {
		$this->getTaxRates ();
		return "success";
	}
	public function search() {
		$this->getTaxRates ();
		return "success";
	}
	public function addView() {
		$this->taxRateInfo->taxRateId = "";
		$this->prepareShippingZoneList ();
		$this->getTaxRateInfos ();
		return "success";
	}
	public function add() {
		$this->prepareShippingZoneList ();
		$this->validAddData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		$this->taxRateSv->addTaxRate ( $this->taxRate, $this->taxRateInfoList );
		return "success";
	}
	public function editView() {
		$this->prepareShippingZoneList ();
		$this->detail ();
		$this->taxRateInfo->taxRateId = $this->taxRate->id;
		$this->getTaxRateInfos ();
		return "success";
	}
	public function edit() {
		$this->prepareShippingZoneList ();
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		$this->taxRate->crBy = null;
		$this->taxRate->crDate = null;
		$this->taxRateSv->updateWithInfo ( $this->taxRate, $this->taxRateInfoList );
		return "success";
	}
	public function copyView() {
		$this->prepareShippingZoneList ();
		$this->detail ();
		$this->taxRateInfo->taxRateId = $this->taxRate->id;
		$this->getTaxRateInfos ();
		foreach ( $this->taxRateInfoList->getArray () as $taxInfo ) {
			$taxInfo->id = "";
		}
		return "success";
	}
	public function copy() {
		$this->prepareShippingZoneList ();
		$this->validAddData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		$this->taxRate->id = null;
		$this->taxRateSv->addTaxRate ( $this->taxRate, $this->taxRateInfoList );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->taxRateSv->deleteWithInfo ( $this->taxRate );
		return "success";
	}
	public function exportCSV() {
		try {
			$listTaxRate = $this->taxRateSv->selectAll ();
			$fileNameDownload = FileUtil::exportCsvFromObjects ( $listTaxRate, TaxRateExtendVo::class );
		} catch ( \Exception $e ) {
			$this->addActionError ( $e->getMessage () );
			$this->getTaxRates ();
			return "error";
		}
		$this->fileNameDownload = $fileNameDownload;
		return "success";
	}
	public function addTaxInfoView() {
		$this->prepareShippingZoneList ();
		return "success";
	}
	private function getTaxRateInfos() {
		$this->taxRateInfo->order_by = $this->taxOrderBy;
		$taxRateInfos = $this->taxRateInfoSv->search ( $this->taxRateInfo );
		foreach ( $taxRateInfos as $taxRateInfo ) {
			$newTaxRateInfo = new TaxRateInfoVo ();
			AppUtil::copyProperties ( $taxRateInfo, $newTaxRateInfo );
			$this->taxRateInfoList->add ( $newTaxRateInfo );
		}
	}
	private function prepareData() {
		$this->taxRate->crBy = $this->getUserInfo ()->userId;
		$this->taxRate->crDate = date ( 'Y-m-d H:i:s' );
		$this->taxRate->mdDate = date ( 'Y-m-d H:i:s' );
		$this->taxRate->mdBy = $this->getUserInfo ()->userId;
	}
	private function validAddData() {
		$this->validAddForm ();
		if (! $this->hasErrors ()) {
			$filter = new TaxRateVo ();
			$filter->name = $this->taxRate->name;
			$voResult = $this->taxRateSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && ! empty ( $this->taxRate->name )) {
				$this->addFieldError ( "taxRate[name]", Lang::getWithFormat ( "{0} has already existed!", $this->taxRate->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validEditForm ();
		if (! $this->hasErrors ()) {
			$filter = new TaxRateVo ();
			$filter->id = $this->taxRate->id;
			$taxRateOld = $this->taxRateSv->selectByKey ( $filter );
			
			$filter = new TaxRateVo ();
			$filter->name = $this->taxRate->name;
			$voResult = $this->taxRateSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && ! empty ( $this->taxRate->name ) && $taxRateOld->name != $this->taxRate->name) {
				$this->addFieldError ( "taxRate[name]", Lang::getWithFormat ( "{0} has already existed!", $this->taxRate->name ) );
			}
		}
	}
	private function validEditForm() {
		if (AppUtil::isEmptyString ( $this->taxRate->name )) {
			$this->addFieldError ( "taxRate[name]", Lang::get ( "Name can not be empty" ) );
		}
		if (count ( $this->taxRateInfoList->getArray () ) > 0) {
			for($i = 0; $i < count ( $this->taxRateInfoList->getArray () ); $i ++) {
				$this->taxRateInfo = $this->taxRateInfoList->getArray () [$i];
				$this->validTaxInfoForm ( $i );
			}
		}
	}
	private function validAddForm() {
		if (AppUtil::isEmptyString ( $this->taxRate->name )) {
			$this->addFieldError ( "taxRate[name]", Lang::get ( "Name can not be empty" ) );
		}
		if (count ( $this->taxRateInfoList->getArray () ) > 0) {
			for($i = 0; $i < count ( $this->taxRateInfoList->getArray () ); $i ++) {
				$this->taxRateInfo = $this->taxRateInfoList->getArray () [$i];
				$this->validTaxInfoForm ( $i );
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->taxRate->id )) {
			$this->addActionError ( Lang::get ( "You can't view a taxRate with empty id!" ) );
		} elseif (! is_int ( intval ( $this->taxRate->id ) )) {
			$this->addActionError ( Lang::get ( "ID taxRate required integer!" ) );
		} else {
			$taxRateDetail = $this->taxRateSv->selectBykey ( $this->taxRate );
			if (! isset ( $taxRateDetail )) {
				$this->addActionError ( Lang::getWithFormat ( "Not found taxRate with ID {0}!", $this->taxRate->id ) );
			} else {
				$this->taxRate = $taxRateDetail;
			}
		}
	}
	private function getTaxRates() {
		$filter = $this->buildFilter ();
		$count = $this->taxRateSv->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$paging->records = $this->taxRateSv->search ( $filter );
		$this->taxRateList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	private function prepareShippingZoneList() {
		$this->taxShippingZones = $this->taxShippingZoneSv->selectAll ();
	}
	private function validIdTaxRate() {
		if (AppUtil::isEmptyString ( $this->taxRateInfo->taxRateId )) {
			$this->addActionError ( Lang::get ( "Please create new tax rate befor create a tax rate info" ) );
		}
	}
	private function validTaxInfoForm($index) {
		if (AppUtil::isEmptyString ( $this->taxRateInfo->name )) {
			$this->addFieldError ( "taxRateInfoList[$index][name]", Lang::get ( "Name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->taxRateInfo->name )) {
			$this->addFieldError ( "taxRateInfoList[$index][name]", Lang::getWithFormat ( "{0} is name using special character!", $this->taxRateInfo->name ) );
		}
		if (AppUtil::isEmptyString ( $this->taxRateInfo->zoneMatch )) {
			$this->addFieldError ( "taxRateInfoList[$index][zoneMatch]", Lang::get ( "Please select a Zone Match !" ) );
		}
		if (AppUtil::isEmptyString ( $this->taxRateInfo->taxShippingZoneId )) {
			$this->addFieldError ( "taxRateInfoList[$index][taxShippingZoneId]", Lang::get ( "Please select a Tax Shipping Zone !" ) );
		}
		if (! AppUtil::isEmptyString ( $this->taxRateInfo->rate ) && ! is_numeric ( $this->taxRateInfo->rate )) {
			$this->addFieldError ( "taxRateInfoList[$index][rate]", Lang::getWithFormat ( "{0} is not numeric!", $this->taxRateInfo->rate ) );
		}
		if (! AppUtil::isEmptyString ( $this->taxRateInfo->priority ) && ! is_numeric ( $this->taxRateInfo->priority )) {
			$this->addFieldError ( "taxRateInfoList[$index][priority]", Lang::getWithFormat ( "{0} is not numeric!", $this->taxRateInfo->priority ) );
		}
		
		if ("dynamic" === $this->taxRateInfo->type && AppUtil::isEmptyString($this->taxRateInfo->dynamicRate)) {
			$this->addFieldError ( "taxRateInfoList[$index][dynamicRate]", Lang::get( "Dynamic rate is required!"));
		}
	}
}