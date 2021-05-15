<?php

// Action map config.
return array(
	// Start API
	"api/aliexpress/import/product" => array(
		'controller' => 'api\controllers\aliexpress\AliexpressController',
		'method' => 'importProduct',
		'desc' => 'Import View',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'api/aliexpress/import_product.php'
			)
		)
	),

	"api/aliexpress/session" => array(
		'controller' => 'api\controllers\aliexpress\AliexpressController',
		'method' => 'checkSession',
		'desc' => 'Check Session',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'api/aliexpress/import_product.php'
			)
		)
	),
);