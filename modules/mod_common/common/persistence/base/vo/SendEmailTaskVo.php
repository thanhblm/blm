<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class SendEmailTaskVo extends BaseVo {
	public $id;
	public $fromName;
	public $subject;
	public $body;
	public $to;
	public $cc;
	public $bcc;
	public $attachments;
	public $status;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'from_name' => 'fromName',
			'subject' => 'subject',
			'body' => 'body',
			'to' => 'to',
			'cc' => 'cc',
			'bcc' => 'bcc',
			'attachments' => 'attachments',
			'status' => 'status' 
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
			"fromName" => array (
				"COLUMN_NAME" => "from_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"subject" => array (
				"COLUMN_NAME" => "subject",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"body" => array (
				"COLUMN_NAME" => "body",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"to" => array (
				"COLUMN_NAME" => "to",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"cc" => array (
				"COLUMN_NAME" => "cc",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"bcc" => array (
				"COLUMN_NAME" => "bcc",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"attachments" => array (
				"COLUMN_NAME" => "attachments",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"status" => array (
				"COLUMN_NAME" => "status",
				"COLUMN_DEFAULT" => "pending",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "enum",
				"CHARACTER_MAXIMUM_LENGTH" => "7",
				"COLUMN_TYPE" => "enum('pending','sending','sent','error')",
				"EXTRA" => ""
			)
		);
	}
}