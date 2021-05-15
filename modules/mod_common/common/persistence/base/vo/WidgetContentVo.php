<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class WidgetContentVo extends BaseVo {
	public $id;
	public $widgetId;
	public $name;
	public $description;
	public $class;
	public $style;
	public $setting;
	public $public;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'widget_id' => 'widgetId',
			'name' => 'name',
			'description' => 'description',
			'class' => 'class',
			'style' => 'style',
			'setting' => 'setting',
			'public' => 'public' 
		);
		$this->columnMap = array (
			"id" => array (
				"COLUMN_NAME" => "id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => "auto_increment"
			),
			"widgetId" => array (
				"COLUMN_NAME" => "widget_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"description" => array (
				"COLUMN_NAME" => "description",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"class" => array (
				"COLUMN_NAME" => "class",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"style" => array (
				"COLUMN_NAME" => "style",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"setting" => array (
				"COLUMN_NAME" => "setting",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"public" => array (
				"COLUMN_NAME" => "public",
				"COLUMN_DEFAULT" => "1",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
				"EXTRA" => ""
			)
		);
	}
}