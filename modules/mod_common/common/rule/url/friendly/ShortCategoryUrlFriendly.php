<?php

namespace common\rule\url\friendly;

use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\services\product\ProductHomeService;
use common\services\product\ProductService;
use core\interfaces\IRule;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class ShortCategoryUrlFriendly implements IRule {
	private $langCode;
	private $id;
	private $seoUrl;
	private $name;
	private $query;
	public function __construct($id, $query = "") {
		$langCode = SessionUtil::get ( "language.default.code" );
		$langCode = AppUtil::isEmptyString ( $langCode ) ? "en" : $langCode;
		$this->langCode = $langCode;
		$this->id = $id;
		$this->query = $query;
		$categoryInfo = $this->getCategory ();
		$this->seoUrl = $categoryInfo->seoUrl;
		$this->name = $categoryInfo->name;
	}
	public function execute() {
		try {
			if (AppUtil::isEmptyString ( $this->seoUrl )) {
				$this->seoUrl = AppUtil::cleanName ( $this->name );
			}
			$link = $this->langCode . "/";
			$link .= "c" . $this->id;
			$link .= "-" . $this->seoUrl;
			AppUtil::appendQuery ( $link, $this->query );
			return ActionUtil::getFullPathAlias ( $link );
		} catch ( \Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage (), $e );
			return null;
		}
	}
	private function getCategory() {
		$productService = new ProductHomeService ();
		$categoryExtendVo = new CategoryHomeExtendVo ();
		$categoryExtendVo->id = $this->id;
		$categoryExtendVo->languageCode = $this->langCode;
		$categoryVo = $productService->getCategoryHomeById ( $categoryExtendVo );
		return $categoryVo;
	}
}