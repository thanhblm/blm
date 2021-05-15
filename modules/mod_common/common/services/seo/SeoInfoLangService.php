<?php

namespace common\services\seo;

use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\dao\SeoInfoLangExtendDao;
use common\services\base\BaseService;

class SeoInfoLangService extends BaseService{
	private $seoInfoLangDao;

	public function __construct(){
		$this->seoInfoLangDao = new SeoInfoLangExtendDao ();
	}

	public function selectByKey(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->selectByKey($seoInfoLangVo);
	}

	public function selectAll(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->selectAll($seoInfoLangVo);
	}

	public function selectByFilter(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->selectByFilter($seoInfoLangVo);
	}

	public function countByFilter(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->countByFilter($seoInfoLangVo);
	}

	public function insertDynamic(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->insertDynamic($seoInfoLangVo);
	}

	public function updateDynamicByKey(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->updateDynamicByKey($seoInfoLangVo);
	}

	public function deleteByKey(SeoInfoLangVo $seoInfoLangVo = null){
		return $this->seoInfoLangDao->deleteByKey($seoInfoLangVo);
	}

	public function deleteByFilter(SeoInfoLangVo $seoInfoLangVo){
		return $this->seoInfoLangDao->deleteByFilter($seoInfoLangVo);
	}

	public function getSeoInfoLangByProduct(SeoInfoLangVo $filter){
		return $this->seoInfoLangDao->getSeoInfoLangByProduct($filter);
	}

	public function getSeoInfoLangByCategory(SeoInfoLangVo $filter){
		return $this->seoInfoLangDao->getSeoInfoLangByCategory($filter);
	}

	public function getSeoInfoLangByCategoryBlog(SeoInfoLangVo $filter){
		return $this->seoInfoLangDao->getSeoInfoLangByCategoryBlog($filter);
	}

	public function getSeoInfoLangByBlog(SeoInfoLangVo $filter){
		return $this->seoInfoLangDao->getSeoInfoLangByBlog($filter);
	}

}