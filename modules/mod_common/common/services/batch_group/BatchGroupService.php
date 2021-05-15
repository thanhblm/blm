<?php

namespace common\services\batch_group;

use common\filter\batch_group\SlideGroupFilter;
use common\persistence\base\vo\BatchGroupVo;
use common\persistence\base\vo\BatchVo;
use common\persistence\extend\dao\BatchExtendDao;
use common\persistence\extend\dao\BatchGroupExtendDao;
use common\utils\FileUtil;
use core\config\ApplicationConfig;
use core\database\SqlMapClient;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class BatchGroupService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new BatchGroupExtendDao ();
	}
	public function selectByKey(BatchGroupVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(BatchGroupVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function countByFilter(BatchGroupVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function create(BatchGroupVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function update(BatchGroupVo $vo) {
		return $this->extendDao->updateDynamicByKey ( $vo );
	}
	public function delete(BatchGroupVo $vo) {
		$batchDao = new BatchExtendDao ();
		$batchVo = new BatchVo ();
		$batchVo->batchGroupId = $vo->id;
		$listBatch = $batchDao->selectByFilter ( $batchVo );
		$pathBatch = ApplicationConfig::get ( "batch.path" ) . $vo->id . DS;
		if (isset ( $listBatch )) {
			foreach ( $listBatch as $batch ) {
				$batchDao->deleteByKey ( $batch );
			}
		}
		FileUtil::deleteDir ( $pathBatch );
		return $this->extendDao->deleteByKey ( $vo );
	}
	public function search(SlideGroupFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(SlideGroupFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
	public function copy(BatchGroupVo $vo, $batchGroupSourceId) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		$srcDir = ApplicationConfig::get ( "batch.path" ) . $batchGroupSourceId;
		try {
			$batchGroupDao = new BatchGroupExtendDao ( null, $sqlMapClient );
			$batchDao = new BatchExtendDao ( null, $sqlMapClient );
			$batchGroupId = $batchGroupDao->insertDynamic ( $vo );
			$batchVo = new BatchVo ();
			$batchVo->batchGroupId = $batchGroupSourceId;
			$listBatch = $batchDao->selectByFilter ( $batchVo );
			if (count ( $listBatch ) > 0) {
				foreach ( $listBatch as $batch ) {
					$batchNew = AppUtil::cloneObj ( $batch );
					$batchNew->batchGroupId = $batchGroupId;
					$batchNew->id = null;
					$batchDao->insertDynamic ( $batchNew );
				}
			}
			$desDir = ApplicationConfig::get ( "batch.path" ) . $batchGroupId;
			FileUtil::coppyDir ( $srcDir, $desDir );
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			FileUtil::deleteDir ( $desDir );
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
	
	/**
	 *
	 * @param BatchGroupVo $vo        	
	 * @param unknown $listFileUpload
	 *        	is $_FILE['name']
	 * @throws Exception
	 */
	public function createWithFileBatch(BatchGroupVo $vo, $listFileUpload) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$batchGroupDao = new BatchGroupExtendDao ( null, $sqlMapClient );
			$batchDao = new BatchExtendDao ( null, $sqlMapClient );
			$batchGroupId = $batchGroupDao->insertDynamic ( $vo );
			$pathBatch = ApplicationConfig::get ( "batch.path" ) . $batchGroupId . DS;
			if (! file_exists ( ApplicationConfig::get ( "batch.path" ) . $batchGroupId )) {
				mkdir ( $pathBatch, 0777, true );
			}
			
			for($i = 0; $i < count ( $listFileUpload ['name'] ); $i ++) {
				$fileName = $listFileUpload ['name'] [$i];
				$fileType = $listFileUpload ['type'] [$i];
				$fileTemp = $listFileUpload ['tmp_name'] [$i];
				if (file_exists ( $pathBatch . $fileName )) {
					unlink ( $pathBatch . $fileName );
					$batchVo = new BatchVo ();
					$batchVo->fileName = $fileName;
					$batchVo->batchGroupId = $batchGroupId;
					$batchDao->delete ( $batchVo );
				}
				if (move_uploaded_file ( $fileTemp, $pathBatch . $fileName )) {
					$titleBatch = substr ( $fileName, (strlen ( $fileName ) - 7), 3 );
					$batchVo = new BatchVo ();
					
					$pos = strrpos ( $fileName, '-', - 1 );
					$fileNameRule = substr ( $fileName, $pos );
					$titleBatch = substr ( $fileNameRule, 1, (strrpos ( $fileNameRule, '.' ) - 1) );
					
					
					$batchVo->title = ApplicationConfig::get ( "batch.name" ) . " " . intval ( $titleBatch );
					$batchVo->fileName = $fileName;
					$batchVo->batchGroupId = $batchGroupId;
					
					$batchVo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
					$batchVo->crDate = date ( 'Y-m-d H:i:s' );
					$batchVo->mdDate = date ( 'Y-m-d H:i:s' );
					$batchVo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
					$batchDao->insertDynamic ( $batchVo );
				}
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
}