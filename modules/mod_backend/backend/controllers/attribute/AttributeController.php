<?php

namespace backend\controllers\attribute;

use common\filter\attribute_group\AttributeFilter;
use common\helper\ProductHelper;
use common\persistence\base\vo\AttrGroupVo;
use common\persistence\base\vo\AttributeVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\extend\vo\AttrGroupExtendVo;
use common\persistence\extend\vo\AttributeExtendVo;
use common\persistence\extend\vo\CategoryExtendVo;
use common\services\attribute\AttributeGroupService;
use common\services\attribute\AttributeService;
use common\services\attribute\ProductAttributeService;
use common\services\category\CategoryService;
use common\utils\StringUtil;
use core\BaseArray;
use core\common\Paging;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

/**
 * *
 *
 * @author CuongNM
 *        
 */
class AttributeController extends PagingController {
	public $attributeList;
	public $attributeVo;
	public $categoryList;
	public $categoryId;
	public $productId;
	public $groupAttributes;
	public $productAttributes;
	public $productAttribute;
	public $attrGroupList;
	public $groupAttributeExtVos;
	public $attributeSelect;
	public $attrGroupListId;
	public $attributeOldId;
	public $isEnableEditPrice;
	private $attributeSv;
	
	public function __construct() {
		parent::__construct ();
		$this->attributeSv = new AttributeService();
		$this->attributeVo = new AttributeExtendVo();
		$this->filter = new AttributeFilter();
		$this->pageTitle = Lang::get("Attribute Manage");
		$this->productAttribute = new ProductAttributeVo();
	}
	
	public function listView(){
		if(!AppUtil::isEmptyString($this->productId)){
			if($this->categoryId === ""){
				$this->addActionError(Lang::get("Please select a category befor edit attribute"));
				return "success";
			}
			$productAttributeSv = new ProductAttributeService();
			$productAttributeVo = new ProductAttributeVo();
			$productAttributeVo->productId = $this->productId;
			$this->productAttributes = $productAttributeSv->getByFilter($productAttributeVo);
			$this->groupAttributeExtVos = ProductHelper::getAttributeProduct($this->productId);
		}
		$this->getAttributeList();
		$this->getCategoryList();
		$this->getAttrGroupList();
		return "success";
	}
	public function addView() {
		$this->getCategoryList();
		$this->getAttrGroupList();
		return "success";
	}
	public function add() {
		$this->validData ();
		if ($this->hasErrors ()) {
			$this->getCategoryList();
			$this->getAttrGroupList();
			return "success";
		}
		$this->attributeSv->add($this->attributeVo);
		return "success";
	}
	
	public function editView() {
		$this->detail ();
		$this->getCategoryList();
		$this->getAttrGroupList();
		return "success";
	}
	public function edit() {
		$this->validEditData();
		if ($this->hasErrors ()) {
			$this->getCategoryList();
			$this->getAttrGroupList();
			return "success";
		}
		$this->attributeSv->update( $this->attributeVo );
		return "success";
	}
	public function copyView() {
		$this->detail ();
		$this->getCategoryList();
		$this->getAttrGroupList();
		return "success";
	}
	public function copy() {
		$this->validData ();
		if ($this->hasErrors ()) {
			$this->getCategoryList();
			$this->getAttrGroupList();
			return "success";
		}
		$this->attributeSv->add($this->attributeVo);
		return "success";
	}
	
	public function delView() {
		$this->detail();
		return "success";
	}
	public function del() {
		$this->attributeSv->delete($this->attributeVo );
		return "success";
	}

	public function removeView() {
		$this->detail();
		return "success";
	}

	public function remove() {
		$this->attributeSv->remove($this->productId,$this->attributeVo->id );
		return "success";
	}

	public function setView() {
		if(AppUtil::isEmptyString($this->productId)){
			$this->addActionError(Lang::get("Can't add set attribute for empty product!"));
		}
		if(AppUtil::isEmptyString($this->attributeVo->id)){
			$this->addActionError(Lang::get("Please select a attribute befor set for product."));
		}

		$attributeVo = $this->attributeSv->selectByKey($this->attributeVo);
		if(isset($attributeVo)){
			$attrGroupSv = new AttributeGroupService();
			$attrGroupVo = new AttrGroupVo();
			$attrGroupVo->id = $attributeVo->attrGroupId;
			$attrGroupVo = $attrGroupSv->selectByKey($attrGroupVo);
		}else{
			$this->addActionError(Lang::get("Please select a attribute valid befor set for product."));
		}
		return "success";
	}

