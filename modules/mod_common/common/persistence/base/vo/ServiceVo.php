<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ServiceVo extends BaseVo {
	public $id;
	public $serviceName;
	public $serviceId;
	public $databaseName;
	public $databasePassword;
	public $servicesStatusId;
	public $serviceEmail;
	public $groupId;
	public $crDate;
	public $crBy;
	public $mdDate;
	public $mdBy;
	public $dueDate;
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'id' => 'id',
			'service_name' => 'serviceName',
			'service_id' => 'serviceId',
			'database_name' => 'databaseName',
			'database_password' => 'databasePassword',
			'services_status_id' => 'servicesStatusId',
			'service_email' => 'serviceEmail',
			'group_id' => 'groupId',
			'cr_date' => 'crDate',
			'cr_by' => 'crBy',
			'md_date' => 'mdDate',
			'md_by' => 'mdBy',
			'due_date' => 'dueDate' 
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
			"serviceName" => array (
				"COLUMN_NAME" => "service_name",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"serviceId" => array (
				"COLUMN_NAME" => "service_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "100",
				"COLUMN_TYPE" => "varchar(100)",
				"EXTRA" => ""
			),
			"databaseName" => array (
				"COLUMN_NAME" => "database_name",
				"COLUMN_DEFAULT" => "NULL",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"databasePassword" => array (
				"COLUMN_NAME" => "database_password",
				"COLUMN_DEFAULT" => "NULL",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"servicesStatusId" => array (
				"COLUMN_NAME" => "services_status_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"serviceEmail" => array (
				"COLUMN_NAME" => "service_email",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "varchar",
				"CHARACTER_MAXIMUM_LENGTH" => "255",
				"COLUMN_TYPE" => "varchar(255)",
				"EXTRA" => ""
			),
			"groupId" => array (
				"COLUMN_NAME" => "group_id",
				"COLUMN_DEFAULT" => "",
				"IS_NULLABLE" => "NO",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"crDate" => array (
				"COLUMN_NAME" => "cr_date",
				"COLUMN_DEFAULT" => "NULL",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"crBy" => array (
				"COLUMN_NAME" => "cr_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"mdDate" => array (
				"COLUMN_NAME" => "md_date",
				"COLUMN_DEFAULT" => "NULL",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			),
			"mdBy" => array (
				"COLUMN_NAME" => "md_by",
				"COLUMN_DEFAULT" => "0",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "int",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "int(11)",
				"EXTRA" => ""
			),
			"dueDate" => array (
				"COLUMN_NAME" => "due_date",
				"COLUMN_DEFAULT" => "NULL",
				"IS_NULLABLE" => "YES",
				"DATA_TYPE" => "datetime",
				"CHARACTER_MAXIMUM_LENGTH" => "",
				"COLUMN_TYPE" => "datetime",
				"EXTRA" => ""
			)
		);
	}
}