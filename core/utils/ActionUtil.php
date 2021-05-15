<?php

namespace core\utils;

class ActionUtil {
	private static function getPathAlias($alias, $obj = null) {
		if (! isset ( $obj )) {
			return $alias;
		} else {
			$result = $obj->execute ();
			if (! is_null ( $result )) {
				return $result;
			}
			return $alias;
		}
	}
	public static function getFullPathAlias($alias, $obj = null) {
		if (! isset ( $obj )) {
			return AppUtil::web_url ( str_replace ( "\\", "/", $alias ) );
		} else {
			$result = $obj->execute ();
			if (! is_null ( $result )) {
				return $result;
			}
			return AppUtil::web_url ( str_replace ( "\\", "/", $alias ) );
		}
	}
}