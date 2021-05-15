<?php

namespace common\rule\url\friendly;

use common\persistence\base\vo\LanguageVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\BlogHomeExtendVo;
use common\rule\url\BaseRedirectUrl;
use common\rule\url\UrlBuilder;
use common\rule\url\UrlParser;
use common\services\blog\BlogHomeService;
use common\services\language\LanguageService;
use common\services\seo\SeoInfoLangService;
use core\interfaces\IUrlFriendly;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class DeCategoryBlogFriendlyUrl extends BaseRedirectUrl implements IUrlFriendly{
	private $categoryBlogId;
	private $langCode;
	private $seoUrl;
	private $seoInfoLangService;
	private $languageService;

	public function __construct($uri){
		parent::__construct($uri);
		$this->seoInfoLangService = new SeoInfoLangService ();
		$this->languageService = new LanguageService ();
	}

	public function getUrl(){
		$result = $this->parseUri();
		if (!$result) {
			return null;
		}
		if (!AppUtil::isEmptyString($this->categoryBlogId)) {
			SessionUtil::set("language.default.code", $this->langCode);
			return $this->getCategoryLink();
		}
		return null;
	}

	public function rebuild(){
		$result = $this->parseUri();
		$urlParser = new UrlParser ($this->uri);
		$seoInfoLang = $this->getSeoInfoLang();
		if ($result && !is_null($seoInfoLang)) {
			$categoryBlogVo = $this->getCategory();
			$categoryBlogName = is_null($categoryBlogVo) ? "" : $categoryBlogVo->name;
			if (AppUtil::isEmptyString($seoInfoLang->url)) {
				$seoUrl = AppUtil::cleanName($categoryBlogName);
			} else {
				$seoUrl = $seoInfoLang->url;
			}
			$path = "cb" . $this->categoryBlogId . "-" . $seoUrl;
			$urlBuilder = new UrlBuilder ();
			$urlBuilder->protocol($urlParser->getProtocol())
				->host($urlParser->getHost())
				->context($urlParser->getContext())
				->lang($urlParser->getLangCode())
				->path($path)
				->query($urlParser->getQueryString());
			return $urlBuilder->getUrl();
		}
		return $this->uri;
	}

	private function parseUri(){
		$urlParser = new UrlParser ($this->uri);
		$this->langCode = $urlParser->getLangCode();
		$parts = explode("-", $urlParser->getPath());
		$count = count($parts);
		if ($count < 2) {
			return false;
		}
		// Check if this url is friendly for the categoryBlog.
		$firstChar = substr($parts [0], 0, 2);
		if ("cb" !== $firstChar) {
			return false;
		}
		// Get categoryBlog id.
		$this->categoryBlogId = substr($parts [0], 2);

		// Get url.
		array_shift($parts);
		$this->seoUrl = implode("-", $parts);
		return true;
	}

	private function getLanguageByCode(){
		$filter = new LanguageVo ();
		$filter->code = $this->langCode;
		$languageVo = $this->languageService->getLanguageByCode($filter);
		return $languageVo;
	}

	private function getSeoInfoLang(){
		$filter = new SeoInfoLangVo ();
		$filter->itemId = $this->categoryBlogId;
		$filter->languageCode = $this->langCode;
		$filter->url = $this->seoUrl;
		$seoInfoLangVos = $this->seoInfoLangService->getSeoInfoLangByCategoryBlog($filter);
		if (empty ($seoInfoLangVos)) {
			return null;
		}
		return $seoInfoLangVos [0];
	}

	private function getCategoryLink(){
		$categoryBlogLink = "home/blog/list?id=" . $this->categoryBlogId;
		return $categoryBlogLink;
	}

	private function getCategory(){
		$productService = new BlogHomeService();
		$categoryBlogExtendVo = new BlogHomeExtendVo();
		$categoryBlogExtendVo->id = $this->categoryBlogId;
		$categoryBlogExtendVo->languageCode = $this->langCode;
		$categoryBlogVo = $productService->getCategoryHomeById($categoryBlogExtendVo);
		return $categoryBlogVo;
	}
}