<?php

namespace frontend\controllers\misc_page;

use common\helper\LocalizationHelper;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\product\ProductHomeService;
use common\services\seo\SeoInfoLangService;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class MiscPageController extends FrontendController {
	public $seoInfoVo;
	private $seoInfoLangService;
	public $bestSellers;
	public function __construct() {
		parent::__construct ();
		$this->seoInfoVo = new SeoInfoLangVo ();
		$this->bestSellers = new ProductHomeExtendVo ();
		$this->seoInfoLangService = new SeoInfoLangService ();
	}
	public function termsAndConditions() {
		$this->getSeoInfo ( 131 );
		return "success";
	}
	public function autoshippingTermsAndConditions() {
		$this->getSeoInfo ( 132 );
		return "success";
	}
	public function anvisa() {
		$this->seoInfoVo->title = "Anvisa";
		$this->seoInfoVo->keywords = "";
		$this->seoInfoVo->description = "";
		return "success";
	}
	public function shippingInformation() {
		$this->getSeoInfo ( 133 );
		return "success";
	}
	public function paymentInformation() {
		$this->getSeoInfo ( 134 );
		return "success";
	}
	public function canCannabisCauseAllergicReactions() {
		$this->getSeoInfo ( 135 );
		return "success";
	}
	public function orderConfirmation() {
		$this->getSeoInfo ( 136 );
		return "success";
	}
	public function ourHemp() {
		$this->getSeoInfo ( 137 );
		return "success";
	}
	public function autoShippingDetails() {
		$this->getSeoInfo ( 138 );
		return "success";
	}
	public function willITestPositiveForCannabisIfIUseCbdHempOil() {
		$this->getSeoInfo ( 140 );
		return "success";
	}
	public function whyChooseEndoca() {
		$this->getSeoInfo ( 142 );
		$productHomeVo = new ProductHomeExtendVo ();
		$productHomeVo->regionId = $this->regionId;
		$productHomeVo->languageCode = $this->languageCode;
		$productHomeVo->currencyCode = $this->currencyCode;
		$productHomeVo->featured = "yes";
		$productHomeVo->status = "active";
		$productHomeService = new ProductHomeService ();
		$this->bestSellers = $productHomeService->getBestSellers ( $productHomeVo );
		return "success";
	}
	public function whichProductToChoose() {
		$this->getSeoInfo ( 143 );
		return "success";
	}
	public function cbdPriceCalculator() {
		$this->getSeoInfo ( 145 );
		return "success";
	}
	public function trustpilotReviews() {
		$this->getSeoInfo ( 146 );
		return "success";
	}
	public function quiz() {
		$this->getSeoInfo ( 147 );
		return "success";
	}
	public function rickSimpsonOil() {
		$this->getSeoInfo ( 148 );
		return "success";
	}
	public function shoppingCart() {
		$this->seoInfoVo->title = "";
		$this->seoInfoVo->keywords = "";
		$this->seoInfoVo->description = "";
		return "success";
	}
	public function howToUseCbdOil() {
		$this->seoInfoVo->title = "Which CBD product to choose? | Endoca.com";
		$this->seoInfoVo->keywords = "";
		$this->seoInfoVo->description = "";
		return "success";
	}
	public function seoNewContent() {
		$this->getSeoInfo ( 149 );
		return "success";
	}
	public function beginnersGuideToCbd() {
		$this->getSeoInfo ( 150 );
		return "success";
	}
	public function ourTeam() {
		$this->getSeoInfo ( 152 );
		return "success";
	}
	public function error404() {
		$this->getSeoInfo ( 156 );
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