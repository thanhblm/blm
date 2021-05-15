<?php

namespace common\utils;

use core\utils\RouteUtil;

class ImageUtil {
	public static function getNoImage() {
		// get data from system_setting table (later)
		return RouteUtil::getRoute ()->getWebRoot () . '/uploads/no-image.png';
	}
	public static function getImagePath($imagePath, $folder = '') {
		$baseUrl = RouteUtil::getRoute ()->getWebRoot ();
		$imagePath = str_replace ( $baseUrl .'/', '', $imagePath );
		if ($folder != '') {
			$exp = explode ( '/', $imagePath );
			$fileName = $exp [count ( $exp ) - 1];
			$imageThumbnail = str_replace ( $fileName, '', $imagePath ) . $folder .'/'. $fileName;
			if (file_exists ( $imageThumbnail )) {
				return $baseUrl .'/'. $imageThumbnail;
			}
			else{
				\DatoLogUtil::error("Not found image $imagePath with folder = $folder");
				return $baseUrl .'/'. $imagePath;
			}
		}
		if (file_exists ( $imagePath )) {
			return $baseUrl .'/'. $imagePath;
		} else {
			\DatoLogUtil::error("Not found image $imagePath");
			return $baseUrl .'/'. $imagePath;
		}
	}
}