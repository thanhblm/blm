<?php

namespace common\services\batch;

use common\filter\batch\BatchFilter;
use common\persistence\base\vo\BatchVo;
use common\persistence\extend\dao\BatchExtendDao;
use core\config\ApplicationConfig;
use core\utils\SessionUtil;
use common\persistence\extend\vo\BatchExtendVo;

class BatchService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new BatchExtendDao ();
	}
	public function selectByKey(BatchVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(BatchVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function selectByFilterExtend(BatchExtendVo $vo) {
		return $this->extendDao->selectByFilterExtend( $vo );
	}
	public function countByFilter(BatchVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function delete(BatchVo $vo) {
		return $this->extendDao->delete ( $vo );
	}
	public function createBatch(BatchVo $vo, $listFileUpload) {
		$pathBatch = ApplicationConfig::get ( "batch.path" ) . $vo->batchGroupId . DS;
		if (! file_exists ( ApplicationConfig::get ( "batch.path" ) . $vo->batchGroupId )) {
			mkdir ( $pathBatch, 0777, true );
		}
		for($i = 0; $i < count ( $listFileUpload ['name'] ); $i ++) {
			$fileName = $listFileUpload ['name'] [$i];
			$fileTemp = $listFileUpload ['tmp_name'] [$i];
			if (file_exists ( $pathBatch . $fileName )) {
				unlink ( $pathBatch . $fileName );
				$batchVo = new BatchVo ();
				$batchVo->fileName = $fileName;
				$batchVo->batchGroupId = $vo->batchGroupId;
				$batchVos = $this->extendDao->selectByFilter ( $batchVo );
				if (count ( $batchVos ) > 0) {
					foreach ( $batchVos as $batch ) {
						$this->extendDao->deleteByKey ( $batch );
					}
				}
			}
			if(move_uploaded_file ( $fileTemp, $pathBatch . $fileName )){
				$pos = strrpos ( $fileName, '-', - 1 );
				$fileNameRule = substr ( $fileName, $pos );
				$titleBatch = substr ( $fileNameRule, 1, (strrpos ( $fileNameRule, '.' ) - 1) );
				
				$batchVo = new BatchVo ();
				$batchVo->title = ApplicationConfig::get ( "batch.name" ) . " " . intval ( $titleBatch );
				$batchVo->fileName = $fileName;
				$batchVo->batchGroupId = $vo->batchGroupId;
				
				$batchVo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
				$batchVo->crDate = date ( 'Y-m-d H:i:s' );
				$batchVo->mdDate = date ( 'Y-m-d H:i:s' );
				$batchVo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
				
				$this->extendDao->insertDynamic ( $batchVo );
			}
		}
	}
	public function updateBatch(BatchVo $vo) {
		$this->extendDao->updateDynamicByKey ( $vo );
	}
	public function search(BatchFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(BatchFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
	public function deleteBatch(BatchVo $vo) {
		$vo = $this->extendDao->selectByKey ( $vo );
		$pathBatch = ApplicationConfig::get ( "batch.path" ) . $vo->batchGroupId . DS;
		if (file_exists ( $pathBatch . $vo->fileName )) {
			unlink ( $pathBatch . $vo->fileName );
		}
		return $this->extendDao->deleteByKey ( $vo );
	}
}