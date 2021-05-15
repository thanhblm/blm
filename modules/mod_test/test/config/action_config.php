<?php
// Action map config.
return array(
	"product" => array(
		'controller' => 'test\controllers\ProductController',
		'method' => 'index',
		'desc' => 'Product Page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'product/product_index.php'
			)
		)
	),
	"toantq" => array(
		'controller' => 'test\controllers\ToantqController',
		'method' => 'index',
		'desc' => 'Product Page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'toantq.php'
			)
		)
	),
	'tandt/test' => array(
		'controller' => 'test\controllers\TandtController',
		'method' => 'test',
		'desc' => 'Test Conditions',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'tandt.php'
			)
		)
	),
	'test/complex/index' => array(
		'controller' => 'test\controllers\TestComplexModelController',
		'method' => 'index',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'complex_model/complex.php'
			)
		)
	),
	'test/complex/add' => array(
		'controller' => 'test\controllers\TestComplexModelController',
		'method' => 'add',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'complex_model/complex_form.php'
			)
		)
	),
	'test/json/serialize' => array(
		'controller' => 'test\controllers\JsonUtilTestController',
		'method' => 'serialize',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'json/json_serialize.php'
			)
		)
	),
	'test/json/deserialize' => array(
		'controller' => 'test\controllers\JsonUtilTestController',
		'method' => 'deserialize',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'json/json_deserialize.php'
			)
		)
	),
	'test/lang' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getLang'
	),
	'test/cart/update' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'updateShoppingCart'
	),
	'test/discount/price/level' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getPriceLevel'
	),
	'test/discount/bulk' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getBulkDiscount'
	),
	'test/discount/coupon' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getDiscountCoupon'
	),
	'test/tag/replace' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getReplaceTag'
	),
	'test/file/class/get' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'getClasses'
	),
	'test/string/start/with' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'startWith'
	),
	'test/string/end/with' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'endWith'
	),
	'test/php/file/parse' => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'parsePhpFile'
	),
	"test/pending/order" => array(
		'controller' => 'test\controllers\TestController',
		'method' => 'testPendingOrder'
	),
	'hoang/test' => array(
		'controller' => 'test\controllers\HoangController',
		'method' => 'test',
		'desc' => 'Test Conditions',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'tandt.php'
			)
		)
	),
);