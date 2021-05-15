<?php

namespace backend\controllers\slide;

use common\filter\slide\SlideFilter;
use common\model\SlideGroupMo;
use common\persistence\base\vo\SlideGroupVo;
use common\persistence\base\vo\SlideVo;
use common\services\slide\SlideService;
use common\services\slide_group\SlideGroupService;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\SessionUtil;

/**
 *
 * @author TANDT
 *
 */
class SlideController extends PagingController
{
    // Data request
    public $slideMo;
    public $encryptMo;
    // Data response
    public $slideVo;
    public $slideList;
    public $listSlideGroup;
    public $slideGroupMo;
    public $listFileUpload;
    public $slideGroupId;
    //
    private $slideService;
    private $slideGroupService;

    public function __construct()
    {
        parent::__construct();
        $this->slideVo = new SlideVo ();
        $this->slideMo = new SlideVo ();
        $this->filter = new SlideFilter ();
        $this->slideService = new SlideService ();
        $this->slideGroupMo = new SlideGroupMo ();
        $this->slideGroupService = new SlideGroupService ();
    }

    public function listView()
    {
        $this->detailSlideGroup();
        $this->getAllSlideGroup();
        $this->getList();
        return "success";
    }

    public function search()
    {
        $this->getAllSlideGroup();
        $this->detailSlideGroup();
        $this->getList();
        return "success";
    }

    public function addView()
    {
        $this->getAllSlideGroup();
        $this->detailSlideGroup();
        return "success";
    }

    public function add()
    {
        $this->validForm();
        $this->getAllSlideGroup();
        if ($this->hasActionErrors()) {
            return "error";
        }
        if ($this->hasFieldErrors()) {
            return "success";
        }
        $this->preapareData();
        $this->slideService->createSlide($this->slideVo);
        return "success";
    }

    public function confirmUpload()
    {
        $this->preapareData();
        $this->slideService->createSlide($this->slideVo, $_FILES ['fileUpload']);
        return "success";
    }

    public function editView()
    {
        $this->detail();
        $this->getAllSlideGroup();
        return "success";
    }

    public function edit()
    {
        $this->preapareData();
        $this->slideVo->crDate = null;
        $this->slideVo->crBy = null;
        $this->slideService->updateSlide($this->slideVo);
        return "success";
    }

    public function delView()
    {
        $this->detail();
        return "success";
    }

    public function del()
    {
        $this->slideService->deleteSlide($this->slideMo);
        return "success";
    }

    public function addSlideGroup()
    {
        $this->validFormQuickAddGroup();
        if (!$this->hasErrors()) {
            $this->preapareSlideGroupData();
            $this->slideGroupService->create($this->slideGroupMo);
        }
        $this->getAllSlideGroup();
        $this->detailSlideGroup();
        return "success";
    }

    private function validFormQuickAddGroup()
    {
        if (AppUtil::isEmptyString($this->slideGroupMo->name)) {
            $this->addFieldError("slideGroupMo[name]", Lang::get("Group Name can not be empty"));
        } else if (!StringUtil::validName($this->slideGroupMo->name)) {
            $this->addFieldError("slideGroupMo[name]", Lang::getWithFormat("{0} is Group Name not contain speacial character.", $this->slideGroupMo->name));
        }
    }

    private function preapareSlideGroupData()
    {
        $this->slideGroupMo->crBy = SessionUtil::get(ApplicationConfig::get("session.user.login.name"))->userId;
        $this->slideGroupMo->crDate = date('Y-m-d H:i:s');
        $this->slideGroupMo->mdDate = date('Y-m-d H:i:s');
        $this->slideGroupMo->mdBy = SessionUtil::get(ApplicationConfig::get("session.user.login.name"))->userId;
    }

    private function preapareData()
    {
        StringUtil::clearObject($this->slideMo);
        AppUtil::copyProperties($this->slideMo, $this->slideVo);
        $this->slideVo->crBy = SessionUtil::get(ApplicationConfig::get("session.user.login.name"))->userId;
        $this->slideVo->crDate = date('Y-m-d H:i:s');
        $this->slideVo->mdDate = date('Y-m-d H:i:s');
        $this->slideVo->mdBy = SessionUtil::get(ApplicationConfig::get("session.user.login.name"))->userId;
    }

    private function detailSlideGroup()
    {
        if (!AppUtil::isEmptyString($this->slideMo->slideGroupId)) {
            $slideGroupVo = new SlideGroupVo ();
            $slideGroupVo->id = $this->slideMo->slideGroupId;
            $slideGroupVo = $this->slideGroupService->selectByKey($slideGroupVo);
            $this->slideMo->slideGroupId = null;
            $this->filter->slideGroupName = $slideGroupVo->name;
        }
    }

    private function validForm()
    {
        if (AppUtil::isEmptyString($this->slideMo->slideGroupId)) {
            $this->addFieldError("slideMo[slideGroupId]", Lang::get("Please select Slide Group !"));
        } else {
            if (!is_int(intval($this->slideMo->slideGroupId))) {
                $this->addFieldError("slideMo[slideGroupId]", $this->userMo->slideGroupId . " " . Lang::get(" is not a valid Integer"));
            }
        }
        if (isset ($this->slideGroupMo->name)) {
            if (AppUtil::isEmptyString($this->slideGroupMo->name)) {
                $this->addFieldError("slideGroupMo[name]", Lang::get("Name can not be empty"));
            } else {
                if (!StringUtil::validName($this->slideGroupMo->name)) {
                    $this->addFieldError("slideGroupMo[name]", Lang::getWithFormat("{0} is Name not contain speacial character.", $this->slideGroupMo->name));
                }
            }
        }
    }

    private function detail()
    {
        if (AppUtil::isEmptyString($this->slideMo->id)) {
            $this->addFieldError("slideMo[id]", Lang::get("Slide id not valid."));
        } else {
            $this->slideMo = $this->slideService->selectBykey($this->slideMo);
        }
    }

    private function getAllSlideGroup()
    {
        $slideGroupSv = new SlideGroupService ();
        $slideGroupVo = new SlideGroupVo ();
        $slideGroupVo->status = "active";
        $this->listSlideGroup = $slideGroupSv->selectByFilter($slideGroupVo);
    }

    private function getList()
    {
        $filter = $this->buildFilter();
        $count = $this->slideService->searchCount($filter);
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        $slideVos = $this->slideService->search($filter);
        $paging->records = $slideVos;
        $this->slideList = $paging;
    }

    private function buildFilter()
    {
        $filter = $this->buildBaseFilter("id asc");
        $this->slideGroupId = $filter->slideGroupId;
        $this->slideGroupMo->id = $filter->slideGroupId;
        $this->slideMo->slideGroupId = $filter->slideGroupId;
        return $filter;
    }
}