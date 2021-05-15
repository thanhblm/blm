<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\SlideVo;

class SlideExtendVo extends SlideVo
{
    public function __construct()
    {
        parent::__construct();
        $this->resultMap ["cr_by_name"] = "crByName";
        $this->resultMap ["md_by_name"] = "mdByName";
        $this->resultMap ["slide_group_name"] = "slideGroupName";
        $this->resultMap ["slide_group_code"] = "slideGroupCode";
        $this->resultMap ["slide_id"] = "slideId";

    }

    public $crByName;
    public $mdByName;
    public $crDateFrom;
    public $crDateTo;
    public $mdDateFrom;
    public $mdDateTo;
    public $slideGroupName;
    public $slideGroupCode;
    public $slideId;
}