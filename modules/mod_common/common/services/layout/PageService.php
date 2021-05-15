<?php

namespace common\services\layout;

use common\helper\LogHelper;
use common\persistence\base\dao\ContainerBaseDao;
use common\persistence\base\dao\GridBaseDao;
use common\persistence\base\dao\PageBaseDao;
use common\persistence\base\dao\PageCacheBaseDao;
use common\persistence\base\dao\PageLangBaseDao;
use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\PageCacheVo;
use common\persistence\base\vo\PageLangVo;
use common\persistence\base\vo\PageVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\dao\ContainerExtendDao;
use common\persistence\extend\dao\PageCacheExtendDao;
use common\persistence\extend\dao\PageExtendDao;
use common\persistence\extend\dao\PageLangExtendDao;
use common\persistence\extend\dao\SeoInfoLangExtendDao;
use common\persistence\extend\vo\PageExtendVo;
use common\persistence\extend\vo\PageLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\base\BaseService;
use common\utils\FileUtil;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class PageService extends BaseService {
	private $pageBaseDao;
	private $pageExtendDao;
	private $pageLangExtendDao;
	private $pageCacheDao;
	public function __construct() {
		$this->pageBaseDao = new PageBaseDao ();
		$this->pageExtendDao = new PageExtendDao ();
		$this->pageLangExtendDao = new PageLangExtendDao ();
		$this->pageCacheDao = new PageCacheBaseDao ();
	}
	public function selectByKey(PageVo $pageVo = null) {
		return $this->pageBaseDao->selectByKey ( $pageVo );
	}
	public function selectAll(PageVo $pageVo = null) {
		return $this->pageBaseDao->selectAll ( $pageVo );
	}
	public function selectByFilter(PageVo $pageVo = null) {
		return $this->pageBaseDao->selectByFilter ( $pageVo );
	}
	public function countByFilter(PageVo $pageVo = null) {
		return $this->pageBaseDao->countByFilter ( $pageVo );
	}
	public function insertDynamic(PageVo $pageVo = null) {
		return $this->pageBaseDao->insertDynamic ( $pageVo );
	}
	public function updateDynamicByKey(PageVo $pageVo = null) {
		return $this->pageBaseDao->updateDynamicByKey ( $pageVo );
	}
	public function deleteByKey(PageVo $pageVo = null) {
		return $this->pageBaseDao->deleteByKey ( $pageVo );
	}

	/**
	 * ***************************
	 * ADVANCE
	 * ***************************
	 */
	public function getContainerOfPage($pageId) {
		$containerDao = new ContainerExtendDao();
		$containerVos = $containerDao->getContainerByPageId($pageId );
		if ($containerVos) {
			return $containerVos;
		} else {
			// create new container of page
			$filter = new ContainerVo ();
			$filter->pageId = $pageId;
			$filter->name = '';
			$filter->position = 'main';
			$filter->class = '';
			$filter->isSystem = 0;
			$filter->isTemp = 0;
			$containerId = $containerDao->insertDynamic ( $filter );
			$filter->id = $containerId;
			return $filter;
		}
	}
	public function transaction() {
		$sqlClient = new SqlMapClient ( $this->context );
		$gridDao = new GridBaseDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			// action here

			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function addPageTemp() {
		$sqlClient = new SqlMapClient ( $this->context );
		$pageDao = new PageBaseDao ( $this->context, $sqlClient );
		$seoInfoLangDao = new SeoInfoLangBaseDao ( $this->context, $sqlClient );
		$containerDao = new ContainerBaseDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			$pageVo = new PageVo ();
			$pageVo->action = '';
			$pageVo->isTemp = 1;
			$pageId = $pageDao->insertDynamic ( $pageVo );

			// new seoInfoLang
			$filter = new SeoInfoLangExtendVo ();
			$filter->itemId = $pageId;
			$filter->type = 'page';
			$seoInfoLangVos = self::getSeoInfosByPageId ( $filter );
			foreach ( $seoInfoLangVos as $seoInfoLangVo ) {
				$filter = new SeoInfoLangExtendVo ();
				$filter->itemId = $pageId;
				$filter->type = 'page';
				$filter->languageCode = $seoInfoLangVo->code;
				$seoInfoLangDao->insertDynamic ( $filter );
			}

			// new container
			$filter = new ContainerVo ();
			$filter->pageId = $pageId;
			$filter->name = '';
			$filter->position = 'main';
			$filter->class = '';
			$filter->isSystem = 0;
			$filter->isTemp = 0;
			$containerDao->insertDynamic ( $filter );

			$sqlClient->endTransaction ();
			return $pageId;
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}

	/**
	 * ***************************
	 * FILTER
	 * ***************************
	 */
	public function getPageByFilter(PageExtendVo $filter) {
		return $this->pageExtendDao->getPageByFilter ( $filter );
	}
	public function getCountByFilter(PageExtendVo $filter) {
		return $this->pageExtendDao->getCountByFilter ( $filter );
	}

	/**
	 * ***************************
	 * LANGUAGE
	 * ***************************
	 */
	public function getLangsByPageId(PageLangExtendVo $filter) {
		return $this->pageLangExtendDao->getLangsByPageId ( $filter );
	}
	public function getSeoInfosByPageId(SeoInfoLangExtendVo $filter) {
		$seoInfoDao = new SeoInfoLangExtendDao ();
		return $seoInfoDao->getLangsByKey ( $filter );
	}

	/**
	 * ***************************
	 * PAGE
	 * ***************************
	 */
	public function updatePage(PageVo $pageVo, BaseArray $pageLangs, BaseArray $seoInfoLangs) {
		$pageLangVos = array ();
		foreach ( $pageLangs->getArray () as $item ) {
			$pageLangVo = new PageLangVo ();
			AppUtil::copyProperties ( $item, $pageLangVo );
			$pageLangVos [] = $pageLangVo;
		}
		$seoInfoVos = array ();
		foreach ( $seoInfoLangs->getArray () as $item ) {
			$seoInfoVo = new SeoInfoLangVo ();
			AppUtil::copyProperties ( $item, $seoInfoVo );
			$seoInfoVos [] = $seoInfoVo;
		}
		$sqlClient = new SqlMapClient ( $this->context );
		$pageDao = new PageBaseDao ( $this->context, $sqlClient );
		$pageLangDao = new PageLangExtendDao ( $this->context, $sqlClient );
		$seoInfoLangDao = new SeoInfoLangExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			// Update to page table.
			$pageDao->updateDynamicByKey ( $pageVo );
			// Remove all page lang of this page
			// and insert new page lang.
			foreach ( $pageLangVos as $lang ) {
				// Delete page lang.
				$pageLangDao->deleteByKey ( $lang );
				// Add new page lang.
				$pageLangDao->insertDynamic ( $lang );
			}
			foreach ( $seoInfoVos as $seoInfoVo ) {
				// Delete page lang.
				$seoInfoLangDao->deleteByKey ( $seoInfoVo );
				// Add new page lang.
				$seoInfoLangDao->insertDynamic ( $seoInfoVo );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function copyPage(PageVo $pageVoSource) {
		$sqlClient = new SqlMapClient ( $this->context );
		$pageDao = new PageBaseDao ( $this->context, $sqlClient );
		$pageLangBaseDao = new PageLangBaseDao ( $this->context, $sqlClient );
		$seoInfoLangBaseDao = new SeoInfoLangBaseDao ( $this->context, $sqlClient );
		$containerService = new ContainerService ();
		$sqlClient->startTransaction ();
		try {
			// copy page
			$pageVoCopy = $pageVoSource;
			$pageVoCopy->name = '';
			$pageVoCopy->isTemp = 1;
			$pageVoCopy->isSystem = 0;
			$pageIdCopy = $pageDao->insertDynamic ( $pageVoCopy );

			// copy pageLang
			$filter = new PageLangVo ();
			$filter->pageId = $pageVoSource->id;
			$pageLangVos = $pageLangBaseDao->selectByFilter ( $filter );
			foreach ( $pageLangVos as $pageLangVo ) {
				$pageLangVo->pageId = $pageIdCopy;
				$pageLangBaseDao->insertDynamic ( $pageLangVo );
			}

			// copy seoInfoLang
			$filter = new SeoInfoLangExtendVo ();
			$filter->itemId = $pageVoSource->id;
			$filter->type = 'page';
			$seoInfoLangVos = $seoInfoLangBaseDao->selectByFilter ( $filter );
			foreach ( $seoInfoLangVos as $seoInfoLangVo ) {
				$seoInfoLangVo->itemId = $pageIdCopy;
				$seoInfoLangBaseDao->insertDynamic ( $seoInfoLangVo );
			}

			// copy container
			$containerVoSource = $this->getContainerOfPage ( $pageVoSource->id );
			if ($containerVoSource) {
				$containerService->copyContainer ( $containerVoSource );
			}

			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
		return $pageIdCopy;
	}
	public function deletePage(PageVo $pageVo) {
		$sqlClient = new SqlMapClient ( $this->context );
		$pageBaseDao = new PageBaseDao ( $this->context, $sqlClient );
		$pageExtendDao = new PageExtendDao ( $this->context, $sqlClient );
		$containerDao = new ContainerBaseDao ( $this->context, $sqlClient );
		$seoInfoLangExtendDao = new SeoInfoLangExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// delete pageLang
			$filter = new PageLangVo ();
			$filter->pageId = $pageVo->id;
			$pageExtendDao->deletePageLang ( $filter );

			// delete seoInfoLang
			$filter = new SeoInfoLangVo ();
			$filter->itemId = $pageVo->id;
			$filter->type = 'page';
			$seoInfoLangExtendDao->deleteByFilter ( $filter );

			// copy container
			$containerVo = $this->getContainerOfPage ( $pageVo->id );
			$containerDao->deleteByKey ( $containerVo );

			// delete page
			$pageBaseDao->deleteByKey ( $pageVo );

			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function deletePageTemp() {
		$sqlClient = new SqlMapClient ( $this->context );
		$pageBaseDao = new PageBaseDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			$filter = new PageVo ();
			$filter->isTemp = 1;
			$pageList = $pageBaseDao->selectByFilter ( $filter );
			if (! empty ( $pageList )) {
				foreach ( $pageList as $pageVo ) {
					$this->deletePage ( $pageVo );
				}
			}

			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function getPageInfoBySeoUrl(SeoInfoLangVo $filter) {
		$result = $this->pageExtendDao->getPageInfoBySeoUrl ( $filter );
		return $result;
	}
	public function getPageCacheByKey(PageCacheVo $filter) {
		return $this->pageCacheDao->selectByKey ( $filter );
	}
	public function insertPageCache(PageCacheVo $pageCacheVo) {
		return $this->pageCacheDao->insertDynamic ( $pageCacheVo );
	}

    /**
     * ***************************
     * PAGE CACHE
     * ***************************
     */
    public function recachePage($pageId) {
        $sqlClient = new SqlMapClient ( $this->context );
        $pageCacheExtendDao = new PageCacheExtendDao($this->context, $sqlClient);
        $sqlClient->startTransaction ();
        try {
            // action here
            $filter = new PageCacheVo();
            $filter->pageId = $pageId;
            $pageCacheExtendDao->deleteByPageId($filter);

            $sqlClient->endTransaction ();
        } catch ( \Exception $e ) {
            $sqlClient->rollback ();
            throw $e;
        }
    }

    public function recachePageAll() {
        $sqlClient = new SqlMapClient ( $this->context );
        $pageCacheExtendDao = new PageCacheExtendDao($this->context, $sqlClient);
        $pageCacheList = $pageCacheExtendDao->selectAll();
        $sqlClient->startTransaction ();
        try {
            // action here
        	foreach ($pageCacheList as $pageCacheVo) {
        		$pageCacheExtendDao->deleteByPageId($pageCacheVo);
            }

            $sqlClient->endTransaction ();
        } catch ( \Exception $e ) {
            $sqlClient->rollback ();
            throw $e;
        }
    }
}