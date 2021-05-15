<?php

namespace frontend\controllers\about_us;

use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\BlogHomeExtendVo;
use common\services\blog\BlogHomeService;
use frontend\controllers\blog\BlogController;
use mysql_xdevapi\Exception;

class AboutUsController extends BlogController
{
    public $blogTag;

    public function __construct()
    {
        parent::__construct();
    }

    public function show()
    {
        $this->blogTag = 'gioi thieu';
        $this->getBlog();
        return "success";
    }

    protected function getBlog()
    {
        try {
            $blogService = new BlogHomeService();
            $filter = new BlogHomeExtendVo();
            $filter->tag = $this->blogTag;
            $filter->languageCode = $this->languageCode;
            $filter->regionId = $this->regionId;
            $blogVos = $blogService->getBlogHomeByFilter($filter);
            $this->blog = $blogVos[0];

            $filter = new SeoInfoLangVo ();
            $filter->itemId = $this->blog->id;
            $filter->type = 'blog';
            $filter->languageCode = $this->languageCode;
            $seoInfoLangVos = $this->seoInfoLangService->getSeoInfoLangByBlog($filter);
            if (empty ($seoInfoLangVos)) {
                return null;
            }
            $this->seoInfoVo = $seoInfoLangVos [0];
        } catch (Exception $exception) {
            \DatoLogUtil::error($exception->getMessage(), $exception);
        }

    }
}