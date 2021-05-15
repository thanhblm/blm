<?php
namespace common\utils;

use core\config\ApplicationConfig;
use GeoIp2\WebService\Client;
use IP2Location\Database;

class IpUtils {
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

	public static function getCountryByIP($ip){
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$db = new Database(ROOT . DS . 'core' . DS . 'libs' . DS . 'Ip2Location' . DS . 'databases' . DS . 'IPV6-COUNTRY.BIN', Database::FILE_IO);
		} else {
			$db = new \IP2Location\Database (ROOT . DS . 'core' . DS . 'libs' . DS . 'Ip2Location' . DS . 'databases' . DS . 'IP-COUNTRY.BIN', Database::FILE_IO);
		}
		$result = $db->lookup($ip, Database::ALL);
		return $result['countryCode'];
	}

	public static function getCountryByIPviaAPI($ip){
		$client = new Client(ApplicationConfig::get("maxmind.user"), ApplicationConfig::get("maxmind.password"));
		$record = $client->country($ip);
		return $record->country->isoCode;
	}
}