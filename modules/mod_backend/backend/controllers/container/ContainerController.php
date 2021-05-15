<?php

namespace backend\controllers\container;

use common\helper\LayoutHelper;
use common\persistence\base\vo\ContainerVo;
use common\services\layout\ContainerService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\Lang;
use core\PagingController;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RouteUtil;
use common\persistence\extend\vo\WidgetContentExtendVo;
use common\services\layout\GridService;
use common\services\layout\GridWidgetService;
use common\services\layout\WidgetService;
use common\services\layout\WidgetCatService;
use common\services\layout\WidgetContentService;
use common\persistence\extend\vo\WidgetContentLangExtendVo;
use common\persistence\base\vo\GridVo;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\extend\dao\WidgetContentExtendDao;
use common\persistence\extend\dao\WidgetExtendDao;
use common\persistence\extend\dao\GridExtendDao;
use common\persistence\base\vo\WidgetContentVo;
use common\services\layout\PageService;
use common\persistence\base\vo\WidgetVo;

class ContainerController extends PagingController
{
    public $containerId;
    public $containerList;
    public $containerVo;
    public $gridId;
    public $widgetContentId;
    public $gridWidgetId;
    public $widgetContentVo;
    public $gridVo;
    public $gridWidgetVo;
    public $gridDataList;

    //ajax send data
    public $layoutData;
    public $ajaxData;
    public $widgetId;
    public $parentId;
    public $status;
    //ajax grid sortable
    public $gridList;
    public $gridIdSource;
    public $gridIdTarget;
    public $widgetContentIdSortable;
    public $gridWidgetListTarget;

    private $gridService;
    private $gridWidgetService;
    private $pageService;
    private $containerService;
    private $widgetService;
    private $widgetCatService;
    private $widgetContentService;
    private $gridExtendDao;
    private $widgetExtendDao;
    private $widgetContentExtendDao;

    public $widgetContentLanguages;
    public $viewPath;