	public function setAttribute() {
		if(AppUtil::isEmptyString($this->productId)){
			$this->addActionError(Lang::get("Can't add set attribute for empty product!"));
		}
		if(AppUtil::isEmptyString($this->attributeVo->id)){
			$this->addActionError(Lang::get("Please select a attribute befor set for product."));
		}

		$attributeVo = $this->attributeSv->selectByKey($this->attributeVo);
		if(isset($attributeVo)){
			$attrGroupSv = new AttributeGroupService();
			$attrGroupVo = new AttrGroupVo();
			$attrGroupVo->id = $attributeVo->attrGroupId;
			$attrGroupVo = $attrGroupSv->selectByKey($attrGroupVo);
		}else{
			$this->addActionError(Lang::get("Please select a attribute valid befor set for product."));
		}
		if($this->hasErrors()){
			return "success";
		}
		$attrGroupExtVo = new AttrGroupExtendVo();
		if(isset($attrGroupVo)){
			AppUtil::copyProperties($attrGroupVo, $attrGroupExtVo);
		}
		$groupAttributeExts = ProductHelper::getAttributeProduct($this->productId);

		$isAddGroup = true;
		foreach ($groupAttributeExts as $groupAttributeExt){
			if($attrGroupExtVo->id == $groupAttributeExt->id){
				$groupAttributeExt->listAttr->add($attributeVo);

				$isAddGroup = false;
				break;
			}
		}
		if($isAddGroup){
			$listArrayAttr = new BaseArray(AttributeVo::class);
			$listArrayAttr->add($attrGroupVo);
			$attrGroupExtVo->listAttr = $listArrayAttr;
			array_push($groupAttributeExts, $attrGroupExtVo);
		}

		$productAttributeSv = new ProductAttributeService();
		$productAttributeVo = new ProductAttributeVo();
		$productAttributeVo->productId = $this->productId;
		$productAttributeVo->attributeId = '['.$attributeVo->id.']';
		$productAttributeSv->add($productAttributeVo);
		return "success";
	}

	public function selectAttribute(){
		$this->isEnableEditPrice = " disabled ";
		if(isset($this->attrGroupListId) && isset($this->attributeSelect) && count($this->attrGroupListId) === count($this->attributeSelect)){
			$this->isEnableEditPrice = "";
			$this->productAttribute->attributeId = str_replace("\"","",json_encode($this->attributeSelect));
			$productAttributeSv = new ProductAttributeService();
			$productAttributeVo = new ProductAttributeVo();
			$productAttributeVo->productId = $this->productAttribute->productId;
			$productAttributeVo->attributeId = $this->productAttribute->attributeId;
			if(count($productAttributeSv->countByFilter($productAttributeVo)) >= 0){
				$productAttributeVo = $productAttributeSv->getByFilter($productAttributeVo)[0];
				$this->productAttribute->price = $productAttributeVo->price;
				$this->productAttribute->quantity = $productAttributeVo->quantity;
			}
			$this->addActionMessage(Lang::get("Wow, you can set price and quantity for this case."));
		}else{
			$this->addActionError(Lang::get("Please select a attribute in all group."));
		}

		return "success";
	}

	public function updateProductAttribute(){
		if(isset($this->attrGroupListId) && isset($this->attributeSelect) && count($this->attrGroupListId) === count($this->attributeSelect)){
			$this->isEnableEditPrice = "";
			if(AppUtil::isEmptyString($this->productAttribute->quantity)){
				$this->productAttribute->quantity = 0;
			}
			if(AppUtil::isEmptyString($this->productAttribute->price)){
				$this->productAttribute->price = 0;
			}
			$this->productAttribute->attributeId = str_replace("\"","",json_encode($this->attributeSelect));
			$productAttributeSv = new ProductAttributeService();
			$productAttributeVo = new ProductAttributeVo();
			$productAttributeVo->productId = $this->productAttribute->productId;
			$productAttributeVo->attributeId = $this->productAttribute->attributeId;
			if(count($productAttributeSv->countByFilter($productAttributeVo)) == 0){
				$productAttributeSv->add($this->productAttribute);
			}else{
				$productAttributeVo = $productAttributeSv->getByFilter($productAttributeVo)[0];
				$this->productAttribute->id = $productAttributeVo->id;
				$productAttributeSv->update($this->productAttribute);
			}
		}else{
			$this->addActionError(Lang::get("Please select a attribute in all group."));
		}
		$this->addActionMessage(Lang::get("Update Success."));
		return "success";
	}

