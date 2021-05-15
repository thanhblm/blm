<?php

namespace backend\controllers\batch;

use common\filter\batch\BatchFilter;
use common\model\BatchGroupMo;
use common\persistence\base\vo\BatchGroupVo;
use common\persistence\base\vo\BatchVo;
use common\services\batch\BatchService;
use common\services\batch_group\BatchGroupService;
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
class BatchController extends PagingController {
	// Data request
	public $batchMo;
	public $encryptMo;
	// Data response
	public $batchVo;
	public $batchList;
	public $listBatchGroup;
	public $batchGroupMo;
	public $listFileUpload;
	public $batchGroupId;
	//
	private $batchService;
	private $batchGroupService;
	public function __construct() {
		parent::__construct ();
		$this->batchVo = new BatchVo ();
		$this->batchMo = new BatchVo ();
		$this->filter = new BatchFilter ();
		$this->batchService = new BatchService ();
		$this->batchGroupMo = new BatchGroupMo ();
		$this->batchGroupService = new BatchGroupService ();
	}
	public function listView() {
		$this->detailBatchGroup ();
		$this->getAllBatchGroup ();
		$this->getList ();
		return "success";
	}
	public function search() {
		$this->getList ();
		return "success";
	}
	public function addView() {
		$this->getAllBatchGroup ();
		$this->detailBatchGroup ();
		return "success";
	}
	public function add() {
		$this->validForm ();
		$this->validFormUpload ();
		$this->getAllBatchGroup ();
		if ($this->hasActionErrors ()) {
			return "error";
		}
		if ($this->hasFieldErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->batchService->createBatch ( $this->batchVo, $this->listFileUpload );
		return "success";
	}
	public function confirmUpload() {
		$this->preapareData ();
		$this->batchService->createBatch ( $this->batchVo, $_FILES ['fileUpload'] );
		return "success";
	}
	public function editView() {
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->preapareData ();
		$this->batchVo->crDate = null;
		$this->batchVo->crBy = null;
		$this->batchService->updateBatch ( $this->batchVo );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->batchService->deleteBatch ( $this->batchMo );
		return "success";
	}
	public function addBatchGroup() {
		$this->validFormQuickAddGroup ();
		if (! $this->hasErrors ()) {
			$this->preapareBatchGroupData ();
			$this->batchGroupService->create ( $this->batchGroupMo );
		}
		$this->getAllBatchGroup ();
		$this->detailBatchGroup ();
		return "success";
	}
	private function validFormQuickAddGroup() {
		if (AppUtil::isEmptyString ( $this->batchGroupMo->name )) {
			$this->addFieldError ( "batchGroupMo[name]", Lang::get ( "Group Name can not be empty" ) );
		} else if (! StringUtil::validName ( $this->batchGroupMo->name )) {
			$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( "{0} is Group Name not contain speacial character.", $this->batchGroupMo->name ) );
		}
	}
	private function preapareBatchGroupData() {
		$this->batchGroupMo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
		$this->batchGroupMo->crDate = date ( 'Y-m-d H:i:s' );
		$this->batchGroupMo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->batchGroupMo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
	}
	private function validFormUpload() {
		if (! isset ( $_FILES ['fileUpload'] )) {
			$this->addFieldError ( "fileUpload", Lang::get ( "File Upload required" ) );
			return;
		}
		$patchBatch = ApplicationConfig::get ( "batch.path" ) . $this->batchMo->batchGroupId . DS;
		$this->listFileUpload = $_FILES ['fileUpload'];
		
		$listFileTypeLimit = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "batch.type.limit" ), array (
				"application/pdf" 
		) );
		
		$fileSizeLimit = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "batch.size.limit" ), 1000000 ); // 10MB
		for($i = 0; $i < count ( $this->listFileUpload ['name'] ); $i ++) {
			$fileSize = $this->listFileUpload ['size'] [$i];
			$fileName = $this->listFileUpload ['name'] [$i];
			$fileType = $this->listFileUpload ['type'] [$i];
			$fileTemp = $this->listFileUpload ['tmp_name'] [$i];
			$fileError = $this->listFileUpload ['error'] [$i];
			
			if (file_exists ( $patchBatch . $fileName )) {
				$this->addActionError ( Lang::getWithFormat ( "File name {0} has already existed!", $fileName ) );
			} else {
				$pos = strrpos ( $fileName, '-', - 1 );
				$fileNameRule = substr ( $fileName, $pos );
				
				// Valid file size
				if ($fileSize > $fileSizeLimit) {
					$this->addFieldError ( "fileUpload", Lang::getWithFormat ( "File name {0} Over size limit value {1}!", $fileName, $fileSizeLimit ) );
				}
				if (! in_array ( $fileType, $listFileTypeLimit )) {
					$this->addFieldError ( "fileUpload", Lang::getWithFormat ( "File name {0} could not allow type {1}!", $fileName, $fileType ) );
				}
				if ("-" != substr ( $fileNameRule, 0, 1 ) || ! is_numeric ( substr ( $fileNameRule, 1, (strrpos ( $fileNameRule, '.' ) - 1) ) )) {
					$this->addFieldError ( "fileUpload", Lang::getWithFormat ( "File name has to be cbd-oil-{0}.pdf, where {1} is any number", $fileName, $fileName) );
				}
			}
		}
	}
	private function detailBatchGroup() {
		if (! AppUtil::isEmptyString ( $this->batchMo->batchGroupId )) {
			$batchGroupVo = new BatchGroupVo ();
			$batchGroupVo->id = $this->batchMo->batchGroupId;
			$batchGroupVo = $this->batchGroupService->selectByKey ( $batchGroupVo );
			$this->batchMo->batchGroupId = null;
			$this->filter->batchGroupName = $batchGroupVo->name;
		}
	}
	private function preapareData() {
		StringUtil::clearObject ( $this->batchMo );
		AppUtil::copyProperties ( $this->batchMo, $this->batchVo );
		$this->batchVo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
		$this->batchVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->batchVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->batchVo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->batchMo->batchGroupId )) {
			$this->addFieldError ( "batchMo[batchGroupId]", Lang::get ( "Please select Batch Group !" ) );
		} else {
			if (! is_int ( intval ( $this->batchMo->batchGroupId ) )) {
				$this->addFieldError ( "batchMo[batchGroupId]", $this->userMo->batchGroupId . " " . Lang::get ( " is not a valid Integer" ) );
			}
		}
		if (isset ( $this->batchGroupMo->name )) {
			if (AppUtil::isEmptyString ( $this->batchGroupMo->name )) {
				$this->addFieldError ( "batchGroupMo[name]", Lang::get ( "Name can not be empty" ) );
			} else {
				if (! StringUtil::validName ( $this->batchGroupMo->name )) {
					$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->batchGroupMo->name ) );
				}
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->batchMo->id )) {
			$this->addFieldError ( "batchMo[id]", Lang::get ( "Batch id not valid." ) );
		} else {
			$this->batchMo = $this->batchService->selectBykey ( $this->batchMo );
		}
	}
	private function getAllBatchGroup() {
		$batchGroupSv = new BatchGroupService ();
		$batchGroupVo = new BatchGroupVo ();
		$this->listBatchGroup = $batchGroupSv->selectByFilter ( $batchGroupVo );
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->batchService->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$batchVos = $this->batchService->search ( $filter );
		$paging->records = $batchVos;
		$this->batchList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		$filter->batchGroupId = $this->batchMo->batchGroupId;
		return $filter;
	}
}