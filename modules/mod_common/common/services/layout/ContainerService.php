<?php

namespace common\services\layout;

use common\persistence\base\dao\GridBaseDao;
use common\persistence\base\dao\GridWidgetBaseDao;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\dao\ContainerBaseDao;
use common\persistence\base\vo\GridVo;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\extend\dao\ContainerExtendDao;
use common\persistence\extend\dao\GridExtendDao;
use common\persistence\extend\dao\GridWidgetExtendDao;
use common\services\base\BaseService;
use core\database\SqlMapClient;

class ContainerService extends BaseService
{
    private $containerBaseDao;
    private $containerExtendDao;

    public function __construct()
    {
        $this->containerBaseDao = new ContainerBaseDao();
        $this->containerExtendDao = new ContainerExtendDao();
    }

    public function selectByKey(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->selectByKey($containerVo);
    }

    public function selectAll(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->selectAll($containerVo);
    }

    public function selectByFilter(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->selectByFilter($containerVo);
    }

    public function countByFilter(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->countByFilter($containerVo);
    }

    public function insertDynamic(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->insertDynamic($containerVo);
    }

    public function updateDynamicByKey(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->updateDynamicByKey($containerVo);
    }

    public function deleteByKey(ContainerVo $containerVo = null)
    {
        return $this->containerBaseDao->deleteByKey($containerVo);
    }

    /**
     * ***************************
     * ADVANCE
     * ***************************
     */
    public function addContainerTemp()
    {
        $sqlClient = new SqlMapClient($this->context);
        $containerDao = new ContainerBaseDao($this->context, $sqlClient);
        $sqlClient->startTransaction();
        try {
            $filter = new ContainerVo ();
            $filter->pageId = 0;
            $filter->name = '';
            $filter->position = 'main';
            $filter->class = '';
            $filter->isSystem = 0;
            $filter->isTemp = 1;
            $containerId = $containerDao->insertDynamic($filter);

            $sqlClient->endTransaction();
            return $containerId;
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function copyContainer(ContainerVo $containerVoSource)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $containerDao = new ContainerBaseDao ($this->context, $sqlClient);
        $containerBaseDao = new ContainerBaseDao ($this->context, $sqlClient);
        $gridBaseDao = new GridBaseDao ($this->context, $sqlClient);
        $gridWidgetBaseDao = new GridWidgetBaseDao($this->context, $sqlClient);
        $sqlClient->startTransaction();
        try {
            // copy container
            $containerVoCopy = $containerVoSource;
            $containerVoCopy->name = '';
            $containerVoCopy->isTemp = 1;
            $containerVoCopy->isSystem = 0;
            $containerIdCopy = $containerDao->insertDynamic($containerVoCopy);

            // copy grid of container
            $copyData = array();
            $gridVo = new GridVo ();
            $gridVo->containerId = $containerVoSource->id;
            $gridSourceList = $gridBaseDao->selectByFilter($gridVo);
            foreach ($gridSourceList as $gridVoSource) {
                $gridVoCopy = $gridVoSource;
                $gridVoCopy->containerId = $containerIdCopy;
                $gridIdCopy = $gridBaseDao->insertDynamic($gridVoCopy);
                //set $copyData
                $copyData[] = array(
                    'sourceId' => $gridVoSource->id,
                    'sourceParentId' => $gridVoSource->parentId,
                    'copyId' => $gridIdCopy
                );

                // copy gridWidget of grid
                $filter = new GridWidgetVo ();
                $filter->gridId = $gridVoSource->id;
                $gridWidgetSourceList = $gridWidgetBaseDao->selectByFilter($filter);
                foreach ($gridWidgetSourceList as $gridWidgetVoSource) {
                    $gridWidgetVoCopy = $gridWidgetVoSource;
                    $gridWidgetVoCopy->gridId = $gridIdCopy;
                    $gridWidgetBaseDao->insertDynamic($gridWidgetVoCopy);
                }
            }
            /*
            update parentId of grid copy by $copyData
            input
            sourceId	sourceParentId	copyId 		copyParentId
            190			0				200			0
            196			190				201			190		->	false
            196			190				201			200		->	true
            solution
            copyId=200	->	sourceParentId=0 	-> 	if(sourceParentId=0) then return 0
            copyId=201	->	sourceParentId=190	->	sourceId=190	->	copyId=200
            */
            foreach ($copyData as $v) {
                $copyId = $v['copyId'];
                $sourceParentId = $v['sourceParentId'];
                if ($sourceParentId) {
                    foreach ($copyData as $tmp) {
                        $sourceId = $tmp['sourceId'];
                        if ($sourceId == $sourceParentId) {
                            $gridVoUpdate = new GridVo ();
                            $gridVoUpdate->id = $copyId;
                            $gridVoUpdate->parentId = $tmp['copyId'];
                            $gridBaseDao->updateDynamicByKey($gridVoUpdate);
                            break;
                        }
                    }
                }
            }

            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
        return $containerIdCopy;
    }

    public function deleteContainer(ContainerVo $containerVo)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $containerBaseDao = new ContainerBaseDao ($this->context, $sqlClient);
        $gridExtendDao = new GridExtendDao($this->context, $sqlClient);
        $gridBaseDao = new GridBaseDao($this->context, $sqlClient);
        $gridWidgetExtendDao = new GridWidgetExtendDao ($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            // delete grid of container
            $gridVo = new GridVo ();
            $gridVo->containerId = $containerVo->id;
            // get all grid of container
            $gridList = $gridBaseDao->selectByFilter($gridVo);
            foreach ($gridList as $grid) {
                $gridExtendDao->deleteByFilter($gridVo);

                // delete grid_widget of grid
                $gridWidgetVo = new GridWidgetVo ();
                $gridWidgetVo->gridId = $grid->id;
                $gridWidgetExtendDao->deleteByFilter($gridWidgetVo);
            }

            // delete container
            $containerBaseDao->deleteByKey($containerVo);

            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function deleteContainerTemp()
    {
        $sqlClient = new SqlMapClient ($this->context);
        $containerBaseDao = new ContainerBaseDao ($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            $filter = new ContainerVo ();
            $filter->isTemp = 1;
            $containerList = $containerBaseDao->selectByFilter($filter);
            if (!empty ($containerList)) {
                foreach ($containerList as $containerVo) {
                    $this->deleteContainer($containerVo);
                }
            }

            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    /**
     * ***************************
     * FILTER
     * ***************************
     */
    public function getContainerByFilter(ContainerVo $filter)
    {
        return $this->containerExtendDao->getContainerByFilter($filter);
    }

    public function getCountByFilter(ContainerVo $filter)
    {
        return $this->containerExtendDao->getCountByFilter($filter);
    }
}