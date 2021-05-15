<?php

namespace core\utils;

class EncryptUtil {
	public static $_keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	public static $_secret = 'AqNYvCaRfjFN4eSa';
	public static function encryptString($string, $secret = null) {
		$output = false;
		
		$encrypt_method = "AES-256-CBC";
		if (empty ( $secret ))
			$secret = self::$_secret;
		$passKey = $secret;
		$key = hash ( 'sha256', $passKey );
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr ( hash ( 'sha256', $passKey ), 0, 16 );
		$output = openssl_encrypt ( $string, $encrypt_method, $key, 0, $iv );
		$output = base64_encode ( $output );
		
		return $output;
	}
	public static function decryptString($string, $secret = null) {
		$output = false;
		
		$encrypt_method = "AES-256-CBC";
		if (empty ( $secret ))
			$secret = self::$_secret;
		$passKey = $secret;
		$key = hash ( 'sha256', $passKey );
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr ( hash ( 'sha256', $passKey ), 0, 16 );
		$output = openssl_decrypt ( base64_decode ( $string ), $encrypt_method, $key, 0, $iv );
		
		return $output;
	}
	public static function proxyEncode($str) {
		$enStr = null;
		$t = "";
		$n = $r = $i = $s = $o = $u = $a = null;
		$f = 0;
		$e = self::utf8ProxyEncode ( $str );
		while ( $f < strlen ( $e ) ) {
			$n = ord ( substr ( $e, $f ++, 1 ) );
			$r = ord ( substr ( $e, $f ++, 1 ) );
			$i = ord ( substr ( $e, $f ++, 1 ) );
			$s = $n >> 2;
			$o = ($n & 3) << 4 | $r >> 4;
			$u = ($r & 15) << 2 | $i >> 6;
			$a = $i & 63;
			if ($r == null) {
				$u;
			} else if ($i == null) {
				$a = 64;
			}
			$t = $t . substr ( self::$_keyStr, $s, 1 ) . substr ( self::$_keyStr, $o, 1 ) . substr ( self::$_keyStr, $u, 1 ) . substr ( self::$_keyStr, $a, 1 );
		}
		$enStr = $t;
		return $enStr;
	}
	public static function proxyDecode($enStr) {
		$str = null;
		$t = "";
		$n = $r = $i = null;
		$s = $o = $u = $a = null;
		$f = 0;
		$e = preg_replace ( '/[^A-Za-z0-9\+\/\=]/i', "", $enStr );
		while ( $f < strlen ( $e ) ) {
			$s = strpos ( self::$_keyStr, substr ( $e, $f ++, 1 ) );
			$o = strpos ( self::$_keyStr, substr ( $e, $f ++, 1 ) );
			$u = strpos ( self::$_keyStr, substr ( $e, $f ++, 1 ) );
			$a = strpos ( self::$_keyStr, substr ( $e, $f ++, 1 ) );
			$n = $s << 2 | $o >> 4;
			$r = ($o & 15) << 4 | $u >> 2;
			$i = ($u & 3) << 6 | $a;
			$t = $t . chr ( $n );
			if ($u != 64) {
				$t = $t . chr ( $r );
			}
			if ($a != 64) {
				$t = $t . chr ( $i );
			}
		}
		
		$t = self::utf8ProxyDecode ( $t );
		$str = $t;
		return $str;
	}
	private static function utf8ProxyEncode($str) {
		$enStr = null;
		$e = preg_replace ( '/\r\n/i', "\n", $str );
		$t = "";
		for($n = 0; $n < strlen ( $e ); $n ++) {
			$r = ord ( substr ( $e, $n, 1 ) );
			if ($r < 128) {
				$t .= chr ( $r );
			} else if ($r > 127 && $r < 2048) {
				$t .= chr ( $r >> 6 | 192 );
				$t .= chr ( $r & 63 | 128 );
			} else {
				$t .= chr ( $r >> 12 | 224 );
				$t .= chr ( $r >> 6 & 63 | 128 );
				$t .= chr ( $r & 63 | 128 );
			}
		}
		$enStr = $t;
		return $enStr;
	}
	private static function utf8ProxyDecode($enStr) {
		$str = null;
		$e = $enStr;
		$t = "";
		$n = 0;
		$r = $c1 = $c2 = 0;
		while ( $n < strlen ( $e ) ) {
			$r = ord ( substr ( $e, $n, 1 ) );
			if ($r < 128) {
				$t .= chr ( $r );
				$n ++;
			} else if ($r > 191 && $r < 224) {
				$c2 = ord ( substr ( $e, $n + 1, 1 ) );
				$t .= chr ( ($r & 31) << 6 | $c2 & 63 );
				$n += 2;
			} else {
				$c2 = ord ( substr ( $e, $n + 1, 1 ) );
				$c3 = ord ( substr ( $e, $n + 2, 1 ) );
				$t .= chr ( ($r & 15) << 12 | ($c2 & 63) << 6 | $c3 & 63 );
				$n += 3;
			}
		}
		$str = $t;
		return $str;
	}
}