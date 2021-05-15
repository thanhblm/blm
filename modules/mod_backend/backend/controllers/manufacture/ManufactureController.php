<?php

namespace backend\controllers\manufacture;

use common\filter\manufacture\ManufactureFilter;
use common\model\ManufactureGroupMo;
use common\persistence\base\vo\ManufactureVo;
use common\services\manufacture\ManufactureService;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\SessionUtil;

/**
 *
 * @author TANDT
 *        
 */
class ManufactureController extends PagingController {
	// Data request
	public $manufactureMo;
	public $encryptMo;
	// Data response
	public $manufactureVo;
	public $manufactureList;
	public $listManufactureGroup;
	public $manufactureGroupMo;
	public $listFileUpload;
	public $manufactureGroupId;
	//
	private $manufactureService;
	public function __construct() {
		parent::__construct ();
		$this->manufactureVo = new ManufactureVo ();
		$this->manufactureMo = new ManufactureVo ();
		$this->filter = new ManufactureFilter ();
		$this->manufactureService = new ManufactureService ();
	}
	public function listView() {
		$this->getList ();
		return "success";
	}
	public function search() {
		$this->getList ();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validForm ();
		if ($this->hasFieldErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->manufactureService->createManufacture ( $this->manufactureVo );
		return "success";
	}
	public function editView() {
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->preapareData ();
		$this->manufactureVo->crDate = null;
		$this->manufactureVo->crBy = null;
		$this->manufactureService->updateManufacture ( $this->manufactureVo );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->manufactureService->delete($this->manufactureMo );
		return "success";
	}
	private function preapareData() {
		StringUtil::clearObject ( $this->manufactureMo );
		AppUtil::copyProperties ( $this->manufactureMo, $this->manufactureVo );
		$this->manufactureVo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
		$this->manufactureVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->manufactureVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->manufactureVo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
	}
	private function validForm() {
		if (isset ( $this->manufactureGroupMo->name )) {
			if (AppUtil::isEmptyString ( $this->manufactureGroupMo->name )) {
				$this->addFieldError ( "manufactureGroupMo[name]", Lang::get ( "Name can not be empty" ) );
			} else {
				if (! StringUtil::validName ( $this->manufactureGroupMo->name )) {
					$this->addFieldError ( "manufactureGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->manufactureGroupMo->name ) );
				}
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->manufactureMo->id )) {
			$this->addFieldError ( "manufactureMo[id]", Lang::get ( "Manufacture id not valid." ) );
		} else {
			$this->manufactureMo = $this->manufactureService->selectBykey ( $this->manufactureMo );
		}
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->manufactureService->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$manufactureVos = $this->manufactureService->search ( $filter );
		$paging->records = $manufactureVos;
		$this->manufactureList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
}