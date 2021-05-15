<?php
// Action map config.
return array(
	"file/manager" => array(
		'controller' => 'filemanager\controllers\FileUploadController',
		'method' => 'main',
		'desc' => 'File Upload Page',
		'group' => array(
			'file.manager:authenticated'
		),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'main_data.php'
			)
		)
	),

	"file/manager/delete" => array(
		'controller' => 'filemanager\controllers\FileUploadController',
		'method' => 'delete',
		'desc' => 'File Upload Page',
		'group' => array(
			'file.manager:authenticated'
		),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'main_data.php'
			)
		)
	),
	"file/manager/folder/add" => array(
		'controller' => 'filemanager\controllers\FileUploadController',
		'method' => 'addFolder',
		'desc' => 'File Upload Page',
		'group' => array(
			'file.manager:authenticated'
		),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'main_data.php'
			)
		)
	),

	"file/manager/upload" => array(
		'controller' => 'filemanager\controllers\FileUploadController',
		'method' => 'progress',
		'desc' => 'Save File Upload Page',
		'group' => array(
			'file.manager:authenticated'
		),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'upload_data.php'
			)
		)
	),
	"images" => array(
		'controller' => 'filemanager\controllers\FileUploadController',
		'method' => 'image',
		'desc' => 'Get Image File',
	),
// 		"file/manager/test" => array (
// 				'controller' => 'filemanager\controllers\FileUploadController',
// 				'method' => 'test',
// 				'desc' => 'Get Image File',
// 				'group' => array (
// 						'test:*' 
// 				),

// 				'results' => array (
// 						'success' => array (
// 								'type' => 'include',
// 								'path' => 'test_data.php' 
// 						) 
// 				) 

// 		) 

);