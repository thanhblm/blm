<?php

namespace backend\controllers\template;

use common\persistence\base\vo\TemplateVo;
use common\services\layout\TemplateService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\ActionUtil;
use core\utils\AppUtil;

class TemplateController extends PagingController
{
    public $templateId;
    public $templateList;
    public $templateVo;
    public $templateService;

    public function __construct()
    {
        parent::__construct();
        $this->templateVo = new TemplateVo ();
        $this->templateList = new Paging ();
        $this->pageTitle = ApplicationConfig::get("site.name") . " - Template Management";
        $this->filter = new TemplateVo ();
        $this->templateService = new TemplateService ();
    }

    public function listView()
    {
        $this->templateService->deleteTemplateTemp();
        $this->getTemplateList();
        return "success";
    }
    public function search()
    {
        $this->getTemplateList();
        return "success";
    }

    public function addView()
    {
        if (!$this->templateId) {
            $this->templateId = $this->templateService->addTemplateTemp();
        }
        $this->getTemplateVo();
        return "success";
    }
    public function add()
    {
        $this->validate(true);
        if ($this->hasErrors()) {
            return "success";
        }
        // Set some initial values.
        $this->templateVo->crDate = date('Y-m-d H:i:s');
        $this->templateVo->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->templateVo->mdDate = date('Y-m-d H:i:s');
        $this->templateVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->templateService->updateTemplate($this->templateVo);
        $this->addExtraData ( "templateId", $this->templateVo->id );
        return "success";
    }

    public function editView()
    {
        // check templateId
        if (AppUtil::isEmptyString($this->templateId)) {
            \DatoLogUtil::error("No templateId for editing");
            return 'error';
        }
        $this->getTemplateVo();
        if (!$this->templateVo) {
            \DatoLogUtil::error("No found template with templateId = {$this->templateId}");
            return 'error';
        }
        return "success";
    }
    public function edit()
    {
        $this->validate(false);
        if ($this->hasErrors()) {
            return "success";
        }
        // Save to the database.
        $this->templateVo->mdDate = date('Y-m-d H:i:s');
        $this->templateVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->templateService->updateTemplate($this->templateVo);
        return "success";
    }

    public function copy()
    {
        // check templateId
        if (AppUtil::isEmptyString($this->templateId)) {
            \DatoLogUtil::error("No templateId for editing");
            return 'error';
        }
        $this->getTemplateVo();
        if (!$this->templateVo) {
            \DatoLogUtil::error("No found template with templateId = {$this->templateId}");
            return 'error';
        }

        // copy template
        $templateIdCopy = $this->templateService->copyTemplate($this->templateVo);
        $urlRedirect = ActionUtil::getFullPathAlias("admin/template/edit/view?templateId=$templateIdCopy");
        header("location: $urlRedirect");
        return "success";
    }

    public function delView()
    {
        if (AppUtil::isEmptyString($this->templateId)) {
            throw new \Exception ("No id for deleting");
        }
        $this->getTemplateVo();
        return "success";
    }
    public function del()
    {
        if (AppUtil::isEmptyString($this->templateId)) {
            throw new \Exception ("No id for deleting");
        }

        $filter = new TemplateVo ();
        $filter->id = $this->templateId;
        $this->templateVo = $this->templateService->selectByKey($filter);

        $validate = true;
        if ($this->templateVo->isSystem) {
            $validate = false;
            $this->addFieldError('errorMessage', Lang::get('You not delete system template'));
        }

        if ($validate) {
            $this->templateService->deleteTemplate($this->templateVo);
        }
        return "success";
    }

    protected function validate($isAdd = true)
    {
        $errorMessage = array();
        // check required
        if (AppUtil::isEmptyString($this->templateVo->name)) {
            $errorMessage ["templateVo[name]"] = "Name is required";
        }
        else {
            // check exist
            if ($isAdd) {
                $templateVo = new TemplateVo ();
                $templateVo->isTemp = 0;
            	$templateVos = $this->templateService->selectByFilter($templateVo);
                foreach ($templateVos as $templateInfo) {
                    if ($templateInfo->name !== '' & $templateInfo->name == $this->templateVo->name) {
                        $errorMessage ["templateVo[name]"] = "Name is exist";
                        break;
                    }
                }
            } else { // edit case
                $filter = new TemplateVo ();
                $filter->id = $this->templateVo->id;
                $templateOld = $this->templateService->selectByKey($filter);

                $filter = new TemplateVo ();
                $filter->name = $this->templateVo->name;
                $filter->isTemp = 0;
                $templateList = $this->templateService->selectByFilter($filter);
                if (count($templateList) > 0 & $templateOld->name != $this->templateVo->name) {
                    $errorMessage ["templateVo[name]"] = "Name is exist";
                }
            }
        }

        if (!empty ($errorMessage)) {
            $this->addFieldError('errorMessage', json_encode($errorMessage));
        }
    }

    protected function getTemplateList()
    {
        $filter = $this->buildFilter();
        // check isTemp
        $filter->isTemp = 0;
        // Get total records of templateList.
        $count = $this->templateService->getCountByFilter($filter);
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        // Get templateList.
        $templateVos = $this->templateService->getTemplateByFilter($filter);
        $paging->records = $templateVos;
        $this->templateList = $paging;
    }

    protected function getTemplateVo()
    {
        $templateVo = new TemplateVo ();
        $templateVo->id = $this->templateId;
        $this->templateVo = $this->templateService->selectByKey($templateVo);
    }

    protected function buildFilter()
    {
        return $this->buildBaseFilter("id asc");
    }
}