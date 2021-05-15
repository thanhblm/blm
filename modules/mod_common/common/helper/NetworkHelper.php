<?php

namespace common\helper;

class NetworkHelper {
	public static function getClientIp() {
		foreach ( array (
				'HTTP_CLIENT_IP',
				'HTTP_X_FORWARDED_FOR',
				'HTTP_X_FORWARDED',
				'HTTP_X_CLUSTER_CLIENT_IP',
				'HTTP_FORWARDED_FOR',
				'HTTP_FORWARDED',
				'REMOTE_ADDR' 
		) as $key ) {
			if (array_key_exists ( $key, $_SERVER ) === true) {
				$arr = explode ( ',', $_SERVER [$key] );
				foreach ( $arr as $ip ) {
					$ip = trim ( $ip ); // just to be safe
					
					if (filter_var ( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false) {
						if (! empty ( $ip ))
							return $ip;
					}
				}
			}
		}
		return $ip;
	}
	public static function getCurrentURL() {
		return (isset ( $_SERVER ['HTTPS'] ) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	public static function isSSL() {
		if (isset ( $_SERVER ['HTTPS'] )) {
			if ('on' == strtolower ( $_SERVER ['HTTPS'] ))
				return true;
			return true;
		} elseif (isset ( $_SERVER ['SERVER_PORT'] ) && ('443' == $_SERVER ['SERVER_PORT'])) {
			return true;
		}
		return false;
	}
	public static function isIpWhiteList() {
		$isWhiteList = false;
		$whitelist = array (
				'127.0.0.1',
				'::1' 
		);
		
		if (in_array ( $_SERVER ['REMOTE_ADDR'], $whitelist )) {
			$isWhiteList = true;
		}
		return $isWhiteList;
	}
	public static function isLocalhost() {
		$isLocal = false;
		$whitelist = array (
				'127.0.0.1',
				'::1' 
		);
		
		if (in_array ( $_SERVER ['REMOTE_ADDR'], $whitelist )) {
			$isLocal = true;
		}
		return $isLocal;
	}
}