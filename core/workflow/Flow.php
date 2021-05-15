<?php

namespace core\workflow;

use core\workflow\ContextBase;
use core\workflow\WorkFlowConfig;
use core\config\FConstants;
use core\config\FErrorCodes;
use core\config\FAttributes;

class Flow implements Task {
	private $tasks = array ();
	private $handlers = array ();
	private $exitPoints = array ();
	public function execute(ContextBase &$context) {
		try {
			
			$wfpName = $context->get ( FAttributes::ATTR_WFP_NAME );
			$flow = WorkFlowConfig::getFlow ( $wfpName );
			if (! isset ( $flow ) || is_null ( $flow )) {
				throw new \Exception ( "NULL in flow " . $wfpName );
			}
			
			foreach ( $flow as $type => $classes ) {
				switch ($type) {
					case "task" :
						for($i = 0; $i < count ( $classes ); $i ++) {
							$this->tasks [] = $classes [$i];
						}
						break;
					case "handle" :
						for($i = 0; $i < count ( $classes ); $i ++) {
							$this->handlers [] = $classes [$i];
						}
						
						break;
					case "exit_point" :
						for($i = 0; $i < count ( $classes ); $i ++) {
							$this->exitPoints [] = $classes [$i];
						}
						break;
					default :
						break;
				}
			}
			$startFlowTime = round ( microtime ( true ) * 1000 );
			$startTaskTime = null;
			$taskResult = true;
			$exception = null;
			$context->set ( FAttributes::ATTR_ERROR_CODE, FConstants::SUSCESS );
			\DatoLogUtil::trace ( "Flow.Start|" . $wfpName );
			for($i = 0; $i < count ( $this->tasks ); $i ++) {
				if (! $taskResult) {
					break;
				}
				try {
					$startTaskTime = round ( microtime ( true ) * 1000 );
					$taskName = $this->tasks [$i];
					$context->set ( FAttributes::ATTR_TASK_NAME, $taskName );
					$task = new $taskName ();
					$taskResult = $task->execute ( $context );
					if (is_null($taskResult)){
						$taskResult = true;
					}
					if ($taskResult !== false) {
						$taskResult = true;
					}
					$this->exitTask ( $context, $startTaskTime );
				} catch ( \Exception $e ) {
					$context->set ( FAttributes::ATTR_ERROR_CODE, FErrorCodes::ERR_SYSTEM_INTERNAL_ERROR );
					$exception = $e;
					$taskResult = false;
					\DatoLogUtil::error ( $e->getMessage() );
					$this->exitTask ( $context, $startTaskTime );
					break;
				}
			}
			
			$handleName = null;
			if (! $taskResult) {
				\DatoLogUtil::trace ( "Going to process handler..." );
				for($i = 0; $i < count ( $this->handlers ); $i ++) {
					$startTaskTime = round ( microtime ( true ) * 1000 );
					try {
						$handleName = $this->handlers [$i];
						$context->set ( FAttributes::ATTR_TASK_NAME, $handleName );
						$handle = new $handleName ();
						$handle->handle ( $context, $exception );
						$this->exitTask ( $context, $startTaskTime );
					} catch ( \Exception $e ) {
						$exception = $e;
						\DatoLogUtil::error ( "Fail to perform handle : " . $handleName, $e );
						\DatoLogUtil::error ( $e->getMessage() );
						$this->exitTask ( $context, $startTaskTime );
						
					}
				}
			}
			
			$exitPointName = null;
			\DatoLogUtil::trace ( "Going to process exit point..." );
			for($i = 0; $i < count ( $this->exitPoints ); $i ++) {
				$startTaskTime = round ( microtime ( true ) * 1000 );
				try {
					$exitPointName = $this->exitPoints [$i];
					$context->set ( FAttributes::ATTR_TASK_NAME, $exitPointName );
					$exitPoint = new $exitPointName ();
					$exitPoint->process ( $context );
					$this->exitTask ( $context, $startTaskTime );
				} catch ( \Exception $e ) {
					$exception = $e;
					\DatoLogUtil::error ( "Fail to perform exitPoint : " . $exitPointName, $e );
					\DatoLogUtil::error ( $e->getMessage() );
					$this->exitTask ( $context, $startTaskTime );
					
				}
			}
			$this->exitFlow ( $context, $exception, $taskResult, $startFlowTime );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function exitTask($context, $startTime) {
		$endTime = round ( microtime ( true ) * 1000 );
		$elapedTime = ( int ) ($endTime - $startTime);
		$str = "Task.End|" . $context->get ( FAttributes::ATTR_TASK_NAME ) . "|ErrorCode:" . $context->get ( FAttributes::ATTR_ERROR_CODE ) . "| Processed time(ms): " . $elapedTime;
		\DatoLogUtil::logElapedTime ( "WORKFLOW: " . $context->get ( FAttributes::ATTR_WFP_NAME ) . "| TASK: " . $context->get ( FAttributes::ATTR_TASK_NAME ), $elapedTime );
		if (FConstants::SUSCESS == $context->get ( FAttributes::ATTR_ERROR_CODE ))
			\DatoLogUtil::trace ( $str );
		else {
			\DatoLogUtil::error ( $str );
		}
	}
	private function exitFlow(ContextBase $context, \Exception $exception = null, $processStatus = null, $startTime) {
		$endTime = round ( microtime ( true ) * 1000 );
		$elapedTime = ( int ) ($endTime - $startTime);
		$str = "Flow.End|" . $context->get ( FAttributes::ATTR_WFP_NAME ) . "|ErrorCode:" . $context->get ( FAttributes::ATTR_ERROR_CODE ) . "| Processed time(ms): " . $elapedTime;
		\DatoLogUtil::logElapedTime("WORKFLOW END: " . $context->get ( FAttributes::ATTR_WFP_NAME ),$elapedTime);
		if ((FConstants::SUSCESS == $context->get ( FAttributes::ATTR_ERROR_CODE )) && ($processStatus)){
			\DatoLogUtil::trace ( $str );
			if (!is_null ( $exception )) {
				\DatoLogUtil::warn($exception);
			}
		}else {
			if (is_null ( $exception )) {
				\DatoLogUtil::error ( $str );
			} else {
				\DatoLogUtil::error ( $exception->getMessage () );
				\DatoLogUtil::error ( $str, $exception );
			}
		}
	}
}