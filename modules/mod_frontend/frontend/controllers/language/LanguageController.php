<?php

namespace frontend\controllers\language;

use common\persistence\base\vo\LanguageVo;
use common\services\language\LanguageService;
use common\rule\url\UrlParser;
use core\config\ApplicationConfig;
use core\Controller;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use common\rule\url\UrlBuilder;

class LanguageController extends Controller {
	public $url;
	public $langCode;
	public function change() {
		$urlParser = new UrlParser ( $this->url );
		$languageService = new LanguageService ();
		// Get language list.
		$filter = new LanguageVo ();
		$filter->code = $this->langCode;
		$languages = $languageService->getLanguageByCode ( $filter );
		if (empty ( $languages )) {
			$this->langCode = ApplicationConfig::get ( "language.default.code" );
			$this->langCode = AppUtil::isEmptyString ( $this->langCode ) ? "en" : $this->langCode;
		}
		SessionUtil::set ( "language.default.code", $this->langCode );
		$urlBuilder = new UrlBuilder ();
		$urlBuilder
			->protocol ( $urlParser->getProtocol () )
			->host( $urlParser->getHost() )
			->context( $urlParser->getContext() )
			->path( $urlParser->getPath () )
			->query( $urlParser->getQueryString ());
		$oldUrl = $urlBuilder->getUrl();
		// Rebuild url.
		foreach ( ApplicationConfig::get ( "url.friendly.list" ) as $urlFriendly ) {
			$urlBuilder->lang( $this->langCode );
			$newUrl = $urlBuilder->getUrl();
			$urlFriendlyObject = new $urlFriendly ( $newUrl );
			$url = $urlFriendlyObject->getUrl ();
			if (! is_null ( $url )) {
				$newUrl = $urlFriendlyObject->rebuild ();
				$this->addExtraData ( "url", $newUrl );
				return null;
			}
		}
		$this->addExtraData ( "url", $oldUrl );
		return null;
	}
}