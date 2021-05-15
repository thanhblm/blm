<?php
namespace common\persistence\extend\vo;

use common\persistence\base\vo\CategoryVo;

class CategoryHomeExtendVo extends CategoryVo{
	public $languageCode;
	public $type;
	public $seoUrl;
	public $seoTitle;
	public $seoKeywords;
	public $seoDescription;
	public $listChild;
	
	public function __construct(){
		parent::__construct();
		$this->resultMap['language_code'] = 'languageCode';
		$this->resultMap['type'] = 'type';
		$this->resultMap['seo_url'] = 'seoUrl';
		$this->resultMap['seo_title'] = 'seoTitle';
		$this->resultMap['seo_keywords'] = 'seoKeywords';
		$this->resultMap['seo_description'] = 'seoDescription';
		$this->resultMap['list_child'] = 'listChild';
	}
}