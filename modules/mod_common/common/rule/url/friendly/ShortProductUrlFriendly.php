<?php

namespace common\rule\url\friendly;

use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\product\ProductHomeService;
use core\interfaces\IRule;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class ShortProductUrlFriendly implements IRule {
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
		$productInfo = $this->getProduct ();
		$this->seoUrl = $productInfo->seoUrl;
		$this->name = $productInfo->name;
	}
	public function execute() {
		try {
			if (AppUtil::isEmptyString ( $this->seoUrl )) {
				$this->seoUrl = AppUtil::cleanName ( $this->name );
			}
			$link = $this->langCode . "/";
			$link .= "p" . $this->id;
			$link .= "-" . $this->seoUrl;
			AppUtil::appendQuery ( $link, $this->query );
			return ActionUtil::getFullPathAlias ( $link );
		} catch ( \Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage (), $e );
			return null;
		}
	}
	private function getProduct() {
		$productService = new ProductHomeService ();
		$filter = new ProductHomeExtendVo ();
		$filter->id = $this->id;
		$filter->languageCode = $this->langCode;
		$productVo = $productService->getProductHomeById ( $filter );
		return $productVo;
	}
}