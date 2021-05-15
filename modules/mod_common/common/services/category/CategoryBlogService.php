<?php

namespace common\services\category;

use common\persistence\base\vo\CategoryBlogLangVo;
use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\extend\dao\CategoryBlogExtendDao;
use common\persistence\extend\dao\CategoryBlogLangExtendDao;
use common\persistence\extend\dao\SeoInfoLangExtendDao;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\persistence\extend\vo\CategoryBlogLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class CategoryBlogService extends BaseService
{
    private $contactDao;
    private $categoryDao;

    public function __construct()
    {
        $this->contactDao = new CategoryBlogExtendDao ();
        $this->categoryDao = new CategoryBlogExtendDao ();
    }

    public function getAll()
    {
        return $this->contactDao->selectAll();
    }

    public function selectByFilter(CategoryBlogExtendVo $filter)
    {
        return $this->contactDao->selectByFilter($filter);
    }

    public function getByFilter(CategoryBlogExtendVo $filter)
    {
        return $this->contactDao->getByFilter($filter);
    }

    public function countByFilter(CategoryBlogExtendVo $filter)
    {
        return $this->contactDao->countByFilter($filter);
    }

    public function add(CategoryBlogVo $contactVo)
    {
        return $this->contactDao->insertDynamic($contactVo);
    }

    public function update(CategoryBlogVo $contactVo)
    {
        return $this->contactDao->updateDynamicByKey($contactVo);
    }

    public function delete(CategoryBlogVo $contactVo)
    {
        return $this->contactDao->deleteByKey($contactVo);
    }

    public function selectByKey(CategoryBlogVo $categoryVo)
    {
        return $this->contactDao->selectByKey($categoryVo);
    }

    // CategoryBlog manager
    public function getCategoryBlogByFilter(CategoryBlogExtendVo $categoryVo = null)
    {
        return $this->categoryDao->getByFilter($categoryVo);
    }

    public function getCategoryBlogByKey(CategoryBlogVo $categoryVo = null)
    {
        return $this->categoryDao->selectByKey($categoryVo);
    }

    public function countCategoryBlogByFilter(CategoryBlogVo $categoryVo = null)
    {
        return $this->categoryDao->getCountByFilter($categoryVo);
    }

    public function createCategoryBlog(CategoryBlogVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs)
    {
        $sqlClient = new SqlMapClient($this->context);
        $categoryDao = new CategoryBlogExtendDao ($this->context, $sqlClient);
        $categoryLangDao = new CategoryBlogLangExtendDao($this->context, $sqlClient);
        $seoInfoLangDao = new SeoInfoLangExtendDao($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            $categoryVo->id = null;
            // Add to category lang table.
            $categoryId = $categoryDao->insertDynamic($categoryVo);
            // Add category lang langs.
            foreach ($categoryLangs->getArray() as $lang) {
                $lang->categoryBlogId = $categoryId;
                $categoryLangDao->insertDynamic($lang);
            }
            foreach ($seoInfoLangs->getArray() as $seoInfoVo) {
                // Add new category seo info lang .
                $seoInfoVo->itemId = $categoryId;
                $seoInfoVo->type = "category_blog";
                $seoInfoLangDao->insertDynamic($seoInfoVo);
            }
            // Commit transaction.
            $sqlClient->endTransaction();
            return $categoryId;
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function updateCategoryBlog(CategoryBlogVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $categoryDao = new CategoryBlogExtendDao ($this->context, $sqlClient);
        $categoryLangDao = new CategoryBlogLangExtendDao ($this->context, $sqlClient);
        $seoInfoLangDao = new SeoInfoLangExtendDao ($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            // Update to category table.
            $categoryDao->updateDynamicByKey($categoryVo);
            // Remove all category lang of this category
            // and insert new category lang.
            if (count($categoryLangs->getArray() > 0)) {
                foreach ($categoryLangs->getArray() as $lang) {
                    // Delete category lang.
                    if (!AppUtil::isEmptyString($lang->categoryBlogId)) {
                        $categoryLangDao->deleteByKey($lang);
                    }
                    // Add new category lang.
                    $categoryLangDao->insertDynamic($lang);
                }
            }
            if (count($seoInfoLangs->getArray() > 0)) {
                foreach ($seoInfoLangs->getArray() as $seoInfoVo) {
                    // Delete category lang.
                    $seoInfoLangDao->deleteByKey($seoInfoVo);
                    // Add new category lang.
                    $seoInfoLangDao->insertDynamic($seoInfoVo);
                }
            }
            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function deleteCategoryBlog(CategoryBlogVo $categoryVo = null)
    {
        $sqlClient = new SqlMapClient ($this->context);
        $categoryDao = new CategoryBlogExtendDao ($this->context, $sqlClient);
        $categoryLangDao = new CategoryBlogLangExtendDao ($this->context, $sqlClient);
        // Begin transaction.
        $sqlClient->startTransaction();
        try {
            $filter = new CategoryBlogLangVo();
            $filter->categoryId = $categoryVo->id;
            $categoryLangs = $categoryLangDao->selectByFilter($filter);
            // Delete category lang.
            foreach ($categoryLangs as $lang) {
                $categoryLangDao->deleteByKey($lang);
            }
            $categoryDao->deleteByKey($categoryVo);
            // Commit transaction.
            $sqlClient->endTransaction();
        } catch (\Exception $e) {
            $sqlClient->rollback();
            throw $e;
        }
    }

    public function getLangsByCategoryBlogId(CategoryBlogLangExtendVo $filter)
    {
        $categoryLangDao = new CategoryBlogLangExtendDao ();
        return $categoryLangDao->getLangsByCategoryBlogId($filter);
    }

    public function getSeoInfosByCategoryBlogId(SeoInfoLangExtendVo $filter)
    {
        $seoInfoDao = new SeoInfoLangExtendDao ();
        return $seoInfoDao->getLangsByKey($filter);
    }

    public function getCategoryLastChild($id, &$categories = array())
    {
        $categoryFilter = new CategoryBlogExtendVo();
        $categorySv = new CategoryBlogService();
        $categoryFilter->parentId = $id;
        $categoryFilter->status = 'active';
        $categoryVos = $categorySv->selectByFilter($categoryFilter);
        if (count($categoryVos) === 0) {
            array_push($categories, $id);
        } else {
            foreach ($categoryVos as $categoryVo) {
                $categoryId = $categoryVo->id;
                $this->getCategoryLastChild($categoryId, $categories);
            }
        }
    }
    // End CategoryBlog manager
}