<?php
return array (
	'aliexpress_import_product' => array(
		'task' => array (
			'common\workflow\aliexpress_import_product\tasks\PrepareProductDetailTask',
			'common\workflow\aliexpress_import_product\tasks\PrepareProductPriceTask',
			'common\workflow\aliexpress_import_product\tasks\PrepareProductAttributeTask'
		),
		'handle' => array (
			'common\workflow\aliexpress_import_product\AliexpressImportProductHandler'
		),
		'exit_point' => array (
			'common\workflow\aliexpress_import_product\AliexpressImportProductExitFlow'
		)
	),
);