	private function getAttributeList(){
		$filter = $this->buildFilter ();
		$this->filter = $filter;

		$totalRecords = $this->attributeSv->searchCount($this->filter);
		$listAttributePagging = new Paging($totalRecords, $this->pageSize, $this->getNLinks(), $this->page);
		$filter->start_record = $listAttributePagging->startRecord - 1;
		$filter->end_record = $listAttributePagging->pageSize;
		$listAttributePagging->records = $this->attributeSv->search($this->filter);
		$this->attributeList = $listAttributePagging;

		if(!AppUtil::isEmptyString($this->productId)){
			$this->groupAttributes = ProductHelper::getAttributeProduct($this->productId);
		}

	}
	
	private function buildFilter(){
		$filter = $this->buildBaseFilter ( "id asc" );
		if(isset($this->categoryId)){
			$filter->categoryId = $this->categoryId;
		}
		return $filter;
	}

	private function validForm() {
		if (AppUtil::isEmptyString ( $this->attributeVo->name )) {
			$this->addFieldError ( "attributeVo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->attributeVo->name )) {
				$this->addFieldError ( "attributeVo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->attributeVo->name ) );
			}
		}
	}
	
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			/* $filter = new AttributeExtendVo();
			$filter->name = $this->attributeVo->name;
			$attributeVoResult = $this->attributeSv->getByFilter( $filter );
			if (count ( $attributeVoResult ) > 0 && $attributeVoResult [0]->name == $this->attributeVo->name) {
				$this->addFieldError ( "attributeVo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->attributeVo->name ) );
			} */
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->attributeVo->id )) {
			$this->addFieldError ( "attributeVo[id]", Lang::get ( "attributeVo not valid." ) );
		} else {
			$filter = new AttributeFilter();
			AppUtil::copyProperties($this->attributeVo, $filter);
			$this->attributeVo = $this->attributeSv->searchByKey($filter);
		}
	}
	private function validEditData() {
		$this->validFormEdit ();
		if (! $this->hasErrors ()) {
			// Valid BatchGroupName already existed/
			$filter = new AttributeExtendVo();
			$filter->id = $this->attributeVo->id;
			$filter->name = $this->attributeVo->name;
			$attributeVoResult = $this->attributeSv->getByFilter( $filter );
			
			$filter = new AttributeExtendVo();
			$filter->id = $this->attributeVo->id;
			$attributeOld = $this->attributeSv->selectByKey( $filter );

			if (count ( $attributeVoResult ) > 0 && $attributeOld->name != $this->attributeVo->name) {
				$this->addFieldError ( "attributeVo[name]", Lang::getWithFormat ( " {0} has already existed!", $this->attributeVo->name ) );
			}
		}
	}
	private function validFormEdit() {
		if (AppUtil::isEmptyString ( $this->attributeVo->name )) {
			$this->addFieldError ( "attributeVo[name]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (! StringUtil::validName ( $this->attributeVo->name )) {
				$this->addFieldError ( "attributeVo[name]", Lang::getWithFormat ( "{0} is Name not contain speacial character.", $this->attributeVo->name ) );
			}
		}
	}
	
	private function getCategoryList(){
		$categoryVo= new CategoryExtendVo();
		$categoryVo->status = "active";
		$categorySv = new CategoryService();
		$this->categoryList= $categorySv->selectByFilter($categoryVo);
	}
	private function getAttrGroupList(){
		$attrGroupVo= new AttrGroupVo();
		$attrGroupSv= new AttributeGroupService();
		$this->attrGroupList= $attrGroupSv->getByFilter($attrGroupVo);
	}
}