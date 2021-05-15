<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class EmailTemplateLangVo extends BaseVo {
	public $emailTemplateId;
	public $languageCode;
	public $title;
	public $subject;
	public $body;
	public $from;
	public $reply;
	public $cc;
	public $bcc;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'email_template_id' => 'emailTemplateId',
			'language_code' => 'languageCode',
			'title' => 'title',
			'subject' => 'subject',
			'body' => 'body',
			'from' => 'from',
			'reply' => 'reply',
			'cc' => 'cc',
			'bcc' => 'bcc' 
		);
		$this->columnMap = array (
			"emailTemplateId" => array (
				"COLUMN_NAME" => "email_template_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(10) unsigned",
				"EXTRA" => ""
			),
			"languageCode" => array (
				"COLUMN_NAME" => "language_code",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "10",
				"COLUMN_TYPE" => "varchar(10)",
				"EXTRA" => ""
			),
			"title" => array (
				"COLUMN_NAME" => "title",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"subject" => array (
				"COLUMN_NAME" => "subject",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"body" => array (
				"COLUMN_NAME" => "body",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "text",
				"CHARACTER_MAXIMUM_LENGTH" => "65535",
				"COLUMN_TYPE" => "text",
				"EXTRA" => ""
			),
			"from" => array (
				"COLUMN_NAME" => "from",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"reply" => array (
				"COLUMN_NAME" => "reply",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"cc" => array (
				"COLUMN_NAME" => "cc",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"bcc" => array (
				"COLUMN_NAME" => "bcc",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			)
		);
	}
}