<?php

namespace filemanager\utils;

use core\utils\ActionUtil;
use core\config\ApplicationConfig;
use core\utils\FileUploadUtil;
use common\utils\ImageUtil;
use filemanager\services\filemanager\ImageService;
use filemanager\persistence\base\vo\ImageVo;
use core\utils\AppUtil;

class FileManagerHelper {
	public static function getProfileCfg($pid = "default") {
		$pid = AppUtil::isEmptyString($pid)?"default":$pid;
		$result = array ();
		if (isset ( ApplicationConfig::get ( "file.manager.config" )[$pid] )) {
			$result = ApplicationConfig::get ( "file.manager.config" )[$pid];
		} else {
			$result = ApplicationConfig::get ( "file.manager.config" )[""];
		}
		$result ['root.dir'] = ROOT.DS;
		$result ['root.web'] = ActionUtil::getFullPathAlias ( "" );
		return $result;
	}
	public static function isPidExisted($pid = "default") {
		$pid = AppUtil::isEmptyString($pid)?"default":$pid;
		$result = array ();
		if (isset ( ApplicationConfig::get ( "file.manager.config" )[$pid] )) {
			$result = ApplicationConfig::get ( "file.manager.config" )[$pid];
		} 
		return !empty($result);
	}
	public static function getRealpath($cfgs, $sizeType = "") {
		$result = "";
		switch ($sizeType) {
			case "root" :
				$result = $cfgs ['root.dir'];
				break;
			case "" :
				$result = $cfgs ['root.dir'] . $cfgs ['dir'];
				break;
			case "small" :
				$result = $cfgs ['root.dir'] . $cfgs ['dir'] . $cfgs ['image'] ['small'] ['dir'];
				break;
			case "medium" :
				$result = $cfgs ['root.dir'] . $cfgs ['dir'] . $cfgs ['image'] ['medium'] ['dir'];
				break;
			case "large" :
				$result = $cfgs ['root.dir'] . $cfgs ['dir'] . $cfgs ['image'] ['large'] ['dir'];
				break;
			default :
				break;
		}
		return $result;
	}
	
	public static function getRelativepath($cfgs, $sizeType = "") {
		$result = "";
		switch ($sizeType) {
			case "" :
				$result = $cfgs ['dir'];
				break;
			case "small" :
				$result = $cfgs ['dir'] . $cfgs ['image'] ['small'] ['dir'];
				break;
			case "medium" :
				$result = $cfgs ['dir'] . $cfgs ['image'] ['medium'] ['dir'];
				break;
			case "large" :
				$result = $cfgs ['dir'] . $cfgs ['image'] ['large'] ['dir'];
				break;
			default :
				break;
		}
		return $result;
	}
	
	public static function getExistedUrlByPID($pid, $fileName, $sizeType = "") {
		$cfgs = self::getProfileCfg($pid); 
		$dir = self::getRealpath($cfgs,$sizeType);
		if (file_exists(str_replace("\\",DS,$dir.$fileName))){
			return self::getUrl($cfgs, $fileName,$sizeType);			
		}else{
			return null;
		}
		return $result;
	}
	
	public static function getWidth($cfgs, $sizeType = "", $default = 0) {
		$result = "";
		switch ($sizeType) {
			case "" :
				$result = 0;
				break;
			case "small" :
				$result = $cfgs ['image'] ['small'] ['width'];
				break;
			case "medium" :
				$result = $cfgs ['image'] ['medium'] ['width'];
				break;
			case "large" :
				$result = $cfgs ['image'] ['large'] ['width'];
				break;
			default :
				break;
		}
		if (empty ( $result )) {
			$default = 0;
		}
		return $result;
	}
	public static function getHeight($cfgs, $sizeType = "", $default = 0) {
		$result = "";
		switch ($sizeType) {
			case "" :
				$result = 0;
				break;
			case "small" :
				$result = $cfgs ['image'] ['small'] ['height'];
				break;
			case "medium" :
				$result = $cfgs ['image'] ['medium'] ['height'];
				break;
			case "large" :
				$result = $cfgs ['image'] ['large'] ['height'];
				break;
			default :
				break;
		}
		if (empty ( $result )) {
			$default = 0;
		}
		return $result;
	}
	
	public static function getImageInfoById($id) {
		$imageService = new ImageService();
		$imageVo = new ImageVo();
		$imageVo->id = $id;
		return $imageService->selectByKey ( $imageVo );
	}
	
