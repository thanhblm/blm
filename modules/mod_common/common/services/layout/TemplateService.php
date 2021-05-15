<?php

namespace common\services\layout;

use common\persistence\base\dao\ContainerBaseDao;
use common\persistence\base\dao\TemplateBaseDao;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\TemplateVo;
use common\persistence\extend\dao\TemplateExtendDao;
use common\services\base\BaseService;
use core\database\SqlMapClient;

class TemplateService extends BaseService
{
    private $templateBaseDao;
    private $templateExtendDao;

    public function __construct()
    {
        $this->templateBaseDao = new TemplateBaseDao();
        $this->templateExtendDao = new TemplateExtendDao();
    }

    public function selectByKey(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->selectByKey($templateVo);
    }

    public function selectAll(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->selectAll($templateVo);
    }

    public function selectByFilter(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->selectByFilter($templateVo);
    }

    public function countByFilter(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->countByFilter($templateVo);
    }

    public function insertDynamic(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->insertDynamic($templateVo);
    }

    public function updateDynamicByKey(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->updateDynamicByKey($templateVo);
    }

    public function deleteByKey(TemplateVo $templateVo = null)
    {
        return $this->templateBaseDao->deleteByKey($templateVo);
    }

    /**
     * ***************************
     * ADVANCE
     * ***************************
     */
    public function addTemplateTemp()
    {
        $sqlClient = new SqlMapClient($this->context);
        $containerDao = new ContainerBaseDao($this->context, $sqlClient);
        $templateDao = new TemplateBaseDao($this->context, $sqlClient);
        $sqlClient->startTransaction();
        try {
            //new $headerId
            $filter = new ContainerVo ();
            $filter->pageId = 0;
            $filter->name = 'Header';
            $filter->position = 'header';
            $filter->class = '';
            $filter->isSystem = 0;
            $filter->isTemp = 1;
            $headerId = $containerDao->insertDynamic($filter);

            //new $footerId
            $filter = new ContainerVo ();
            $filter->pageId = 0;
            $filter->name = 'Footer';
            $filter->position = 'footer';
            $filter->class = '';
            $filter->isSystem = 0;
            $filter->isTemp = 1;
            $footerId = $containerDao->insertDynamic($filter);

            $filter = new TemplateVo ();
            $filter->name = '';
            $filter->headerId = $headerId;
            $filter->footerId = $footerId;
            $filter->isSystem = 0;
            $filter->isTemp = 1;
            $templateId = $templateDao->insertDynamic($filter);

            $sqlClient->endTransaction();

            return $templateId;
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function updateTemplate(TemplateVo $containerVo)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $templateBaseDao = new TemplateBaseDao($this->context, $sqlClient);
        $containerBaseDao = new ContainerBaseDao($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            //update container header
            $filter = new ContainerVo();
            $filter->id = $containerVo->headerId;
            $filter->isTemp = 0;
            $containerBaseDao->updateDynamicByKey($filter);

            //update container footer
            $filter = new ContainerVo();
            $filter->id = $containerVo->footerId;
            $filter->isTemp = 0;
            $containerBaseDao->updateDynamicByKey($filter);

            // update template
            $containerVo->isTemp = 0;
            $templateBaseDao->updateDynamicByKey($containerVo);

            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function copyTemplate(TemplateVo $templateVoSource)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $templateDao = new TemplateBaseDao ($this->context, $sqlClient);
        $containerBaseDao = new ContainerBaseDao($this->context, $sqlClient);
        $containerService = new ContainerService();
        $sqlClient->startTransaction();
        try {
            //copy $headerId container
            $filter = new ContainerVo ();
            $filter->id = $templateVoSource->headerId;
            $containerVo = $containerBaseDao->selectByKey($filter);
            $headerIdCopy = $containerService->copyContainer($containerVo);

            //copy $footerId container
            $filter = new ContainerVo ();
            $filter->id = $templateVoSource->footerId;
            $containerVo = $containerBaseDao->selectByKey($filter);
            $footerIdCopy = $containerService->copyContainer($containerVo);

            // copy template
            $templateVoCopy = $templateVoSource;
            $templateVoCopy->name = '';
            $templateVoCopy->headerId = $headerIdCopy;
            $templateVoCopy->footerId = $footerIdCopy;
            $templateVoCopy->isTemp = 1;
            $templateVoCopy->isSystem = 0;
            $templateIdCopy = $templateDao->insertDynamic($templateVoCopy);

            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
        return $templateIdCopy;
    }

    public function deleteTemplate(TemplateVo $containerVo)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $templateBaseDao = new TemplateBaseDao($this->context, $sqlClient);
        $containerService = new ContainerService();
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            //delete container header
            $filter = new ContainerVo();
            $filter->id = $containerVo->headerId;
            $containerService->deleteContainer($filter);

            //delete container footer
            $filter = new ContainerVo();
            $filter->id = $containerVo->footerId;
            $containerService->deleteContainer($filter);

            // delete template
            $templateBaseDao->deleteByKey($containerVo);

            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function deleteTemplateTemp()
    {
        $sqlClient = new SqlMapClient ($this->context);
        $templateBaseDao = new TemplateBaseDao ($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            $filter = new TemplateVo ();
            $filter->isTemp = 1;
            $templateList = $templateBaseDao->selectByFilter($filter);
            if (!empty ($templateList)) {
                foreach ($templateList as $templateVo) {
                    $this->deleteTemplate($templateVo);
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
    public function getTemplateByFilter(TemplateVo $filter)
    {
        return $this->templateExtendDao->getTemplateByFilter($filter);
    }

    public function getCountByFilter(TemplateVo $filter)
    {
        return $this->templateExtendDao->getCountByFilter($filter);
    }
}