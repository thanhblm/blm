<?php

namespace core\utils;

class TextFileUtil {
	public static function readFile($fileName) {
		$file = fopen ( $fileName, "r" );
		$result = "";
		while ( ! feof ( $file ) ) {
			$result .= fgets ( $file );
		}
		fclose ( $file );
		return $result;
	}
	public static function writeFile($fileName, $content) {
		if (is_null ( $content )) {
			$content = " ";
		}
		$file = fopen ( $fileName, "w" );
		fwrite ( $file, $content );
		fclose ( $file );
	}
}