<?php

namespace common\rule\url\friendly;

use common\rule\url\BaseRedirectUrl;
use common\rule\url\UrlParser;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\interfaces\IUrlFriendly;

class DeAliasFriendlyUrl extends BaseRedirectUrl implements IUrlFriendly {
	public function __construct($uri) {
		parent::__construct ( $uri );
	}
	public function getUrl() {
		if (is_null ( ApplicationConfig::get ( "action.alias.list" ) )) {
			return null;
		}
		// Get uri info.
		$urlParser = new UrlParser ( $this->uri );
		$alias = $urlParser->getPath ();
		if (AppUtil::isEmptyString ( $alias )) {
			$alias = "/";
		}
		// Get configuration for alias actions.
		$aliasActions = ApplicationConfig::get ( "action.alias.list" );
		if (isset ( $aliasActions [$alias] )) {
			$newUri = $aliasActions [$alias];
			if (! AppUtil::isEmptyString ( $urlParser->getQueryString () )) {
				$newUri .= "?" . $urlParser->getQueryString ();
			}
			SessionUtil::set ( "language.default.code", $urlParser->getLangCode () );
			return $newUri;
		}
		return null;
	}
	public function rebuild() {
		return $this->uri;
	}
}