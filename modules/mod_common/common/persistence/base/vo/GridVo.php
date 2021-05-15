<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class GridVo extends BaseVo {
	public $id;
	public $containerId;
	public $parentId;
	public $width;
	public $align;
	public $fluidContainer;
	public $class;
	public $style;
	public $status;
	public $order;
	public $bgImage;
	public $bgColor;
	public $bgSize;
	public $bgRepeat;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'container_id' => 'containerId',
			'parent_id' => 'parentId',
			'width' => 'width',
			'align' => 'align',
			'fluid_container' => 'fluidContainer',
			'class' => 'class',
			'style' => 'style',
			'status' => 'status',
			'order' => 'order',
			'bg_image' => 'bgImage',
			'bg_color' => 'bgColor',
			'bg_size' => 'bgSize',
			'bg_repeat' => 'bgRepeat' 
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
			"containerId" => array (
				"COLUMN_NAME" => "container_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"parentId" => array (
				"COLUMN_NAME" => "parent_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"width" => array (
				"COLUMN_NAME" => "width",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
				"EXTRA" => ""
			),
			"align" => array (
				"COLUMN_NAME" => "align",
				"COLUMN_DEFAULT" => "full",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"fluidContainer" => array (
				"COLUMN_NAME" => "fluid_container",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "tinyint",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "tinyint(4)",
				"EXTRA" => ""
			),
			"class" => array (
				"COLUMN_NAME" => "class",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
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
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "active",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"order" => array (
				"COLUMN_NAME" => "order",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"bgImage" => array (
				"COLUMN_NAME" => "bg_image",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"bgColor" => array (
				"COLUMN_NAME" => "bg_color",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"bgSize" => array (
				"COLUMN_NAME" => "bg_size",
				"COLUMN_DEFAULT" => "auto",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			),
			"bgRepeat" => array (
				"COLUMN_NAME" => "bg_repeat",
				"COLUMN_DEFAULT" => "no-repeat",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "225",
				"COLUMN_TYPE" => "varchar(225)",
				"EXTRA" => ""
			)
		);
	}
}