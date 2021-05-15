<?php

namespace common\rule\url\redirect;

use common\persistence\extend\vo\UrlRedirectExtendVo;
use common\services\url_redirect\UrlRedirectService;
use common\rule\url\BaseRedirectUrl;

class RedirectUrl extends BaseRedirectUrl {
	private $urlRedirectService;
	public function __construct($uri) {
		parent::__construct ( $uri );
		$this->urlRedirectService = new UrlRedirectService ();
	}
	public function getUrl() {
		$filter = new UrlRedirectExtendVo ();
		$filter->oldUrl = $this->removeContext ( $this->uri );
		$redirectUrls = $this->urlRedirectService->getByOldUrl ( $filter );
		if (! empty ( $redirectUrls )) {
			return $this->getFullUri ( $redirectUrls [0]->newUrl );
		}
		return null;
	}
}