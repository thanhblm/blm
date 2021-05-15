<?php


namespace common\helper;


use core\config\ApplicationConfig;
use core\utils\AppUtil;

class CookieHelper{
	public static function setCookie($name, $value, $domain = '', $expire = ''){
		if (empty ($expire))
			$expire = ApplicationConfig::get("cookie.expire");
		$path = ApplicationConfig::get("cookie.path");
		$secure = NetworkHelper::isSSL();
		$httponly = false;
		if (empty ($domain))
			$domain = $_SERVER["HTTP_HOST"];
		// echo 'add time:' . (time () + $expire) . ' $domain:"' . $domain . '"' . ' $name:' . $name . ' $value:' . $value;
		// $logger->trace ( 'add time:' . (time () + $expire) . ' $domain:"' . $domain . '"' . ' $name:' . $name . ' $value:' . $value );
		// setcookie ( $name, $value, time () + $expire, $path, $domain );
		if (empty ($value))
			self::deleteCookie($name, $domain);
		else
			setcookie($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
	}

	public static function deleteCookie($name, $domain = ''){
		$value = null;
		$expire = ApplicationConfig::get("cookie.expire") * -1;
		$path = ApplicationConfig::get("cookie.path");
		$secure = NetworkHelper::isSSL();
		$httponly = false;
		if (empty ($domain))
			$domain = $_SERVER["HTTP_HOST"];
		// $logger->trace ( 'delete time:' . (time () + $expire) . ' $domain:"' . $domain . '"' . ' $name:' . $name . ' $value:' . $value );
		setcookie($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
	}

	public static function getCookie($name){
		return isset ($_COOKIE [$name]) ? $_COOKIE [$name] : null;
	}

	public static function clearAllCookies(){
		if (isset ($_SERVER ['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER ['HTTP_COOKIE']);
			foreach ($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts [0]);
				self::deleteCookie($name);
				setcookie($name, '', time() - 1000);
				setcookie($name, '', time() - 1000, '/');
			}
		}
	}
}