<?php

namespace common\helper;


use filemanager\utils\FileManagerHelper;
class DatoImageHelper {
	public static function getImageInfoById($id) {
		return FileManagerHelper::getImageInfoById($id);
	}
	public static function getUrl($imageMo) {
		return FileManagerHelper::getUrl($imageMo);
	}
	public static function getSmallImageUrl($imageMo) {
		return FileManagerHelper::getSmallImageUrl($imageMo);
	}
	public static function getMediumImageUrl($imageMo) {
		return FileManagerHelper::getMediumImageUrl($imageMo);
	}
	public static function getLargeImageUrl($imageMo) {
		return FileManagerHelper::getLargeImageUrl($imageMo);
	}
	public static function getIcon($file) {
		return FileManagerHelper::getIcon($file);
	}
}