    public function __construct()
    {
        parent::__construct();
        $this->containerVo = new ContainerVo ();
        $this->containerList = new Paging ();
        $this->pageTitle = ApplicationConfig::get("site.name") . " - Container Management";
        $this->filter = new ContainerVo ();

        $this->widgetContentVo = new WidgetContentExtendVo ();
        $this->gridVo = new GridVo();
        $this->gridWidgetVo = new GridWidgetVo();

        $this->pageService = new PageService();
        $this->containerService = new ContainerService ();
        $this->gridService = new GridService();
        $this->gridWidgetService = new GridWidgetService();
        $this->widgetService = new WidgetService();
        $this->widgetCatService = new WidgetCatService();
        $this->widgetContentService = new WidgetContentService();

        $this->gridExtendDao = new GridExtendDao();
        $this->widgetExtendDao = new WidgetExtendDao();
        $this->widgetContentExtendDao = new WidgetContentExtendDao();

        $this->widgetContentLanguages = new BaseArray (WidgetContentLangExtendVo::class);
        $this->viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) ['VIEW_PATH'];
    }

    public function listView()
    {
    	$this->containerService->deleteContainerTemp();
        $this->getContainerList();
        return "success";
    }
    public function search()
    {
        $this->getContainerList();
        return "success";
    }

    public function addView()
    {
        if (!$this->containerId) {
            $this->containerId = $this->containerService->addContainerTemp();
        }
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);
        return "success";
    }
    public function add()
    {
        $this->validate(true);
        if ($this->hasErrors()) {
            return "success";
        }
        // Set some initial values.
        $this->containerVo->crDate = date('Y-m-d H:i:s');
        $this->containerVo->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->containerVo->mdDate = date('Y-m-d H:i:s');
        $this->containerVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        // set isTemp
        $this->containerVo->isTemp = 0;
        // Save to the database.
        $this->containerService->updateDynamicByKey($this->containerVo);
        $this->addExtraData ( "containerId", $this->containerVo->id );
        return "success";
    }

    public function editView()
    {
        // check containerId
        if (AppUtil::isEmptyString($this->containerId)) {
            \DatoLogUtil::error("No containerId for editing");
            return 'error';
        }
        $this->getContainerVo();
        if (!$this->containerVo) {
            \DatoLogUtil::error("No found container with containerId = {$this->containerId}");
            return 'error';
        }
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);
//        var_dump($this->layoutData);

        return "success";
    }
    public function edit()
    {
        $this->validate(false);
        if ($this->hasErrors()) {
            return "success";
        }
        // Save to the database.
        $this->containerVo->mdDate = date('Y-m-d H:i:s');
        $this->containerVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->containerVo->isTemp = 0;
		$this->containerService->updateDynamicByKey($this->containerVo);
        return "success";
    }

    public function copy()
    {
        // check containerId
        if (AppUtil::isEmptyString($this->containerId)) {
            \DatoLogUtil::error("No containerId for editing");
            return 'error';
        }
        $this->getContainerVo();
        if (!$this->containerVo) {
            \DatoLogUtil::error("No found container with containerId = {$this->containerId}");
            return 'error';
        }

        // copy container
        $containerIdCopy = $this->containerService->copyContainer($this->containerVo);
        $urlRedirect = ActionUtil::getFullPathAlias("admin/container/edit/view?containerId=$containerIdCopy");
        header("location: $urlRedirect");
        return "success";
    }

    public function delView()
    {
        if (AppUtil::isEmptyString($this->containerId)) {
            throw new \Exception ("No id for deleting");
        }
        $this->getContainerVo();
        return "success";
    }
    public function del()
    {
        if (AppUtil::isEmptyString($this->containerId)) {
            throw new \Exception ("No id for deleting");
        }

        $filter = new ContainerVo ();
        $filter->id = $this->containerId;
        $this->containerVo = $this->containerService->selectByKey($filter);

        $validate = true;
        if ($this->containerVo->isSystem) {
            $validate = false;
            $this->addFieldError('errorMessage', Lang::get('You not delete system container'));
        }

        if ($validate) {
            $this->containerService->deleteContainer($this->containerVo);
        }
        return "success";
    }

    protected function validate($isAdd = true)
    {
        $errorMessage = array();
        // check required
        if (AppUtil::isEmptyString($this->containerVo->name)) {
//            $errorMessage ["containerVo[name]"] = "Name is required";
        }
        else {
            // check exist
            if ($isAdd) {
                $containerVo = new ContainerVo ();
                $containerVo->isTemp = 0;
                $containerVos = $this->containerService->selectByFilter($containerVo);
                foreach ($containerVos as $containerInfo) {
                	if ($containerInfo->name !== '' & $containerInfo->name == $this->containerVo->name) {
                		$errorMessage ["containerVo[name]"] = "Name is exist";
                		break;
                	}
                }
            } else { // edit case
                $filter = new ContainerVo ();
                $filter->id = $this->containerVo->id;
                $containerOld = $this->containerService->selectByKey($filter);

                $filter = new ContainerVo ();
                $filter->name = $this->containerVo->name;
                $filter->isTemp = 0;
                $containerList = $this->containerService->selectByFilter($filter);
                if (count($containerList) > 0 & $containerOld->name != $this->containerVo->name) {
                    $errorMessage ["containerVo[name]"] = "Name is exist";
                }
            }
        }

        if (!empty ($errorMessage)) {
            $this->addFieldError('errorMessage', json_encode($errorMessage));
        }
    }

    protected function getContainerList()
    {
        $filter = $this->buildFilter();
        // check isTemp
        $filter->isTemp = 0;
        // Get total records of containerList.
        $count = $this->containerService->getCountByFilter($filter);
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        // Get containerList.
        $containerVos = $this->containerService->getContainerByFilter($filter);
        $paging->records = $containerVos;
        $this->containerList = $paging;
    }

    protected function getContainerVo()
    {
        $containerVo = new ContainerVo ();
        $containerVo->id = $this->containerId;
        $this->containerVo = $this->containerService->selectByKey($containerVo);
    }

    protected function buildFilter()
    {
        return $this->buildBaseFilter("id asc");
    }

    /**
     * ****************************************************************
     * LAYOUT ACTION
     * ****************************************************************
     */
    private function getWidgetContentLanguages($widgetContentId = -1)
    {
        $filter = new WidgetContentLangExtendVo ();
        $filter->widgetContentId = $widgetContentId;
        $widgetContentLangVos = $this->widgetContentService->getLangsByWidgetContentId($filter);
        $result = new BaseArray (WidgetContentLangExtendVo::class);
        foreach ($widgetContentLangVos as $widgetContentLangVo) {
            $widgetContentLangVo->widgetContentId = $widgetContentId;
            $widgetContentLangVo->languageCode = $widgetContentLangVo->code;
            $widgetContentLangVo->setting = json_decode($widgetContentLangVo->setting, true);
            $result->add($widgetContentLangVo);
        }
        $this->widgetContentLanguages = $result;
    }

    public function refreshLayout()
    {
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);
        return 'success';
    }

    /**
     * ******************************************
     * widgetContent action
     * ******************************************
     */
    public function widgetContentAddView()
    {
        // get $gridInfo
        $gridVo = new GridVo ();
        $gridVo->id = $this->gridId;
        $this->gridVo = $this->gridService->selectByKey($gridVo);

        // get $widgetGroup group $widgetExtendVo by widgetCatId
        $widgetExtendVoList = $this->widgetExtendDao->getWidgetList();
        $widgetGroup = array();
        foreach ($widgetExtendVoList as $v) {
            $widgetGroup [$v->widgetCatId] ['name'] = $v->widgetCatName;
            $widgetGroup [$v->widgetCatId] ['data'] [] = $v;
        }

        // get $widgetContentGroup group $widgetContentExtendVo by widgetCatId
        $widgetContentExtendVoList = $this->widgetContentService->getWidgetContentList();
        $widgetContentGroup = array();
        foreach ($widgetContentExtendVoList as $v) {
            $widgetContentGroup [$v->widgetCatId] ['name'] = $v->widgetCatName;
            $widgetContentGroup [$v->widgetCatId] ['data'] [] = $v;
        }

        $this->widgetContentVo = new WidgetContentVo ();

        // get $widgetContentDefault
        $filter = new WidgetVo();
        $filter->id = 1;
        $widgetDefault = $this->widgetService->selectByKey($filter);
        $widgetContentDefault = new WidgetContentExtendVo();
        $widgetContentDefault->widgetId = $widgetDefault->id;
        $widgetContentDefault->widgetName = $widgetDefault->name;
        $widgetContentDefault->widgetController = $widgetDefault->controller;

        // send data
        $this->getWidgetContentLanguages();
        $this->ajaxData = array(
            'widgetGroup' => $widgetGroup,
            'widgetContentGroup' => $widgetContentGroup,
            'widgetContentDefault' => $widgetContentDefault
        );

        return 'success';
    }
    public function widgetContentExistAdd()
    {
        // validate widgetContent is exist in grid
        $validate = true;
        $gridWidgetVo = new GridWidgetVo ();
        $gridWidgetVo->gridId = $this->gridId;
        $gridWidgetVo->widgetContentId = $this->widgetContentId;
        $gridWidgetVos = $this->gridWidgetService->selectByFilter($gridWidgetVo);
        if ($gridWidgetVos) {
            $validate = false;
            $this->addFieldError('errorMessage', Lang::get('This widget already exists in this grid'));
        }
        if ($validate) {
            $this->gridWidgetService->insertDynamic($gridWidgetVo);
        }
        return 'success';
    }
    public function widgetContentAdd()
    {
        // validate widgetContentVo->name
        $errorMessage = array();
        // check required
        if (AppUtil::isEmptyString($this->widgetContentVo->name)) {
            $errorMessage ["widgetContentVo[name]"] = "Name is required";
        } else {
            // check exist
            $filter = new WidgetContentVo ();
            $filter->name = $this->widgetContentVo->name;
            $widgetContentList = $this->widgetContentService->selectByFilter($filter);
            if ($widgetContentList) {
                $errorMessage ["widgetContentVo[name]"] = "Name is exist";
            }
        }

        if (!empty ($errorMessage)) {
            $this->addFieldError('errorMessage', json_encode($errorMessage));
        } else {
            $this->widgetContentVo->setting = json_encode($this->widgetContentVo->setting);
            $this->widgetContentService->createWidgetContent($this->widgetContentVo, $this->widgetContentLanguages, $this->gridId);
        }
        return 'success';
    }

    public function widgetContentSelectAdd()
    {
        // get $widgetGroup group $widgetExtendVo by widgetCatId
        $widgetExtendVoList = $this->widgetExtendDao->getWidgetList();
        $widgetGroup = array();
        foreach ($widgetExtendVoList as $v) {
            $widgetGroup [$v->widgetCatId] ['name'] = $v->widgetCatName;
            $widgetGroup [$v->widgetCatId] ['data'] [] = $v;
        }

        // get $widgetContentGroup group $widgetContentExtendVo by widgetCatId
        $widgetContentExtendVoList = $this->widgetContentService->getWidgetContentList();
        $widgetContentGroup = array();
        foreach ($widgetContentExtendVoList as $v) {
            $widgetContentGroup [$v->widgetCatId] ['name'] = $v->widgetCatName;
            $widgetContentGroup [$v->widgetCatId] ['data'] [] = $v;
        }

        $this->widgetContentVo = new WidgetContentVo ();

        // get $widgetContentDefault
        $filter = new WidgetVo ();
        $filter->id = $this->widgetId;
        $widgetDefault = $this->widgetService->selectByKey($filter);
        $widgetContentDefault = new WidgetContentExtendVo ();
        $widgetContentDefault->widgetId = $widgetDefault->id;
        $widgetContentDefault->widgetName = $widgetDefault->name;
        $widgetContentDefault->widgetController = $widgetDefault->controller;

        // send data
        $this->getWidgetContentLanguages();
        $this->ajaxData = array(
            'widgetGroup' => $widgetGroup,
            'widgetContentGroup' => $widgetContentGroup,
            'widgetContentDefault' => $widgetContentDefault
        );

        return 'success';
    }

    public function widgetContentEditView()
    {
        // get data
        $widgetContentExtendVo = new WidgetContentExtendVo ();
        $widgetContentExtendVo->id = $this->widgetContentId;
        // send data
        $this->widgetContentVo = $this->widgetContentService->getWidgetContentInfo($widgetContentExtendVo);
        $this->getWidgetContentLanguages($this->widgetContentId);
        return 'success';
    }
    public function widgetContentEdit()
    {
        // validate widgetContentVo->name
        $errorMessage = array();
        // check required
        if (AppUtil::isEmptyString($this->widgetContentVo->name)) {
            $errorMessage ["widgetContentVo[name]"] = "Name is required";
        } else {
            // check exist
            $filter = new WidgetContentVo ();
            $filter->id = $this->widgetContentVo->id;
            $widgetContentOld = $this->widgetContentService->selectByKey($filter);

            $filter = new WidgetContentVo ();
            $filter->name = $this->widgetContentVo->name;
            $widgetContentList = $this->widgetContentService->selectByFilter($filter);
            if (count($widgetContentList) > 0 & $widgetContentOld->name != $this->widgetContentVo->name) {
                $errorMessage ["widgetContentVo[name]"] = "Name is exist";
            }
        }

        if (!empty ($errorMessage)) {
            $this->addFieldError('errorMessage', json_encode($errorMessage));
        } else {
            $this->widgetContentVo->setting = json_encode($this->widgetContentVo->setting);
            $this->widgetContentService->updateWidgetContent($this->widgetContentVo, $this->widgetContentLanguages);
        }
        return 'success';
    }

    public function gridWidgetEditStatus()
    {
        $filter = new GridWidgetVo ();
        $filter->gridId = $this->gridId;
        $filter->widgetContentId = $this->widgetContentId;
        $gridWidgetList = $this->gridWidgetService->selectByFilter($filter);
        if ($gridWidgetList) {
            $gridWidgetInfo = $gridWidgetList [0];
            $gridWidgetInfo->status = ($this->status == 'active') ? 'deactive' : 'active';
            $this->gridWidgetService->updateDynamicByKey($gridWidgetInfo);
        }

        // refreshLayout
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);

        return 'success';
    }

    public function widgetContentDelete()
    {
        $filter = new WidgetContentVo ();
        $filter->id = $this->widgetContentId;
        $this->widgetContentVo = $this->widgetContentService->selectByKey($filter);
        $this->getWidgetContentLanguages($this->widgetContentId);
        $this->widgetContentService->deleteWidgetContent($this->widgetContentVo, $this->widgetContentLanguages);

        // refreshLayout
        $this->refreshLayout();

        return 'success';
    }
    public function gridWidgetDeleteView()
    {
        // send data
        $widgetContentVo = new WidgetContentVo ();
        $widgetContentVo->id = $this->widgetContentId;
        $this->widgetContentVo = $this->widgetContentService->selectByKey($widgetContentVo);

        $gridWidgetVo = new GridWidgetVo ();
        $gridWidgetVo->id = $this->gridWidgetId;
        $this->gridWidgetVo = $this->gridWidgetService->selectByKey($gridWidgetVo);
        return 'success';
    }
    public function gridWidgetDelete()
    {
        $this->gridWidgetService->deleteByKey($this->gridWidgetVo);
        return 'success';
    }

    /**
     * ******************************************
     * grid action
     * ******************************************
     */
    public function gridAddView()
    {
        //get all grid from
        $gridService = new GridService();
        $gridVo = new GridVo();
        $gridVo->containerId = $this->containerId;
        $gridVo->parentId = $this->parentId;
        $gridList = $gridService->selectByFilter($gridVo);

        $this->gridDataList = array();
        foreach ($gridList as $v){
            $this->gridDataList[$v->order] = "#{$v->id}";
        }

        return 'success';
    }

    public function gridAdd()
    {
        // update data
        $this->gridService->insertDynamic($this->gridVo);
        return 'success';
    }

    public function gridEditView()
    {
        // send data
        $gridVo = new GridVo ();
        $gridVo->id = $this->gridId;
        $this->gridVo = $this->gridService->selectByKey($gridVo);
        return 'success';
    }

    public function gridEdit()
    {
        // update data
        $this->gridService->updateDynamicByKey($this->gridVo);
        return 'success';
    }

    public function gridEditStatus()
    {
        // update data
        $gridVo = new GridVo ();
        $gridVo->id = $this->gridId;
        $gridVo->status = ($this->status == 'active') ? 'deactive' : 'active';
        $this->gridService->updateDynamicByKey($gridVo);
        // refreshLayout
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);
        return 'success';
    }

    public function gridDeleteView()
    {
        // send data
        $filter = new GridVo ();
        $filter->id = $this->gridId;
        $this->gridVo = $this->gridService->selectByKey($filter);
        return 'success';
    }

    public function gridDelete()
    {
        $this->gridService->gridDelete($this->gridVo);
        return 'success';
    }

    /**
     * ******************************************
     * sortable action
     * ******************************************
     */
    public function gridSortable()
    {
        // get data
        $gridList = $this->gridList;

        // update gridId and order
        $this->gridService->gridSortable($gridList);

        // refreshLayout
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);

        return 'success';
    }

    public function gridWidgetSortable()
    {
        // get data
        $gridIdSource = $this->gridIdSource;
        $gridIdTarget = $this->gridIdTarget;
        $widgetContentIdSortable = $this->widgetContentIdSortable;
        $gridWidgetListTarget = $this->gridWidgetListTarget;

        // check $gridWidget exist in $gridIdTarget
        $validate = true;
        if ($gridIdSource != $gridIdTarget) {
            // get all gridWidget in $gridIdTarget
            $filter = new GridWidgetVo ();
            $filter->gridId = $gridIdTarget;
            $gridWidgetTargetList = $this->gridWidgetService->selectByFilter($filter);

            // get array widgetContentId from $gridWidgetListTarget
            $widgetContentIdsTarget = array();
            foreach ($gridWidgetTargetList as $v) {
                $widgetContentIdsTarget [$v->widgetContentId] = $v->widgetContentId;
            }

            if (isset ($widgetContentIdsTarget [$widgetContentIdSortable])) {
                $validate = false;
                $this->addActionError(Lang::get('This widget already exists in this grid'));
            }
        }

        if ($validate) {
            // update gridId and order
            $this->gridService->gridWidgetSortable($gridIdTarget, $gridWidgetListTarget);
        }

        // refreshLayout
        $this->getContainerVo();
        $this->layoutData = LayoutHelper::getLayoutDataByContainerId($this->containerId);

        return 'success';
    }
}