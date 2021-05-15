<?php

namespace common\rule\url\friendly;

use core\config\ApplicationConfig;
use core\interfaces\IRule;
use core\utils\ActionUtil;
use core\utils\AppUtil;

class BlogUrlFriendly implements IRule {
	private $langCode;
	private $id;
	private $seoUrl;
	private $name;
	private $query;
	public function  __construct($langCode, $id, $seoUrl, $name, $query = "") {
		$this->langCode = $langCode;
		if (AppUtil::isEmptyString ( $this->langCode )) {
			$this->langCode = ApplicationConfig::get ( "language.default.code" );
		}
		$this->id = $id;
		$this->seoUrl = $seoUrl;
		$this->name = $name;
		$this->query = $query;
	}
	public function execute() {
		try {
			if (AppUtil::isEmptyString ( $this->seoUrl )) {
				$this->seoUrl = AppUtil::cleanName ( $this->name );
			}
			$link = $this->langCode . "/";
			$link .= "b" . $this->id;
			$link .= "-" . $this->seoUrl;
			AppUtil::appendQuery ( $link, $this->query );
			return ActionUtil::getFullPathAlias ( $link );
		} catch ( \Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage (), $e );
			return null;
		}
	}
}