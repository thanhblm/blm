<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class RegionVo extends BaseVo {
	public $id;
	public $name;
	public $contactEmail;
	public $invoiceLogo;
	public $invoiceHeader;
	public $invoiceComment;
	public $status;
	public $currencyCode;
	public $fallbackRegion;
	public $freeShippingAmount;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'name' => 'name',
			'contact_email' => 'contactEmail',
			'invoice_logo' => 'invoiceLogo',
			'invoice_header' => 'invoiceHeader',
			'invoice_comment' => 'invoiceComment',
			'status' => 'status',
			'currency_code' => 'currencyCode',
			'fallback_region' => 'fallbackRegion',
			'free_shipping_amount' => 'freeShippingAmount',
			'cr_date' => 'crDate',
			'cr_by' => 'crBy',
			'md_date' => 'mdDate',
			'md_by' => 'mdBy' 
		);
		$this->columnMap = array (
			"id" => array (
				"COLUMN_NAME" => "id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => "auto_increment"
			),
			"name" => array (
				"COLUMN_NAME" => "name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "45",
				"COLUMN_TYPE" => "varchar(45)",
				"EXTRA" => ""
			),
			"contactEmail" => array (
				"COLUMN_NAME" => "contact_email",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "50",
				"COLUMN_TYPE" => "varchar(50)",
				"EXTRA" => ""
			),
			"invoiceLogo" => array (
				"COLUMN_NAME" => "invoice_logo",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "250",
				"COLUMN_TYPE" => "varchar(250)",
				"EXTRA" => ""
			),
			"invoiceHeader" => array (
				"COLUMN_NAME" => "invoice_header",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"invoiceComment" => array (
				"COLUMN_NAME" => "invoice_comment",
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
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "8",
				"COLUMN_TYPE" => "enum('active','inactive')",
				"EXTRA" => ""
			),
			"currencyCode" => array (
				"COLUMN_NAME" => "currency_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
				"EXTRA" => ""
			),
			"fallbackRegion" => array (
				"COLUMN_NAME" => "fallback_region",
				"COLUMN_DEFAULT" => "no",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "3",
				"COLUMN_TYPE" => "enum('yes','no')",
				"EXTRA" => ""
			),
			"freeShippingAmount" => array (
				"COLUMN_NAME" => "free_shipping_amount",
				"COLUMN_DEFAULT" => "200.00",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "decimal",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "decimal(20,2)",
				"EXTRA" => ""
			),
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"crBy" => array (
				"COLUMN_NAME" => "cr_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"mdDate" => array (
				"COLUMN_NAME" => "md_date",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"mdBy" => array (
				"COLUMN_NAME" => "md_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			)
		);
	}
}