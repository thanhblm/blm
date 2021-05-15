<?php

namespace core\tools;

use core\utils\AppUtil;
use core\utils\TextFileUtil;

class CodeGen {
	private $connection;
	private $dbName;
	private $moduleName;
	private $tableInfoMap;
	private $tableColumnMap;
	public $destFolder;
	public $templateFolder;
	public $voTemplate;
	public $mappingTemplate;
	public $daoTemplate;
	public function __construct($dbName, $moduleName = "app", $tableName = null) {
		$this->dbName = $dbName;
		$this->moduleName = $moduleName;
		// Create connection.
		$this->connection = new \PDO ( 'mysql:host=localhost;dbname=' . $dbName, 'root', '', array (
				\PDO::ATTR_PERSISTENT => true 
		) );
		$this->connection->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		// Set default templates.
		$this->voTemplate = "template_vo.php";
		$this->mappingTemplate = "template_mapping.php";
		$this->daoTemplate = "template_base_dao.php";
		// Set default template folder.
		$this->templateFolder = ROOT . DS . "core" . DS . "tools" . DS . "templates";
		// Get table info map.
		$this->tableInfoMap = array ();
		$this->tableColumnMap = array ();
		if (! AppUtil::isEmptyString ( $tableName )) {
			$this->tableInfoMap [$tableName] = $this->getTableInfo ( $tableName );
			$this->tableColumnMap [$tableName] = $this->getTableColumns ( $tableName );
		} else {
			$tables = $this->getTables ();
			foreach ( $tables as $table ) {
				$this->tableInfoMap [$table] = $this->getTableInfo ( $table );
				$this->tableColumnMap [$table] = $this->getTableColumns ( $table );
			}
		}
		// Get column map of tables.
	}
	public function genVo() {
		$this->validInputParams ();
		foreach ( $this->tableInfoMap as $table => $tableInfo ) {
			$this->genVo4Table ( $table );
		}
	}
	public function genMapping() {
		$this->validInputParams ();
		foreach ( $this->tableInfoMap as $table => $tableInfo ) {
			$this->genMapping4Table ( $table );
		}
	}
	public function genDao() {
		$this->validInputParams ();
		foreach ( $this->tableInfoMap as $table => $tableInfo ) {
			$this->genDao4Table ( $table );
		}
	}
	public function genAll() {
		$this->genVo ();
		$this->genMapping ();
		$this->genDao ();
	}
	public function getTables() {
		$stmt = $this->connection->prepare ( 'show tables from `' . $this->dbName . "`" );
		if ($stmt->execute ()) {
			$rows = $stmt->fetchAll ( \PDO::FETCH_NAMED );
			$tables = array ();
			$tableKey = "Tables_in_" . $this->dbName;
			if (! is_null ( $rows )) {
				foreach ( $rows as $row ) {
					$tables [] = $row [$tableKey];
				}
			}
			return $tables;
		}
		return null;
	}
	public function getTableInfo($table) {
		$stmt = $this->connection->prepare ( 'show columns from `' . $table . "`" );
		if ($stmt->execute ()) {
			$rows = $stmt->fetchAll ( \PDO::FETCH_NAMED );
			return $rows;
		}
		return null;
	}
	private function getTableColumns($table) {
		$query = "SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, EXTRA FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_SCHEMA = '" . $this->dbName . "' AND TABLE_NAME = '" . $table . "'";
		$stmt = $this->connection->prepare ( $query );
		if ($stmt->execute ()) {
			$rows = $stmt->fetchAll ( \PDO::FETCH_NAMED );
			return $rows;
		}
		return null;
	}
	private function validInputParams() {
		// Check dest folder.
		if (AppUtil::isEmptyString ( $this->destFolder )) {
			throw new \Exception ( "The destination folder cannot be blank." );
		}
		if (! file_exists ( $this->destFolder )) {
			throw new \Exception ( "The destination folder [" . $this->destFolder . "] doesn't exists." );
		}
		// Check template folder.
		if (AppUtil::isEmptyString ( $this->templateFolder )) {
			throw new \Exception ( "The template folder cannot be blank." );
		}
		if (! file_exists ( $this->templateFolder )) {
			throw new \Exception ( "The template folder [" . $this->templateFolder . "] doesn't exists." );
		}
	}
	private function genVo4Table($tableName) {
		// Create vo folder into the destination folder if it doesn't exists.
		$voFolder = $this->destFolder . DS . "vo";
		if (! file_exists ( $voFolder )) {
			mkdir ( $voFolder );
		}
		// Check the vo template file.
		$voTemplateFile = $this->templateFolder . DS . $this->voTemplate;
		if (! file_exists ( $voTemplateFile )) {
			throw new \Exception ( "The vo template [" . $voTemplateFile . "] doesn't exists." );
		}
		// Get content of the template file.
		$templateContent = TextFileUtil::readFile ( $voTemplateFile );
		// Replace with the new content.
		$templateContent = AppUtil::replaceByMap ( $this->createVoMap ( $tableName ), $templateContent );
		// Write new content to the file.
		$voFilePath = $voFolder . DS . AppUtil::pascalCase ( $tableName ) . "Vo.php";
		TextFileUtil::writeFile ( $voFilePath, $templateContent );
	}
	private function createVoMap($tableName) {
		$voMap = array ();
		$voMap ["__MODULE_NAME__"] = $this->moduleName;
		$voMap ["__CLASS_NAME__"] = AppUtil::pascalCase ( $tableName );
		$voMap ["__RESULT_MAPPING__"] = $this->buildColumnMapping ( $tableName );
		$voMap ["__COLUMN_MAPPING__"] = $this->buildTableColumns ( $tableName );
		$voMap ["//__FIELD_DECLARATION__"] = $this->buildFieldDeclaration ( $tableName );
		return $voMap;
	}
	private function genMapping4Table($tableName) {
		// Create mapping folder into the destination folder if it doesn't exists.
		$mappingFolder = $this->destFolder . DS . "mapping";
		if (! file_exists ( $mappingFolder )) {
			mkdir ( $mappingFolder );
		}
		// Check the mapping template file.
		$mappingTemplateFile = $this->templateFolder . DS . $this->mappingTemplate;
		if (! file_exists ( $mappingTemplateFile )) {
			throw new \Exception ( "The mapping template [" . $mappingTemplateFile . "] doesn't exists." );
		}
		// Get content of the template file.
		$templateContent = TextFileUtil::readFile ( $mappingTemplateFile );
		$templateContent = AppUtil::replaceByMap ( $this->createMappingMap ( $tableName ), $templateContent );
		// Write new content to the file.
		$mappingFilePath = $mappingFolder . DS . AppUtil::pascalCase ( $tableName ) . "Mapping.php";
		TextFileUtil::writeFile ( $mappingFilePath, $templateContent );
	}
	private function createMappingMap($tableName) {
		$mappingMap = array ();
		$mappingMap ["__MODULE_NAME__"] = $this->moduleName;
		$mappingMap ["__CLASS_NAME__"] = AppUtil::pascalCase ( $tableName );
		$mappingMap ["__PARAM_NAME__"] = AppUtil::camelCase ( $tableName );
		$mappingMap ["__TABLE_NAME__"] = "`" . $tableName . "`";
		$mappingMap ["__AUTO_INCREASE_COLUMNS__"] = $this->buildAutoIncreaseColumns ( $tableName );
		$mappingMap ["__KEY_COLUMNS__"] = $this->buildKeyColumns ( $tableName );
		$mappingMap ["__KEY_CONDITION__"] = $this->buildKeyCondition ( $tableName );
		$mappingMap ["__SELECT_CONDITION__"] = $this->buildSelectCondition ( $tableName );
		$mappingMap ["__COUNT_CONDITION__"] = $this->buildCountCondition ( $tableName );
		$mappingMap ["__INSERT_CLAUSE__"] = $this->buildInsertClause ( $tableName );
		$mappingMap ["__INSERT_CLAUSE_WITH_ID__"] = $this->buildInsertClause ( $tableName, true );
		$mappingMap ["__UPDATE_CLAUSE__"] = $this->buildUpdateClause ( $tableName );
		return $mappingMap;
	}
	private function genDao4Table($tableName) {
		// Create dao folder into the destination folder if it doesn't exists.
		$daoFolder = $this->destFolder . DS . "dao";
		if (! file_exists ( $daoFolder )) {
			mkdir ( $daoFolder );
		}
		// Check the dao template file.
		$daoTemplateFile = $this->templateFolder . DS . $this->daoTemplate;
		if (! file_exists ( $daoTemplateFile )) {
			throw new \Exception ( "The dao template [" . $daoTemplateFile . "] doesn't exists." );
		}
		// Get content of the template file.
		$templateContent = TextFileUtil::readFile ( $daoTemplateFile );
		$templateContent = AppUtil::replaceByMap ( $this->createDaoMap ( $tableName ), $templateContent );
		// Write new content to the file.
		$daoFilePath = $daoFolder . DS . AppUtil::pascalCase ( $tableName ) . "BaseDao.php";
		TextFileUtil::writeFile ( $daoFilePath, $templateContent );
	}
	private function createDaoMap($tableName) {
		$mappingMap = array ();
		$mappingMap ["__MODULE_NAME__"] = $this->moduleName;
		$mappingMap ["__CLASS_NAME__"] = AppUtil::pascalCase ( $tableName );
		$mappingMap ["__PARAM_NAME__"] = AppUtil::camelCase ( $tableName );
		return $mappingMap;
	}
	private function buildColumnMapping($tableName) {
		$resultMap = "";
		$tableInfo = $this->tableInfoMap [$tableName];
		$count = 0;
		$size = count ( $tableInfo );
		foreach ( $tableInfo as $column ) {
			$count ++;
			$columnName = $column ['Field'];
			$fieldName = AppUtil::camelCase ( $columnName );
			if ($count == 1) {
				if ($count == $size) {
					$resultMap .= "'" . $columnName . "' => '" . $fieldName . "'";
				} else {
					$resultMap .= "'" . $columnName . "' => '" . $fieldName . "',\n";
				}
			} else {
				if ($count == $size) {
					$resultMap .= "\t\t\t'" . $columnName . "' => '" . $fieldName . "'";
				} else {
					$resultMap .= "\t\t\t'" . $columnName . "' => '" . $fieldName . "',\n";
				}
			}
		}
		return $resultMap;
	}
	private function buildTableColumns($tableName) {
		$result = "array (";
		$tableColumnInfo = $this->tableColumnMap [$tableName];
		$count = 0;
		$size = count ( $tableColumnInfo );
		foreach ( $tableColumnInfo as $column ) {
			$count ++;
			$columnName = $column ['COLUMN_NAME'];
			$fieldName = AppUtil::camelCase ( $columnName );
			$result .= "\n\t\t\t\"" . $fieldName . "\" => array (";
			$result .= "\n\t\t\t\t\"COLUMN_NAME\" => \"" . $column ['COLUMN_NAME'] . "\",";
			$result .= "\n\t\t\t\t\"COLUMN_DEFAULT\" => \"" . $column ['COLUMN_DEFAULT'] . "\",";
			$result .= "\n\t\t\t\t\"IS_NULLABLE\" => \"" . $column ['IS_NULLABLE'] . "\",";
			$result .= "\n\t\t\t\t\"DATA_TYPE\" => \"" . $column ['DATA_TYPE'] . "\",";
			$result .= "\n\t\t\t\t\"CHARACTER_MAXIMUM_LENGTH\" => \"" . $column ['CHARACTER_MAXIMUM_LENGTH'] . "\",";
			$result .= "\n\t\t\t\t\"COLUMN_TYPE\" => \"" . $column ['COLUMN_TYPE'] . "\",";
			$result .= "\n\t\t\t\t\"EXTRA\" => \"" . $column ['EXTRA'] . "\"";
			if ($count == $size) {
				$result .= "\n\t\t\t)";
			} else {
				$result .= "\n\t\t\t),";
			}
		}
		$result .= "\n\t\t)";
		return $result;
	}
	private function buildFieldDeclaration($tableName) {
		$fieldMap = "";
		$tableInfo = $this->tableInfoMap [$tableName];
		$count = 0;
		$size = count ( $tableInfo );
		foreach ( $tableInfo as $column ) {
			$count ++;
			$columnName = $column ['Field'];
			$fieldName = AppUtil::camelCase ( $columnName );
			if ($count == 1) {
				if ($count == $size) {
					$fieldMap .= "public $" . $fieldName . ";";
				} else {
					$fieldMap .= "public $" . $fieldName . ";\n";
				}
			} else {
				if ($count == $size) {
					$fieldMap .= "\tpublic $" . $fieldName . ";";
				} else {
					$fieldMap .= "\tpublic $" . $fieldName . ";\n";
				}
			}
		}
		return $fieldMap;
	}
	private function buildKeyCondition($tableName) {
		$tableInfo = $this->tableInfoMap [$tableName];
		$isFirst = true;
		$keyCondition = "";
		foreach ( $tableInfo as $column ) {
			if (isset ( $column ['Key'] ) && $column ['Key'] == "PRI") {
				if ($isFirst) {
					$keyCondition .= "(`" . $column ['Field'] . "` = #{" . AppUtil::camelCase ( $column ['Field'] ) . "})";
				} else {
					$keyCondition .= " and (`" . $column ['Field'] . "` = #{" . AppUtil::camelCase ( $column ['Field'] ) . "})";
				}
				$isFirst = false;
			}
		}
		return $keyCondition;
	}
	private function buildAutoIncreaseColumns($tableName) {
		$tableInfo = $this->tableInfoMap [$tableName];
		$autoIncreaseColumns = "";
		foreach ( $tableInfo as $column ) {
			if (isset ( $column ['Extra'] ) && $column ['Extra'] == 'auto_increment') {
				$autoIncreaseColumns .= "\"" . $column ['Field'] . "\",";
			}
		}
		if (! AppUtil::isEmptyString ( $autoIncreaseColumns )) {
			$autoIncreaseColumns = substr ( $autoIncreaseColumns, 0, strlen ( $autoIncreaseColumns ) - 1 );
		}
		return $autoIncreaseColumns;
	}
	private function buildKeyColumns($tableName) {
		$tableInfo = $this->tableInfoMap [$tableName];
		$keyColumns = "";
		foreach ( $tableInfo as $column ) {
			if (isset ( $column ['Key'] ) && $column ['Key'] == "PRI") {
				$keyColumns .= "\"" . $column ['Field'] . "\",";
			}
		}
		if (! AppUtil::isEmptyString ( $keyColumns )) {
			$keyColumns = substr ( $keyColumns, 0, strlen ( $keyColumns ) - 1 );
		}
		return $keyColumns;
	}
	private function buildSelectCondition($tableName) {
		$condition = "\$queryBuilder";
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			$condition .= "\n\t\t\t\t->appendCondition ( \"`" . $column ['Field'] . "`\", \"" . AppUtil::camelCase ( $column ['Field'] ) . "\")";
		}
		$condition .= "\n\t\t\t\t->appendOrder()";
		$condition .= "\n\t\t\t\t->appendLimit()";
		return $condition;
	}
	private function buildCountCondition($tableName) {
		$condition = "\$queryBuilder";
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			$condition .= "\n\t\t\t\t->appendCondition ( \"`" . $column ['Field'] . "`\", \"" . AppUtil::camelCase ( $column ['Field'] ) . "\")";
		}
		return $condition;
	}
	private function buildInsertClause($tableName, $withId = false) {
		$autoColumns = $this->getAutoColumns ( $tableName );
		$insertClause = "\$queryBuilder";
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			if ($withId) {
				$insertClause .= "\n\t\t\t\t->appendField(\"`" . $column ['Field'] . "`\", \"" . AppUtil::camelCase ( $column ['Field'] ) . "\")";
			} else {
				if (! in_array ( $column ['Field'], $autoColumns )) {
					$insertClause .= "\n\t\t\t\t->appendField(\"`" . $column ['Field'] . "`\", \"" . AppUtil::camelCase ( $column ['Field'] ) . "\")";
				}
			}
		}
		return $insertClause;
	}
	private function buildUpdateClause($tableName) {
		$keyColumns = $this->getKeyColumns ( $tableName );
		$updateClause = "\$queryBuilder";
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			if (! in_array ( $column ['Field'], $keyColumns )) {
				$updateClause .= "\n\t\t\t\t->appendField(\"`" . $column ['Field'] . "`\", \"" . AppUtil::camelCase ( $column ['Field'] ) . "\")";
			}
		}
		// $updateClause .= "\n\t\t\t\t->appendCondition(\"" . $this->buildKeyCondition ( $tableName ) . "\")";
		return $updateClause;
	}
	private function getAutoColumns($tableName) {
		$autoColumns = array ();
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			if (isset ( $column ['Extra'] ) && $column ['Extra'] == 'auto_increment') {
				$autoColumns [] = $column ["Field"];
			}
		}
		return $autoColumns;
	}
	private function getKeyColumns($tableName) {
		$keyColumns = array ();
		$tableInfo = $this->tableInfoMap [$tableName];
		foreach ( $tableInfo as $column ) {
			if (isset ( $column ['Key'] ) && $column ['Key'] == "PRI") {
				$keyColumns [] = $column ["Field"];
			}
		}
		return $keyColumns;
	}
}