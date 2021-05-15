<?php
return array(
	'wfp_test_workflow' => array(
		'task' => array(
			'common\workflow\mydemo\Test1Task',
			'common\workflow\mydemo\Test2Task'
		),
		'handle' => array(
			'common\workflow\mydemo\Test1Handler'
		),
		'exit_point' => array(
			'common\workflow\mydemo\Test1ExitFlow'
		)
	),
	'wfl_erdt_upload' => array(
		'task' => array(
			'backend\workflow\erdt\GenerateErdtCsvFileTask',
			'backend\workflow\erdt\UploadErdtCsvFileTask',
			'backend\workflow\erdt\UpdateErdtOrderHistoryTask'
		)
	),
	'wfl_erdt_export' => array(
		'task' => array(
			'backend\workflow\erdt\GenerateReservedOrderCsvFileTask'
		)
	),
	'wfl_cancel_pending_order' => array(
		'task' => array(
			'backend\workflow\cancel_pending_order\CollectPendingOrderTask',
			'backend\workflow\cancel_pending_order\CancelPendingOrderTask'
		)
	),
);