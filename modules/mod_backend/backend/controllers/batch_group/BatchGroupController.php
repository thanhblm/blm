<?php

namespace backend\controllers\batch_group;

use common\filter\batch_group\SlideGroupFilter;
use common\model\BatchGroupMo;
use common\persistence\base\vo\BatchGroupVo;
use common\services\batch_group\SlideGroupService;
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
class BatchGroupController extends PagingController {
	// Data request
	public $batchGroupMo;
	// Data response
	public $batchGroupVo;
	public $batchGroupList;
	public $listBatchGroupGroup;
	public $batchGroupOldId;
	private $listFileUpload;
	private $batchGroupService;
	public function __construct() {
		parent::__construct ();
		$this->batchGroupVo = new BatchGroupVo ();
		$this->batchGroupMo = new BatchGroupMo ();
		$this->filter = new SlideGroupFilter ();
		$this->batchGroupService = new SlideGroupService ();
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
		$this->validData ();
		$this->validFormUpload ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->batchGroupService->createWithFileBatch ( $this->batchGroupVo, $this->listFileUpload );
		return "success";
	}
	public function editView() {
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->batchGroupVo->crDate = null;
		$this->batchGroupVo->crBy = null;
		$this->batchGroupService->update ( $this->batchGroupVo );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->batchGroupService->delete ( $this->batchGroupMo );
		return "success";
	}
	public function copyView() {
		$this->detail ();
		return "success";
	}
	public function copy() {
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->batchGroupService->copy ( $this->batchGroupVo, $this->batchGroupOldId );
		return "success";
	}
	private function validFormUpload() {
		if (! isset ( $_FILES ['fileUpload'] )) {
			return;
		}
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
				$this->addFieldError ( "fileUpload", Lang::getWithFormat ( "File name has to be cbd-oil-{0}.pdf, where {1} is any number.", $fileName, $fileName) );
			}
		}
	}
	private function preapareData() {
		$this->batchGroupMo = StringUtil::clearObject ( $this->batchGroupMo );
		AppUtil::copyProperties ( $this->batchGroupMo, $this->batchGroupVo );
		$this->batchGroupVo->crBy = empty ( SessionUtil::get ( ApplicationConfig::get("session.user.login.name") ) ) ? 0 : SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
		$this->batchGroupVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->batchGroupVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->batchGroupVo->mdBy = empty ( SessionUtil::get ( ApplicationConfig::get("session.user.login.name") ) ) ? 0 : SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			$filter = new BatchGroupVo ();
			$filter->name = $this->batchGroupMo->name;
			$batchGroupVoResult = $this->batchGroupService->selectByFilter ( $filter );
			if (count ( $batchGroupVoResult ) > 0 && $batchGroupVoResult [0]->name == $this->batchGroupMo->name) {
				$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->batchGroupMo->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validFormEdit ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			$filter = new BatchGroupVo ();
			$filter->id = $this->batchGroupMo->id;
			$filter->name = $this->batchGroupMo->name;
			$batchGroupVoResult = $this->batchGroupService->selectByFilter ( $filter );
			
			$filter = new BatchGroupVo ();
			$filter->id = $this->batchGroupMo->id;
			$batchGroupOld = $this->batchGroupService->selectByKey ( $filter );
			
			if (count ( $batchGroupVoResult ) > 0 && $batchGroupOld->name != $this->batchGroupMo->name) {
				$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->batchGroupMo->name ) );
			}
		}
	}
	private function validFormEdit() {
		if (AppUtil::isEmptyString ( $this->batchGroupMo->name )) {
			$this->addFieldError ( "batchGroupMo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->batchGroupMo->name )) {
				$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->batchGroupMo->name ) );
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->batchGroupMo->name )) {
			$this->addFieldError ( "batchGroupMo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->batchGroupMo->name )) {
				$this->addFieldError ( "batchGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->batchGroupMo->name ) );
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->batchGroupMo->id )) {
			$this->addFieldError ( "batchGroupMo[id]", Lang::get ( "BatchGroup not valid." ) );
		} else {
			$this->batchGroupMo = $this->batchGroupService->selectBykey ( $this->batchGroupMo );
			$this->encryptMo = sha1 ( json_encode ( $this->batchGroupMo ) );
		}
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->batchGroupService->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$batchGroupVos = $this->batchGroupService->search ( $filter );
		$paging->records = $batchGroupVos;
		$this->batchGroupList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
}