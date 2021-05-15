<?php

namespace backend\controllers\attribute_group;

use common\filter\attribute_group\AttributeGroupFilter;
use common\persistence\extend\vo\AttrGroupExtendVo;
use common\services\attribute\AttributeGroupService;
use common\utils\StringUtil;
use core\Lang;
use core\PagingController;
use core\common\Paging;
use core\utils\AppUtil;
use common\persistence\base\vo\AttrGroupVo;

/**
 * *
 *
 * @author CuongNM
 *        
 */
class AttributeGroupController extends PagingController {
	public $attrGroupList;
	public $attrGroupVo;
	private $attrGroupSv;
	
	public function __construct() {
		parent::__construct ();
		$this->attrGroupSv= new AttributeGroupService();
		$this->attrGroupVo= new AttrGroupExtendVo();
		$this->filter = new AttributeGroupFilter();
		$this->pageTitle = Lang::get("Attribute Group Manage");
	}
	
	public function listView(){
		$this->getAttrGroupList();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->attrGroupSv->add($this->attrGroupVo);
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
		$this->attrGroupSv->update( $this->attrGroupVo );
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
		$this->attrGroupSv->add( $this->attrGroupVo );
		return "success";
	} 
	
	public function delView() {
		$this->detail();
		return "success";
	}
	public function del() {
		$this->attrGroupSv->delete($this->attrGroupVo );
		return "success";
	}
	
	private function getAttrGroupList(){
		$filter = $this->buildFilter ();
		$totalRecords = $this->attrGroupSv->searchCount($filter);
		$listAttrGroupPagging = new Paging($totalRecords, $this->pageSize, $this->getNLinks(), $this->page);
		$filter->start_record = $listAttrGroupPagging->startRecord - 1;
		$filter->end_record = $listAttrGroupPagging->pageSize;
		$listAttrGroupPagging->records = $this->attrGroupSv->search($filter);
		$this->attrGroupList= $listAttrGroupPagging;
	}
	
	private function buildFilter(){
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->attrGroupVo->name )) {
			$this->addFieldError ( "attrGroupVo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->attrGroupVo->name )) {
				$this->addFieldError ( "attrGroupVo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->attrGroupVo->name ) );
			}
		}
	}
	
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			$filter = new AttrGroupVo();
			$filter->name = $this->attrGroupVo->name;
			$attrGroupVoResult = $this->attrGroupSv->getByFilter( $filter );
			if (count ( $attrGroupVoResult ) > 0) {
				foreach ($attrGroupVoResult as $attrGVo){
					if($attrGVo->name == $this->attrGroupVo->name){
						$this->addFieldError ( "attrGroupVo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->attrGroupVo->name ) );
						break;
					}
				}
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->attrGroupVo->id )) {
			$this->addFieldError ( "attrGroupVo[id]", Lang::get ( "attrGroup not valid." ) );
		} else {
			$this->attrGroupVo = $this->attrGroupSv->selectByKey($this->attrGroupVo);
		}
	}
	private function validEditData() {
		$this->validFormEdit ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			$filter = new AttrGroupVo ();
			$filter->id = $this->attrGroupVo->id;
			$attrGroupOld = $this->attrGroupSv->selectByKey( $filter );
			if ($attrGroupOld->name !=  $this->attrGroupVo->name ) {
				$filter = new AttrGroupVo();
				$filter->name = $this->attrGroupVo->name;
				$attrGroupVoResult = $this->attrGroupSv->getByFilter( $filter );
				if(count($attrGroupVoResult) > 0){
					foreach ($attrGroupVoResult as $attrGVo){
						if($attrGVo->name == $this->attrGroupVo->name){
							$this->addFieldError ( "attrGroupVo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->attrGroupVo->name ) );
							break;
						}
					}
				}
			}
		}
	}
	private function validFormEdit() {
		if (AppUtil::isEmptyString ( $this->attrGroupVo->name )) {
			$this->addFieldError ( "attrGroupVo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->attrGroupVo->name )) {
				$this->addFieldError ( "attrGroupVo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->attrGroupVo->name ) );
			}
		}
	}
}