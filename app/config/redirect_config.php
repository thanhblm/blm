<?php
use core\config\ApplicationConfig;
use common\rule\url\redirect\RedirectUrl;

/*
 * return url fullpath of url (http{s}://xxxx)
 * http://localhost/endoca/google redirect to http://www.google.com
 */

// The endoca: URL redirect.
$redirectUrl = new RedirectUrl ( $_SERVER ['REQUEST_URI'] );
return $redirectUrl->getUrl ();

// URL redirect example.
if ($_SERVER ['REQUEST_URI'] === ApplicationConfig::get ( "web.context" ) . "/google") {
	return "http://www.google.com";
}
return null;