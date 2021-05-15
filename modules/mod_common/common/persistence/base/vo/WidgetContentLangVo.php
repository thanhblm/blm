<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class WidgetContentLangVo extends BaseVo {
	public $widgetContentId;
	public $languageCode;
	public $setting;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'widget_content_id' => 'widgetContentId',
			'language_code' => 'languageCode',
			'setting' => 'setting' 
		);
		$this->columnMap = array (
			"widgetContentId" => array (
				"COLUMN_NAME" => "widget_content_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"languageCode" => array (
				"COLUMN_NAME" => "language_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
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
			)
		);
	}
}