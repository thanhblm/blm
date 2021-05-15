<?php
use core\config\ApplicationConfig;
use core\utils\AppUtil;

ApplicationConfig::set ( "url.friendly.list", array (
		"common\\rule\url\\friendly\DeAliasFriendlyUrl",
		"common\\rule\url\\friendly\DeCategoryFriendlyUrl",
		"common\\rule\url\\friendly\DeProductFriendlyUrl",
		"common\\rule\url\\friendly\DeCategoryBlogFriendlyUrl",
		"common\\rule\url\\friendly\DeBlogFriendlyUrl"
) );

$url = null;
$fullUrl = AppUtil::getFullUrl ();
foreach ( ApplicationConfig::get ( "url.friendly.list" ) as $urlFriendly ) {
	$urlFriendlyObject = new $urlFriendly ( $fullUrl );
	$url = $urlFriendlyObject->getUrl ();
	if (! is_null ( $url )) {
		return $url;
	}
}
return null;

// URL friendly example.
if ($_SERVER ['REQUEST_URI'] === ApplicationConfig::get ( "web.context" ) . "/admin/en/abc") {
	return "admin/language/list";
}
return null;