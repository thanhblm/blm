<?php

namespace core\utils;

class PhpFileUtil {
	public static function getInterfaceFileContext2($filePathName) {
		$classes = self::getClassesFromFile ( $filePathName );
		// Ignore generate interface file if the file hasn't got class(es).
		if (empty ( $classes )) {
			return null;
		}
		$result = "";
		$file = fopen ( $filePathName, "r" );
		$line = "";
		$keywords = self::getCheckKeywords ();
		$hasEnumOrClasss = false;
		while ( ! feof ( $file ) ) {
			$line = fgets ( $file );
			$line = trim ( $line );
			if (strpos ( $line, "class" ) !== false || strpos ( $line, "enum" ) !== false) {
				$hasEnumOrClasss = true;
			}
			foreach ( $keywords as $keyword ) {
				if (AppUtil::startsWith ( $line, $keyword ["name"] )) {
					$result .= $keyword ["indent"] . self::removeTail ( $line ) . "\n";
					break;
				}
			}
		}
		fclose ( $file );
		return $hasEnumOrClasss ? $result . "}" : "";
	}
	public static function getInterfaceFileContent($filePathName) {
		$classes = self::getClassesFromFile ( $filePathName );
		// Ignore generate interface file if the file hasn't got class(es).
		if (empty ( $classes )) {
			return null;
		}
		$result .= "<?php\n";
		foreach ( $classes as $class ) {
			$result .= "namespace " . $class ["namespace"] . ";\n";
			$result .= "class " . $class ["name"] . " {\n";
			$methods = self::getPublicFunctions ( $class ["fullname"] );
			foreach ( $methods as $method ) {
				$modifiers = $method->getModifiers ();
				$modifierNames = \Reflection::getModifierNames ( $modifiers );
				$result .= "\t ";
				foreach ( $modifierNames as $modifierName ) {
					$result .= $modifierName . " ";
				}
				$result .= "function " . $method->name . " (";
				$parameters = $method->getParameters ();
				$paramCount = 0;
				$size = count ( $parameters );
				foreach ( $parameters as $parameter ) {
					$result .= "$" . $parameter->name . (($paramCount === $size - 1) ? "" : ", ");
					$paramCount ++;
				}
				$result .= ");\n";
			}
			$result .= "}\n";
		}
		return $result;
	}
	public static function getNamespaceFromClass($className) {
		$size = strlen ( $className );
		$pos = strpos ( strrev ( $className ), "\\" );
		$namespace = substr ( $className, 0, $size - $pos - 1 );
		return $namespace;
	}
	public static function getClassesFromFile($filePathName) {
		// Get namespace.
		$namespace = self::getClassNamespaceFromFile ( $filePathName );
		// Get classes.
		$classes = self::getClassNameFromFile ( $filePathName );
		$result = array ();
		foreach ( $classes as $class ) {
			$classInfo = array ();
			$classInfo ["namespace"] = $namespace;
			$classInfo ["name"] = $class;
			$classInfo ["fullname"] = $namespace . "\\" . $class;
			$result [] = $classInfo;
		}
		return $result;
	}
	public static function getPublicFunctions($className) {
		$reflectClass = new \ReflectionClass ( $className );
		$methods = $reflectClass->getMethods ( \ReflectionMethod::IS_STATIC | \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_PRIVATE | \ReflectionMethod::IS_ABSTRACT | \ReflectionMethod::IS_FINAL );
		return $methods;
	}
	private static function getClassNameFromFile($filePathName) {
		$php_code = file_get_contents ( $filePathName );
		$classes = array ();
		$tokens = token_get_all ( $php_code );
		$count = count ( $tokens );
		for($i = 2; $i < $count; $i ++) {
			if ($tokens [$i - 2] [0] == T_CLASS && $tokens [$i - 1] [0] == T_WHITESPACE && $tokens [$i] [0] == T_STRING) {
				$class_name = $tokens [$i] [1];
				$classes [] = $class_name;
			}
		}
		return $classes;
	}
	private static function getClassNamespaceFromFile($filePathName) {
		$src = file_get_contents ( $filePathName );
		$tokens = token_get_all ( $src );
		$count = count ( $tokens );
		$i = 0;
		$namespace = '';
		$namespace_ok = false;
		while ( $i < $count ) {
			$token = $tokens [$i];
			if (is_array ( $token ) && $token [0] === T_NAMESPACE) {
				// Found namespace declaration
				while ( ++ $i < $count ) {
					if ($tokens [$i] === ';') {
						$namespace_ok = true;
						$namespace = trim ( $namespace );
						break;
					}
					$namespace .= is_array ( $tokens [$i] ) ? $tokens [$i] [1] : $tokens [$i];
				}
				break;
			}
			$i ++;
		}
		if (! $namespace_ok) {
			return null;
		} else {
			return $namespace;
		}
	}
	private static function removeTail($string) {
		if (AppUtil::endsWith ( $string, ") {" )) {
			return substr ( $string, 0, strlen ( $string ) - 2 ) . ";";
		} elseif (AppUtil::endsWith ( $string, "){" )) {
			return substr ( $string, 0, strlen ( $string ) - 1 ) . ";";
		}
		return $string;
	}
	private static function getCheckKeywords() {
		$keywords = array ();
		$keywords [] = array (
				"name" => "namespace ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "use ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "final class ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "class ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "enum ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "interface ",
				"indent" => "" 
		);
		$keywords [] = array (
				"name" => "private ",
				"indent" => "\t" 
		);
		$keywords [] = array (
				"name" => "protected ",
				"indent" => "\t" 
		);
		$keywords [] = array (
				"name" => "public ",
				"indent" => "\t" 
		);
		$keywords [] = array (
				"name" => "final ",
				"indent" => "\t" 
		);
		$keywords [] = array (
				"name" => "const ",
				"indent" => "\t" 
		);
		return $keywords;
	}
}