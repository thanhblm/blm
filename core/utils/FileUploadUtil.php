<?php

namespace core\utils;

class FileUploadUtil {
	public static $IMG_TYPES_EXTENSION = array (
			IMAGETYPE_GIF => ".gif",
			IMAGETYPE_JPEG => ".jpg",
			IMAGETYPE_BMP => ".bmp",
			IMAGETYPE_PNG => ".png" 
	);
	public static $IMAGE_TYPE = array (
			IMAGETYPE_GIF,
			IMAGETYPE_JPEG,
			IMAGETYPE_PNG,
			IMAGETYPE_BMP 
	);
	public static function getErrorDescription($errorCode) {
		$result = "";
		switch ($errorCode) {
			case 0 :
				$result = "There is no error, the file uploaded with success";
				break;
			case 1 :
				$result = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case 2 :
				$result = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case 3 :
				$result = 'The uploaded file was only partially uploaded';
				break;
			case 4 :
				$result = 'No file was uploaded.';
				break;
			case 6 :
				$result = 'Missing a temporary folder. Introduced in PHP 5.0.3';
				break;
			case 7 :
				$result = 'Failed to write file to disk. Introduced in PHP 5.1.0';
				break;
			case 8 :
				$result = 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0';
				break;
			default :
				$result = $errorCode;
				break;
		}
		return $result;
	}
	public static function resizeImage($source, $destination, $width = 20) {
		$dir = pathinfo ( $destination ) ['dirname'];
		if (! file_exists ( $dir )) {
			mkdir ( $dir, 0755, true );
		}
		
		if ($width == 0) {
			$width = 20;
		}
		if (! self::isImage ( $source )) {
			throw new \Exception ( $source . " is not a image" );
		}
		$size = getimagesize ( $source );
		$newWidth = $size [0];
		$newHeight = $size [1];
		$ratio = $size [0] / $size [1];
		
		if ($ratio > 1) {
			$newWidth = $width;
			$newHeight = $width / $ratio;
		} else {
			$newWidth = $width * $ratio;
			$newHeight = $width;
		}
		
		$src = imagecreatefromstring ( file_get_contents ( $source ) );
		$dst = imagecreatetruecolor ( $newWidth, $newHeight );
		imagealphablending ( $dst, false );
		imagesavealpha ( $dst, true );
		imagecopyresampled ( $dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $size [0], $size [1] );
		imagedestroy ( $src );
		self::saveImage ( $source, $dst, $destination );
		imagedestroy ( $dst );
	}
	private static function saveImage($source, $image, $filename) {
		$imageType = getimagesize ( $source ) [2];
		switch ($imageType) {
			case IMAGETYPE_PNG :
				imagepng ( $image, $filename, 6 );
				break;
			case IMAGETYPE_GIF :
				imagegif ( $image, $filename );
				break;
			case IMAGETYPE_JPEG :
				imagejpeg ( $image, $filename, 60 );
				break;
			case IMAGETYPE_BMP :
				copy ( $source, $filename );
				break;
			default :
				return false;
		}
	}
	public static function moveFile($source, $destination) {
		$dir = pathinfo ( $destination ) ['dirname'];
		if (! file_exists ( $dir )) {
			mkdir ( $dir, 0755, true );
		}
		move_uploaded_file ( $source, $destination );
	}
	public static function copyFile($source, $destination) {
		$dir = pathinfo ( $destination ) ['dirname'];
		if (! file_exists ( $dir )) {
			mkdir ( $dir, 0755, true );
		}
		copy ( $source, $destination );
	}
	public static function prepareFileInfo($filename, $tmpFileName) {
		$pathInfo = pathinfo ( $filename );
		// $extension = self::imageExtension ( $tmpFileName );
		$extension = null;
		if (isset ( $extension )) {
			$pathInfo ['extension'] = $extension;
		} else {
			$pathInfo ['extension'] = empty ( $pathInfo ['extension'] ) ? "" : "." . $pathInfo ['extension'];
		}
		return $pathInfo;
	}
	public static function imageExtension($path) {
		$info = getimagesize ( $path );
		if ($info == false) {
			return null;
		}
		$imageType = $info [2];
		if (in_array ( $imageType, self::$IMAGE_TYPE )) {
			return self::$IMG_TYPES_EXTENSION [$imageType];
		}
		return null;
	}
	public static function isImage($path) {
		$pathTmp = str_replace("\\",DS,$path);
		$info = getimagesize ( $pathTmp);
		if ($info == false) {
			return false;
		}
		$imageType = $info [2];
		if (in_array ( $imageType, self::$IMAGE_TYPE )) {
			return true;
		}
		return false;
	}
}