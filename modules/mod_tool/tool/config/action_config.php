<?php
// Action map config. 
return array(
	"code/gen" => array(
		'controller' => 'tool\controllers\CodeController',
		'method' => 'generate',
		'desc' => 'Generate dao code',
		'group' => array('dato.framework.code.gen:*'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'code/code_gen.php'
			)
		)
	),
	"system-info" => array(
		'controller' => 'tool\controllers\SysController',
		'method' => 'index',
		'desc' => 'System info',
		'group' => array('dato.framework.system:*'),
		'results' => array(
			'success' => array(
				'type' => 'redirect',
				'path' => 'sys/info',
			)
		)
	),
	"sys/info" => array(
		'controller' => 'tool\controllers\SysController',
		'method' => 'index',
		'desc' => 'System info',
		'group' => array('dato.framework.system:*'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'sys.php'
			)
		)
	),
	"sys/permission/update" => array(
		'controller' => 'tool\controllers\PermissionController',
		'method' => 'updatePemission',
		'desc' => 'Update Pemission',
		'group' => array('dato.framework.system:*'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'permission.php'
			)
		)
	),
	/*
	"db/migrate/endoca" => array (
			'controller' => 'tool\controllers\DbMigrateController',
			'method' => 'endocaDbMigrate',
			'desc' => 'Migrate Endoca Database',
			'group' => array('dato.framework.system:*'),
			'results' => array (
					'success' => array (
							'type' => 'include',
							'path' => 'endoca_db_migrate.php'
					)
			)
	),
	*/
	"interface/gen" => array(
		'controller' => 'tool\controllers\InterfaceController',
		'method' => 'generate',
		'desc' => 'Generate interface',
		'group' => array('dato.framework.interface.gen:*'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'interface/gen.php'
			)
		)
	),
);