<?php

namespace common\services\layout;

use common\persistence\base\dao\GridWidgetBaseDao;
use common\persistence\base\dao\WidgetContentBaseDao;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\base\vo\WidgetContentLangVo;
use common\persistence\base\vo\WidgetContentVo;
use common\persistence\extend\dao\WidgetContentExtendDao;
use common\persistence\extend\dao\WidgetContentLangExtendDao;
use common\persistence\extend\vo\WidgetContentExtendVo;
use common\persistence\extend\vo\WidgetContentLangExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;
use common\persistence\extend\dao\GridWidgetExtendDao;

class WidgetContentService extends BaseService {
	private $widgetContentBaseDao;
	private $widgetContentLangExtendDao;
	private $widgetContentExtendDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->widgetContentBaseDao = new WidgetContentBaseDao ();
		$this->widgetContentLangExtendDao = new WidgetContentLangExtendDao ();
		$this->widgetContentExtendDao = new WidgetContentExtendDao ();
	}
	public function selectByKey(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->selectByKey ( $widgetContentVo );
	}
	public function selectAll(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->selectAll ( $widgetContentVo );
	}
	public function selectByFilter(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->selectByFilter ( $widgetContentVo );
	}
	public function countByFilter(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->countByFilter ( $widgetContentVo );
	}
	public function insertDynamic(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->insertDynamic ( $widgetContentVo );
	}
	public function updateDynamicByKey(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->updateDynamicByKey ( $widgetContentVo );
	}
	public function deleteByKey(WidgetContentVo $widgetContentVo = null) {
		return $this->widgetContentBaseDao->deleteByKey ( $widgetContentVo );
	}
	public function getWidgetContentInfo(WidgetContentExtendVo $widgetContentExtendVo) {
		return $this->widgetContentExtendDao->getWidgetContentInfo ( $widgetContentExtendVo );
	}
	public function getWidgetContentList(WidgetContentExtendVo $widgetContentExtendVo = null) {
		return $this->widgetContentExtendDao->getWidgetContentList ( $widgetContentExtendVo );
	}
	
	// lang
	public function getLangsByWidgetContentId(WidgetContentLangExtendVo $filter) {
		return $this->widgetContentLangExtendDao->getLangsByWidgetContentId ( $filter );
	}
	public function createWidgetContent(WidgetContentExtendVo $widgetContentVo, BaseArray $widgetContentLanguages, $gridId) {
		// Remove extra field to get widget_content lang list.
		$widgetContentLangVos = array ();
		foreach ( $widgetContentLanguages->getArray () as $item ) {
			$widgetContentLangVo = new WidgetContentLangVo ();
			AppUtil::copyProperties ( $item, $widgetContentLangVo );
			$widgetContentLangVos [] = $widgetContentLangVo;
		}
		$sqlClient = new SqlMapClient ( $this->context );
		$widgetContentDao = new WidgetContentBaseDao ( $this->context, $sqlClient );
		$gridWidgetDao = new GridWidgetBaseDao ( $this->context, $sqlClient );
		$widgetContentLangDao = new WidgetContentLangExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			// Add to email template table.
			$widgetContentId = $widgetContentDao->insertDynamic ( $widgetContentVo );
			// Add email template langs.
			foreach ( $widgetContentLangVos as $lang ) {
				$lang->setting = ($lang->setting) ? json_encode ( $lang->setting ) : json_encode ( array () );
				$lang->widgetContentId = $widgetContentId;
				$widgetContentLangDao->insertDynamic ( $lang );
			}
			
			$gridWidgetVo = new GridWidgetVo ();
			$gridWidgetVo->gridId = $gridId;
			$gridWidgetVo->widgetContentId = $widgetContentId;
			$gridWidgetVo->order = 999;
			$gridWidgetDao->insertDynamic ( $gridWidgetVo );
			
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function updateWidgetContent(WidgetContentExtendVo $widgetContentVo, BaseArray $widgetContentLanguages) {
		// Remove extra field to get widget_content lang list.
		$widgetContentLangVos = array ();
		foreach ( $widgetContentLanguages->getArray () as $item ) {
			$widgetContentLangVo = new WidgetContentLangVo ();
			AppUtil::copyProperties ( $item, $widgetContentLangVo );
			$widgetContentLangVos [] = $widgetContentLangVo;
		}
		$sqlClient = new SqlMapClient ( $this->context );
		$widgetContentDao = new WidgetContentBaseDao ( $this->context, $sqlClient );
		$widgetContentLangDao = new WidgetContentLangExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			// Add to widget_content table.
			$widgetContentDao->updateDynamicByKey ( $widgetContentVo );
			// Remove all widget_content lang of this widget_content
			// and insert new widget_content lang.
			foreach ( $widgetContentLangVos as $lang ) {
				$lang->setting = ($lang->setting) ? json_encode ( $lang->setting ) : json_encode ( array () );
				// Delete widget_content lang.
				$widgetContentLangDao->deleteByKey ( $lang );
				// Add new widget_content lang.
				$widgetContentLangDao->insertDynamic ( $lang );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function deleteWidgetContent(WidgetContentVo $widgetContentVo, BaseArray $widgetContentLanguages) {
		// Remove extra field to get widget_content lang list.
		$widgetContentLangVos = array ();
		foreach ( $widgetContentLanguages->getArray () as $item ) {
			$widgetContentLangVo = new WidgetContentLangVo ();
			AppUtil::copyProperties ( $item, $widgetContentLangVo );
			$widgetContentLangVos [] = $widgetContentLangVo;
		}
		
		$sqlClient = new SqlMapClient ( $this->context );
		$widgetContentDao = new WidgetContentBaseDao ( $this->context, $sqlClient );
		$widgetContentLangDao = new WidgetContentLangExtendDao ( $this->context, $sqlClient );
		$gridWidgetExtendDao = new GridWidgetExtendDao($this->context, $sqlClient);
		$sqlClient->startTransaction ();
		try {
			$gridWidgetVo = new GridWidgetVo ();
			$gridWidgetVo->widgetContentId = $widgetContentVo->id;
			$gridWidgetExtendDao->deleteByFilter ( $gridWidgetVo );
			
			// Remove widget_content
			$widgetContentDao->deleteByKey ( $widgetContentVo );
			// Remove all widget_content lang of this widget_content
			foreach ( $widgetContentLangVos as $lang ) {
				// Delete widget_content lang.
				$widgetContentLangDao->deleteByKey ( $lang );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
}