<?php

namespace frontend\controllers\faq;

use common\helper\LocalizationHelper;
use common\persistence\base\vo\SeoInfoLangVo;
use common\services\seo\SeoInfoLangService;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class FaqController extends FrontendController {
	public $seoInfoVo;
	private $seoInfoLangService;
	public function __construct() {
		parent::__construct ();
		$this->seoInfoVo = new SeoInfoLangVo ();
		$this->seoInfoLangService = new SeoInfoLangService ();
	}
	public function show() {
		$this->getSeoInfo ( 126 );
		return "success";
	}
	protected function getSeoInfo($itemId) {
		$this->seoInfoVo->itemId = $itemId;
		$this->seoInfoVo->type = "page";
		$this->seoInfoVo->languageCode = LocalizationHelper::getLangCode ();
		$seoInfoLang = $this->seoInfoLangService->selectByFilter ( $this->seoInfoVo );
		if (AppUtil::isEmptyString ( $seoInfoLang [0]->title )) {
			$this->seoInfoVo = new SeoInfoLangVo ();
			$this->seoInfoVo->itemId = $itemId;
			$this->seoInfoVo->type = "page";
			$this->seoInfoVo->languageCode = "en";
			$seoInfoLang = $this->seoInfoLangService->selectByFilter ( $this->seoInfoVo );
		}
		$seoInfoLang[0]->description = str_replace(array('<p>','</p>'), array('',''), $seoInfoLang[0]->description);
		$this->seoInfoVo = $seoInfoLang [0];
	}
}