	public static function fileExisted($imageMo) {
		if (! isset ( $imageMo )) {
			return false;
		}
		if (file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativePath . $imageMo->fileName ))) {
			return true;
		} else {
			return false;
		}
	}

	public static function getUrl($imageMo) {
		if (! isset ( $imageMo )) {
			return ImageUtil::getNoImage ();
		}
		if (file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativePath . $imageMo->fileName ))) {
			if (ApplicationConfig::get("file.manager.url.friendly") === true){
				return ActionUtil::getFullPathAlias ( "images?id=".$imageMo->id."");
			}else{
				return ActionUtil::getFullPathAlias ( $imageMo->relativePath . urlencode($imageMo->fileName) );
			}
		} else {
			return ImageUtil::getNoImage ();
		}
	}
	
	public static function getSmallImageUrl($imageMo) {
		if (! isset ( $imageMo )) {
			return ImageUtil::getNoImage ();
		}
	
		if (! file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativePath . $imageMo->fileName ))) {
			return ImageUtil::getNoImage ();
		}
	
		if (! FileUploadUtil::isImage ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName )) {
			return self::getIcon ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName );
		}
	
		if (file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativeSmallPath . $imageMo->fileName ))) {
			if (ApplicationConfig::get("file.manager.url.friendly") === true){
				return ActionUtil::getFullPathAlias ( "images?id=".$imageMo->id."&imageSize=small");
			}else{
				return ActionUtil::getFullPathAlias ( $imageMo->relativeSmallPath . urlencode ($imageMo->fileName) );
			}
		} else {
			return ImageUtil::getNoImage ();
		}
	}
	public static function getMediumImageUrl($imageMo) {
		if (! isset ( $imageMo )) {
			return ImageUtil::getNoImage ();
		}
	
		if (! file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativePath . $imageMo->fileName ))) {
			return ImageUtil::getNoImage ();
		}
	
		if (! FileUploadUtil::isImage ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName )) {
			return self::getIcon ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName );
		}
	
		if (file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativeMediumPath . $imageMo->fileName ))) {
			if (ApplicationConfig::get("file.manager.url.friendly") === true){
				return ActionUtil::getFullPathAlias ( "images?id=".$imageMo->id."&imageSize=medium");
			}else{
				return ActionUtil::getFullPathAlias ( $imageMo->relativeMediumPath . urlencode($imageMo->fileName) );
			}
		} else {
			return ImageUtil::getNoImage ();
		}
	}
	public static function getLargeImageUrl($imageMo) {
		if (! isset ( $imageMo )) {
			return ImageUtil::getNoImage ();
		}
	
		if (! file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativePath . $imageMo->fileName ))) {
			return ImageUtil::getNoImage ();
		}
	
		if (! FileUploadUtil::isImage ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName )) {
			return self::getIcon ( ROOT . DS . $imageMo->relativePath . $imageMo->fileName );
		}
	
		if (file_exists ( str_replace("\\",DS,ROOT . DS . $imageMo->relativeLargePath . $imageMo->fileName ))) {
			if (ApplicationConfig::get("file.manager.url.friendly") === true){
				return ActionUtil::getFullPathAlias ( "images?id=".$imageMo->id."&imageSize=large");
			}else{
				return ActionUtil::getFullPathAlias ( $imageMo->relativeLargePath . urlencode($imageMo->fileName) );
			}
		} else {
			return ImageUtil::getNoImage ();
		}
	}
	public static function getIcon($file) {
		$fileTmp = str_replace("\\",DS,$file);
		//@TODO: continue modify it
		$pdfImg = 'http://cdn1.iconfinder.com/data/icons/CrystalClear/128x128/mimetypes/pdf.png';
		$docImg = 'http://cdn2.iconfinder.com/data/icons/sleekxp/Microsoft%20Office%202007%20Word.png';
		$pptImg = 'http://cdn2.iconfinder.com/data/icons/sleekxp/Microsoft%20Office%202007%20PowerPoint.png';
		$txtImg = 'http://cdn1.iconfinder.com/data/icons/CrystalClear/128x128/mimetypes/txt2.png';
		$xlsImg = 'http://cdn2.iconfinder.com/data/icons/sleekxp/Microsoft%20Office%202007%20Excel.png';
		$audioImg = 'http://cdn2.iconfinder.com/data/icons/oxygen/128x128/mimetypes/audio-x-pn-realaudio-plugin.png';
		$videoImg = 'http://cdn4.iconfinder.com/data/icons/Pretty_office_icon_part_2/128/video-file.png';
		$htmlImg = 'http://cdn1.iconfinder.com/data/icons/nuove/128x128/mimetypes/html.png';
		$fileImg = 'http://cdn3.iconfinder.com/data/icons/musthave/128/New.png';
	
		switch (pathinfo ( $fileTmp)['extension']) {
			case 'pdf' :
				$img = $pdfImg;
				break;
			case 'doc' :
				$img = $docImg;
				break;
			case 'docx' :
				$img = $docImg;
				break;
			case 'txt' :
				$img = $txtImg;
				break;
			case 'xls' :
				$img = $xlsImg;
				break;
			case 'xlsx' :
				$img = $xlsImg;
				break;
			case 'xlsm' :
				$img = $xlsImg;
				break;
			case 'ppt' :
				$img = $pptImg;
				break;
			case 'pptx' :
				$img = $pptImg;
				break;
			case 'mp3' :
				$img = $audioImg;
				break;
			case 'wmv' :
				$img = $videoImg;
				break;
			case 'mp4' :
				$img = $videoImg;
				break;
			case 'mpeg' :
				$img = $videoImg;
				break;
			case 'html' :
				$img = $htmlImg;
				break;
			default :
				$img = $fileImg;
				break;
		}
		return $img;
	}
}