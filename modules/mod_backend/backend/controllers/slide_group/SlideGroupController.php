<?php

namespace backend\controllers\slide_group;

use common\filter\slide_group\SlideGroupFilter;
use common\model\SlideGroupMo;
use common\persistence\base\vo\SlideGroupVo;
use common\services\slide_group\SlideGroupService;
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
class SlideGroupController extends PagingController {
	// Data request
	public $slideGroupMo;
	// Data response
	public $slideGroupVo;
	public $slideGroupList;
	public $listSlideGroupGroup;
	public $slideGroupOldId;
	private $listFileUpload;
	private $slideGroupService;
	public function __construct() {
		parent::__construct ();
		$this->slideGroupVo = new SlideGroupVo ();
		$this->slideGroupMo = new SlideGroupMo ();
		$this->filter = new SlideGroupFilter ();
		$this->slideGroupService = new SlideGroupService ();
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
		$this->slideGroupService->createWithFileSlide ( $this->slideGroupVo, $this->listFileUpload );
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
		$this->slideGroupVo->crDate = null;
		$this->slideGroupVo->crBy = null;
		$this->slideGroupService->update ( $this->slideGroupVo );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->slideGroupService->delete ( $this->slideGroupMo );
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
		$this->slideGroupService->copy ( $this->slideGroupVo, $this->slideGroupOldId );
		return "success";
	}
	private function validFormUpload() {
		if (! isset ( $_FILES ['fileUpload'] )) {
			return;
		}
		$this->listFileUpload = $_FILES ['fileUpload'];
		$listFileTypeLimit = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "slide.type.limit" ), array (
				"application/pdf" 
		) );
		
		$fileSizeLimit = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "slide.size.limit" ), 1000000 ); // 10MB
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
		$this->slideGroupMo = StringUtil::clearObject ( $this->slideGroupMo );
		AppUtil::copyProperties ( $this->slideGroupMo, $this->slideGroupVo );
		$this->slideGroupVo->crBy = empty ( SessionUtil::get ( ApplicationConfig::get("session.user.login.name") ) ) ? 0 : SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
		$this->slideGroupVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->slideGroupVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->slideGroupVo->mdBy = empty ( SessionUtil::get ( ApplicationConfig::get("session.user.login.name") ) ) ? 0 : SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			// Valid SlideGroupName already existed/
			$filter = new SlideGroupVo ();
			$filter->name = $this->slideGroupMo->name;
			$slideGroupVoResult = $this->slideGroupService->selectByFilter ( $filter );
			if (count ( $slideGroupVoResult ) > 0 && $slideGroupVoResult [0]->name == $this->slideGroupMo->name) {
				$this->addFieldError ( "slideGroupMo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->slideGroupMo->name ) );
			}

            $filter = new SlideGroupVo ();
            $filter->code = $this->slideGroupMo->code;
            $slideGroupVoResult = $this->slideGroupService->selectByFilter ( $filter );
            if (count ( $slideGroupVoResult ) > 0 && $slideGroupVoResult [0]->code == $this->slideGroupMo->code) {
                $this->addFieldError ( "slideGroupMo[code]", Lang::getWithFormat ( " {0} has already existed!", $this->slideGroupMo->code ) );
            }
		}
	}
	private function validEditData() {
		$this->validFormEdit ();
		if (! $this->hasErrors ()) {
			// Valid SlideGroupName already existed/
			$filter = new SlideGroupVo ();
			$filter->id = $this->slideGroupMo->id;
			$filter->name = $this->slideGroupMo->name;
			$slideGroupVoResult = $this->slideGroupService->selectByFilter ( $filter );

			$filter = new SlideGroupVo ();
			$filter->id = $this->slideGroupMo->id;
			$slideGroupOld = $this->slideGroupService->selectByKey ( $filter );

			if (count ( $slideGroupVoResult ) > 0 && $slideGroupOld->name != $this->slideGroupMo->name) {
				$this->addFieldError ( "slideGroupMo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->slideGroupMo->name ) );
			}

            // Valid SlideGroupName already existed/
            $filter = new SlideGroupVo ();
            $filter->id = $this->slideGroupMo->id;
            $filter->code = $this->slideGroupMo->code;
            $slideGroupVoResult = $this->slideGroupService->selectByFilter ( $filter );

            $filter = new SlideGroupVo ();
            $filter->id = $this->slideGroupMo->id;
            $slideGroupOld = $this->slideGroupService->selectByKey ( $filter );

            if (count ( $slideGroupVoResult ) > 0 && $slideGroupOld->code != $this->slideGroupMo->code) {
                $this->addFieldError ( "slideGroupMo[code]", Lang::getWithFormat ( " {0} has already existed!", $this->slideGroupMo->code ) );
            }

		}
	}
	private function validFormEdit() {
		if (AppUtil::isEmptyString ( $this->slideGroupMo->name )) {
			$this->addFieldError ( "slideGroupMo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->slideGroupMo->name )) {
				$this->addFieldError ( "slideGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->slideGroupMo->name ) );
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->slideGroupMo->name )) {
			$this->addFieldError ( "slideGroupMo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->slideGroupMo->name )) {
				$this->addFieldError ( "slideGroupMo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->slideGroupMo->name ) );
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->slideGroupMo->id )) {
			$this->addFieldError ( "slideGroupMo[id]", Lang::get ( "SlideGroup not valid." ) );
		} else {
			$this->slideGroupMo = $this->slideGroupService->selectBykey ( $this->slideGroupMo );
			$this->encryptMo = sha1 ( json_encode ( $this->slideGroupMo ) );
		}
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->slideGroupService->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$slideGroupVos = $this->slideGroupService->search ( $filter );
		$paging->records = $slideGroupVos;
		$this->slideGroupList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
}