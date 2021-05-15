<?php

namespace common\services\blog;

use common\persistence\base\dao\BlogBaseDao;
use common\persistence\base\dao\BlogLangBaseDao;
use common\persistence\base\dao\BlogRegionBaseDao;
use common\persistence\base\dao\BlogRelationBaseDao;
use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\BlogVo;
use common\persistence\base\vo\CategoryBlogLangVo;
use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\dao\BlogExtendDao;
use common\persistence\extend\dao\BlogLangExtendDao;
use common\persistence\extend\dao\BlogRegionExtendDao;
use common\persistence\extend\dao\BlogRelationExtendDao;
use common\persistence\extend\dao\BlogSeoExtendDao;
use common\persistence\extend\dao\CategoryBlogExtendDao;
use common\persistence\extend\dao\CategoryBlogLangExtendDao;
use common\persistence\extend\dao\SeoInfoLangExtendDao;
use common\persistence\extend\vo\BlogLangExtendVo;
use common\persistence\extend\vo\BlogRegionExtendVo;
use common\persistence\extend\vo\BlogRelationExtendVo;
use common\persistence\extend\vo\BlogSeoExtendVo;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\persistence\extend\vo\CategoryBlogLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\base\BaseService;
use common\services\category\CategoryBlogService;
use common\services\category\CategoryService;
use common\utils\StringUtil;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class BlogService extends BaseService {
	private $blogDao;
	private $categoryDao;

	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->blogDao = new BlogExtendDao();
		$this->categoryDao = new CategoryBlogExtendDao ();
	}
	public function getAllCategories() {
		return $this->categoryDao->selectAll ();
	}
	public function getAllBlogs() {
		return $this->blogDao->selectAll ();
	}
	public function getBlogsByCatId($catId) {
		$filter = new BlogVo ();
		$filter->categoryId = $catId;
		return $this->blogDao->selectByFilter ( $filter );
	}
	public function getBlogByFilter(BlogVo $blogVo = null) {
		return $this->blogDao->getBlogByFilter( $blogVo );
	}
	public function getBlogByKey(BlogVo $blogVo = null) {
		return $this->blogDao->selectByKey ( $blogVo );
	}
	public function countBlogByFilter(BlogVo $blogVo) {
		return $this->blogDao->countBlogByFilter( $blogVo );
	}
	public function insertAll(BlogVo $blog, BaseArray $blogLangs, BaseArray $blogRelations, BaseArray $blogRegions, BaseArray $blogSeos) {
		$sqlClient = new SqlMapClient ( $this->context );
		$blogBaseDao = new BlogBaseDao ( $this->context, $sqlClient );
		$blogLangDao = new BlogLangBaseDao ( $this->context, $sqlClient );
		$blogRelationDao = new BlogRelationBaseDao ( $this->context, $sqlClient );
		$blogRegionDao = new BlogRegionBaseDao ( $this->context, $sqlClient );
		$seoInfoLangDao = new SeoInfoLangBaseDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			$blog->crDate = date ( "Y-m-d" );
			$blog->mdDate = date ( "Y-m-d" );
			if(is_null($blog->featured)){
				$blog->featured = 'no';
			}
			$blogId = $blogBaseDao->insertDynamic ( $blog );
			// Insert Blog Lang
			foreach ( $blogLangs->getArray () as $blogLangVo ) {
				$blogLangVo->blogId = $blogId;
				$blogLangDao->insertDynamic ( $blogLangVo );
			}
			// Insert Blog Relation
			if (count ( $blogRelations->getArray () ) > 0) {
				foreach ( $blogRelations->getArray () as $blogRelationVo ) {
					$blogRelationVo->blogId = $blogId;
					$blogRelationDao->insertDynamic ( $blogRelationVo );
				}
			}
			// Insert Blog Region
			if (count ( $blogRegions->getArray () ) > 0) {
				foreach ( $blogRegions->getArray () as $blogRegionVo ) {
					if ($blogRegionVo->select == 1) {
						$blogRegionVo->blogId = $blogId;
						$blogRegionDao->insertDynamic ( $blogRegionVo );
					}
				}
			}
			// Insert seo
			foreach ( $blogSeos->getArray () as $seoVo ) {
				$seoVo->itemId = $blogId;
				$seoVo->type = "blog";
				$seoInfoLangDao->insertDynamic ( $seoVo );
			}
			// Commit transaction.
			$sqlClient->endTransaction ();
			return $blogId;
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function updateAll(BlogVo $blog, BaseArray $blogLangs, BaseArray $blogRelations, BaseArray $blogRegions, BaseArray $blogSeos) {
		$sqlClient = new SqlMapClient ( $this->context );
		$blogBaseDao = new BlogBaseDao ( $this->context, $sqlClient );
		$blogLangDao = new BlogLangBaseDao ( $this->context, $sqlClient );
		$blogRelationDao = new BlogRelationBaseDao ( $this->context, $sqlClient );
		$blogRelationExtendDao = new BlogRelationExtendDao ( $this->context, $sqlClient );
		$blogRegionExtendDao = new BlogRegionExtendDao ( $this->context, $sqlClient );
		$blogSeoExtendDao = new BlogSeoExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			if(is_null($blog->featured)){
				$blog->featured = 'no';
			}
			$blog->mdDate = date ( "Y-m-d" );
			$blogBaseDao->updateDynamicByKey ( $blog );
			// ---Blog Lang ---
			foreach ( $blogLangs->getArray () as $blogLangVo ) {
				//$blogLangVo->blogId = $blog->id;
				if (AppUtil::isEmptyString ( $blogLangVo->blogId )) {
					$blogLangVo->blogId = $blog->id;
					$blogLangDao->insertDynamic ( $blogLangVo );
				} else {
					$blogLangDao->updateDynamicByKey ( $blogLangVo );
				}
			}
			// ---Blog Relate
			$filterDelete = new BlogVo ();
			$filterDelete->id = $blog->id;
			$blogRelationExtendDao->deleteBlogRelationByBlog ( $filterDelete );
			foreach ( $blogRelations->getArray () as $relationVo ) {
				$relationVo->blogId = $blog->id;
				$blogRelationDao->insertDynamic ( $relationVo );
			}
			$blogRegionExtendDao->deleteBlogRegionByBlog ( $filterDelete );
			foreach ( $blogRegions->getArray () as $regionVo ) {
				if ($regionVo->select == 1) {
					$regionVo->blogId = $blog->id;
					$blogRegionExtendDao->insertDynamic ( $regionVo );
				}
			}
			// ---Blog Seo ---
			foreach ( $blogSeos->getArray () as $seoVo ) {
				//$seoVo->itemId = $blog->id;
				$seoVo->type = "blog";
				if (AppUtil::isEmptyString ( $seoVo->itemId )) {
					$seoVo->itemId = $blog->id;
					$blogSeoExtendDao->insertDynamic ( $seoVo );
				} else {
					$blogSeoExtendDao->updateDynamicByKey ( $seoVo );
				}
			}
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function deleteBlog(BlogVo $blogVo) {
		$sqlClient = new SqlMapClient ( $this->context );
		$blogBaseDao = new BlogBaseDao ( $this->context, $sqlClient );
		$blogLangExtendDao = new BlogLangExtendDao ( $this->context, $sqlClient );
		$blogRelationExtendDao = new BlogRelationExtendDao ( $this->context, $sqlClient );
		$blogRegionExtendDao = new BlogRegionExtendDao ( $this->context, $sqlClient );
		$blogSeoExtendDao = new BlogSeoExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			$blogBaseDao->deleteByKey ( $blogVo );
			$blogLangExtendDao->deleteBlogLangByBlog ( $blogVo );
			$blogRelationExtendDao->deleteBlogRelationByBlog ( $blogVo );
			$blogRegionExtendDao->deleteBlogRegionByBlog ( $blogVo );
			$blogSeoExtendDao->deleteBlogSeoByBlog ( $blogVo );
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	
	// Blog Extend
	public function getBlogLangsByBlogId(BlogVo $blogVo) {
		$blogLangs = new BaseArray ( BlogLangExtendVo::class );
		$blogLangExtendDao = new BlogLangExtendDao ();
		$list = $blogLangExtendDao->selectByBlogId ( $blogVo );
		foreach ( $list as $blogLang ) {
			$blogLangs->add ( $blogLang );
		}
		return $blogLangs;
	}
	public function getBlogRelationsByBlogId(BlogVo $blogVo) {
		$blogRelations = new BaseArray ( BlogRelationExtendVo::class );
		$blogRelationExtendDao = new BlogRelationExtendDao ();
		$list = $blogRelationExtendDao->selectBlogRelationByBlogId ( $blogVo );
		foreach ( $list as $relate ) {
			$blogRelations->add ( $relate );
		}
		return $blogRelations;
	}
	public function getBlogRegionsByBlogId(BlogVo $blogVo) {
		$blogRegions = new BaseArray ( BlogRegionExtendVo::class );
		$blogRegionExtendDao = new BlogRegionExtendDao ();
		$list = $blogRegionExtendDao->selectBlogRegionByBlogId ( $blogVo );
		foreach ( $list as $region ) {
			$region->select = $region->blogId != null ? 1 : 0;
			$blogRegions->add ( $region );
		}
		return $blogRegions;
	}
	public function getBlogSeoByBlogId(BlogVo $blogVo) {
		$blogSeos = new BaseArray ( BlogSeoExtendVo::class );
		$blogSeoExtendDao = new BlogSeoExtendDao ();
		$list = $blogSeoExtendDao->selectByBlogId ( $blogVo );
		foreach ( $list as $seo ) {
			$blogSeos->add ( $seo );
		}
		return $blogSeos;
	}
	// End blog extend
	
	
	// CategoryBlog manager
	public function getCategoryBlogByFilter(CategoryBlogVo $categoryVo = null) {
		return $this->categoryDao->getByFilter ( $categoryVo );
	}
	public function getCategoryBlogByKey(CategoryBlogVo $categoryVo = null) {
		return $this->categoryDao->selectByKey ( $categoryVo );
	}
	public function countCategoryBlogByFilter(CategoryBlogVo $categoryVo = null) {
		return $this->categoryDao->getCountByFilter ( $categoryVo );
	}
	public function createCategoryBlog(CategoryBlogVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs) {
		$sqlClient = new SqlMapClient ( $this->context );
		$categoryDao = new CategoryBlogExtendDao ( $this->context, $sqlClient );
		$categoryLangDao = new CategoryBlogLangExtendDao ( $this->context, $sqlClient );
		$seoInfoLangDao = new SeoInfoLangExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// Add to category lang table.
			$categoryId = $categoryDao->insertDynamic ( $categoryVo );
			// Add category lang langs.
			foreach ( $categoryLangs->getArray () as $lang ) {
				$lang->categoryId = $categoryId;
				$categoryLangDao->insertDynamic ( $lang );
			}
			foreach ( $seoInfoLangs->getArray () as $seoInfoVo ) {
				// Add new category seo info lang .
				$seoInfoVo->itemId = $categoryId;
				$seoInfoVo->type = "category_blog";
				$seoInfoLangDao->insertDynamic ( $seoInfoVo );
			}
			// Commit transaction.
			$sqlClient->endTransaction ();
			return $categoryId;
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function updateCategoryBlog(CategoryBlogVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs) {
		$sqlClient = new SqlMapClient ( $this->context );
		$categoryDao = new CategoryBlogExtendDao ( $this->context, $sqlClient );
		$categoryLangDao = new CategoryBlogLangExtendDao ( $this->context, $sqlClient );
		$seoInfoLangDao = new SeoInfoLangExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// Update to category table.
			$categoryDao->updateDynamicByKey ( $categoryVo );
			// Remove all category lang of this category
			// and insert new category lang.
			foreach ( $categoryLangs->getArray () as $lang ) {
				// Delete category lang.
				if(!AppUtil::isEmptyString($lang->categoryBlogId)){
					$categoryLangDao->deleteByKey ( $lang );
				}
				// Add new category lang.
				$categoryLangDao->insertDynamic ( $lang );
			}
			foreach ( $seoInfoLangs->getArray () as $seoInfoVo ) {
				// Delete category lang.
				$seoInfoLangDao->deleteByKey ( $seoInfoVo );
				// Add new category lang.
				$seoInfoLangDao->insertDynamic ( $seoInfoVo );
			}
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function deleteCategoryBlog(CategoryBlogVo $categoryVo = null) {
		$sqlClient = new SqlMapClient ( $this->context );
		$categoryDao = new CategoryBlogExtendDao ( $this->context, $sqlClient );
		$categoryLangDao = new CategoryBlogLangExtendDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			$filter = new CategoryBlogLangVo ();
			$filter->categoryId = $categoryVo->id;
			$categoryLangs = $categoryLangDao->selectByFilter ( $filter );
			// Delete category lang.
			foreach ( $categoryLangs as $lang ) {
				$categoryLangDao->deleteByKey ( $lang );
			}
			$categoryDao->deleteByKey ( $categoryVo );
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function getLangsByCategoryBlogId(CategoryBlogLangExtendVo $filter) {
		$categoryLangDao = new CategoryBlogLangExtendDao ();
		return $categoryLangDao->getLangsByCategoryBlogId ( $filter );
	}
	public function getSeoInfosByCategoryBlogId(SeoInfoLangExtendVo $filter) {
		$seoInfoDao = new SeoInfoLangExtendDao ();
		return $seoInfoDao->getLangsByKey ( $filter );
	}
	
	// End CategoryBlog manager
	public function isExistedName($name){
		if (AppUtil::isEmptyString($name)) {
			return false;
		}
		$filter = new BlogVo();
		$filter->name = $name;
		
		$news = $this->blogDao->getBlogByFilter($filter);
		if (count($news) > 0) {
			return true;
		}
		return false;
		
	}
	
	public function countBlogByParentCatId($idParent, BlogVo $filter = null){
		$categorySv = new CategoryBlogService();
		$categories = array();
		$categorySv->getCategoryLastChild($idParent, $categories);
		if (is_null($filter)) {
			$filter = new BlogVo();
		}
		$filter->categoryBlogId = StringUtil::convertArrayToStringForSelectIn($categories);
		return $this->blogDao->countBlogByParentCatId($filter);
	}
	
	public function getBlogByParentCatId($idParent, BlogVo $filter = null){
		$categorySv = new CategoryBlogService();
		$categories = array();
		$categorySv->getCategoryLastChild($idParent, $categories);
		if (is_null($filter)) {
			$filter = new BlogVo();
		}
		$filter->categoryBlogId = StringUtil::convertArrayToStringForSelectIn($categories);
		return $this->blogDao->getBlogByParentCatId($filter);
	}

	public function getBlogNew(){
        $categorySv = new CategoryBlogService();
        $categoryVo = new CategoryBlogExtendVo();
        $categoryVo->status = 'active';
        $categoryVos = $categorySv->getByFilter($categoryVo);
        $categories = array();
        foreach ($categoryVos as  $categoryVo){
            array_push( $categories, $categoryVo->id);
        }
        $filter = new BlogVo();
        $filter->categoryBlogId = StringUtil::convertArrayToStringForSelectIn($categories);
        $filter->order_by = 'md_date desc';
        $filter->status = 'active';
        $filter->start_record = 0;
        $filter->start_record = 10;
        return $this->blogDao->getBlogByParentCatId($filter);
    }
	
}