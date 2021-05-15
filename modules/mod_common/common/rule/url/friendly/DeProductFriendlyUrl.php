<?php

namespace common\rule\url\friendly;

use common\persistence\base\vo\LanguageVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\rule\url\BaseRedirectUrl;
use common\rule\url\UrlBuilder;
use common\rule\url\UrlParser;
use common\services\language\LanguageService;
use common\services\seo\SeoInfoLangService;
use core\interfaces\IUrlFriendly;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use common\services\product\ProductHomeService;
use common\persistence\extend\vo\ProductHomeExtendVo;

class DeProductFriendlyUrl extends BaseRedirectUrl implements IUrlFriendly {
	private $productId;
	private $langCode;
	private $seoUrl;
	private $seoInfoLangService;
	private $languageService;
	public function __construct($uri) {
		parent::__construct ( $uri );
		$this->seoInfoLangService = new SeoInfoLangService ();
		$this->languageService = new LanguageService ();
	}
	public function getUrl() {
		$result = $this->parseUri ();
		if (! $result) {
			return null;
		}
		if (! is_null ( $this->getSeoInfoLang () )) {
			SessionUtil::set ( "language.default.code", $this->langCode );
			return $this->getCategoryLink ();
		}
		return null;
	}
	public function rebuild() {
		$result = $this->parseUri ();
		$urlParser = new UrlParser ( $this->uri );
		$seoInfoLang = $this->getSeoInfoLang ();
		if ($result && ! is_null ( $seoInfoLang )) {
			$productVo = $this->getProduct ();
			$productName = is_null ( $productVo ) ? "" : $productVo->name;
			if (AppUtil::isEmptyString ( $seoInfoLang->url )) {
				$seoUrl = AppUtil::cleanName ( $productName );
			} else {
				$seoUrl = $seoInfoLang->url;
			}
			$path = "p" . $this->productId . "-" . $seoUrl;
			$urlBuilder = new UrlBuilder ();
			$urlBuilder->protocol ( $urlParser->getProtocol () )
				->host ( $urlParser->getHost () )
				->context ( $urlParser->getContext () )
				->lang ( $urlParser->getLangCode () )
				->path ( $path )
				->query ( $urlParser->getQueryString () );
			return $urlBuilder->getUrl ();
		}
		return $this->uri;
	}
	private function parseUri() {
		$urlParser = new UrlParser ( $this->uri );
		$this->langCode = $urlParser->getLangCode ();
		$parts = explode ( "-", $urlParser->getPath () );
		$count = count ( $parts );
		if ($count < 2) {
			return false;
		}
		// Check if this url is friendly for the category.
		$firstChar = substr ( $parts [0], 0, 1 );
		if ("p" !== $firstChar) {
			return false;
		}
		// Get product id.
		$this->productId = substr ( $parts [0], 1 );
		// Get url.
		array_shift ( $parts );
		$this->seoUrl = implode ( "-", $parts );
		return true;
	}
	private function getLanguageByCode() {
		$filter = new LanguageVo ();
		$filter->code = $this->langCode;
		$languageVo = $this->languageService->getLanguageByCode ( $filter );
		return $languageVo;
	}
	private function getSeoInfoLang() {
		$filter = new SeoInfoLangVo ();
		$filter->itemId = $this->productId;
		$filter->languageCode = $this->langCode;
		$filter->url = $this->seoUrl;
		$seoInfoLangVos = $this->seoInfoLangService->getSeoInfoLangByProduct ( $filter );
		if (empty ( $seoInfoLangVos )) {
			return null;
		}
		return $seoInfoLangVos [0];
	}
	private function getCategoryLink() {
		$categoryLink = "product/detail?id=" . $this->productId;
		return $categoryLink;
	}
	private function getProduct() {
		$productService = new ProductHomeService();
		$filter = new ProductHomeExtendVo();
		$filter->id = $this->productId;
		$filter->languageCode = $this->langCode;
		$productVo = $productService->getProductHomeById($filter);
		return $productVo;
	}
}