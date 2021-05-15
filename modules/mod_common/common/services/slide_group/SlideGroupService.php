<?php

namespace common\services\slide_group;

use common\filter\slide_group\SlideGroupFilter;
use common\persistence\base\vo\SlideGroupVo;
use common\persistence\base\vo\SlideVo;
use common\persistence\extend\dao\SlideExtendDao;
use common\persistence\extend\dao\SlideGroupExtendDao;
use common\utils\FileUtil;
use core\config\ApplicationConfig;
use core\database\SqlMapClient;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class SlideGroupService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new SlideGroupExtendDao ();
	}
	public function selectByKey(SlideGroupVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(SlideGroupVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function countByFilter(SlideGroupVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function create(SlideGroupVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function update(SlideGroupVo $vo) {
		return $this->extendDao->updateDynamicByKey ( $vo );
	}
	public function delete(SlideGroupVo $vo) {
		$slideDao = new SlideExtendDao ();
		$slideVo = new SlideVo ();
		$slideVo->slideGroupId = $vo->id;
		$listSlide = $slideDao->selectByFilter ( $slideVo );
		$pathSlide = ApplicationConfig::get ( "slide.path" ) . $vo->id . DS;
		if (isset ( $listSlide )) {
			foreach ( $listSlide as $slide ) {
				$slideDao->deleteByKey ( $slide );
			}
		}
		FileUtil::deleteDir ( $pathSlide );
		return $this->extendDao->deleteByKey ( $vo );
	}
	public function search(SlideGroupFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(SlideGroupFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
	public function copy(SlideGroupVo $vo, $slideGroupSourceId) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		$srcDir = ApplicationConfig::get ( "slide.path" ) . $slideGroupSourceId;
		try {
			$slideGroupDao = new SlideGroupExtendDao ( null, $sqlMapClient );
			$slideDao = new SlideExtendDao ( null, $sqlMapClient );
			$slideGroupId = $slideGroupDao->insertDynamic ( $vo );
			$slideVo = new SlideVo ();
			$slideVo->slideGroupId = $slideGroupSourceId;
			$listSlide = $slideDao->selectByFilter ( $slideVo );
			if (count ( $listSlide ) > 0) {
				foreach ( $listSlide as $slide ) {
					$slideNew = AppUtil::cloneObj ( $slide );
					$slideNew->slideGroupId = $slideGroupId;
					$slideNew->id = null;
					$slideDao->insertDynamic ( $slideNew );
				}
			}
			$desDir = ApplicationConfig::get ( "slide.path" ) . $slideGroupId;
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
	 * @param SlideGroupVo $vo        	
	 * @param unknown $listFileUpload
	 *        	is $_FILE['name']
	 * @throws Exception
	 */
	public function createWithFileSlide(SlideGroupVo $vo, $listFileUpload) {
		$sqlMapClient = new SqlMapClient ();
		$sqlMapClient->startTransaction ();
		try {
			$slideGroupDao = new SlideGroupExtendDao ( null, $sqlMapClient );
			$slideDao = new SlideExtendDao ( null, $sqlMapClient );
			$slideGroupId = $slideGroupDao->insertDynamic ( $vo );
			$pathSlide = ApplicationConfig::get ( "slide.path" ) . $slideGroupId . DS;
			if (! file_exists ( ApplicationConfig::get ( "slide.path" ) . $slideGroupId )) {
				mkdir ( $pathSlide, 0777, true );
			}
			
			for($i = 0; $i < count ( $listFileUpload ['name'] ); $i ++) {
				$fileName = $listFileUpload ['name'] [$i];
				$fileType = $listFileUpload ['type'] [$i];
				$fileTemp = $listFileUpload ['tmp_name'] [$i];
				if (file_exists ( $pathSlide . $fileName )) {
					unlink ( $pathSlide . $fileName );
					$slideVo = new SlideVo ();
					$slideVo->fileName = $fileName;
					$slideVo->slideGroupId = $slideGroupId;
					$slideDao->delete ( $slideVo );
				}
				if (move_uploaded_file ( $fileTemp, $pathSlide . $fileName )) {
					$titleSlide = substr ( $fileName, (strlen ( $fileName ) - 7), 3 );
					$slideVo = new SlideVo ();
					
					$pos = strrpos ( $fileName, '-', - 1 );
					$fileNameRule = substr ( $fileName, $pos );
					$titleSlide = substr ( $fileNameRule, 1, (strrpos ( $fileNameRule, '.' ) - 1) );
					
					
					$slideVo->title = ApplicationConfig::get ( "slide.name" ) . " " . intval ( $titleSlide );
					$slideVo->fileName = $fileName;
					$slideVo->slideGroupId = $slideGroupId;
					
					$slideVo->crBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
					$slideVo->crDate = date ( 'Y-m-d H:i:s' );
					$slideVo->mdDate = date ( 'Y-m-d H:i:s' );
					$slideVo->mdBy = SessionUtil::get ( ApplicationConfig::get("session.user.login.name") )->userId;
					$slideDao->insertDynamic ( $slideVo );
				}
			}
			$sqlMapClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
}