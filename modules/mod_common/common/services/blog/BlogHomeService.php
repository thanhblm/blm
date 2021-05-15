<?php

namespace common\services\blog;

use common\helper\SettingHelper;
use common\model\BlogCategoryHomeMo;
use common\persistence\extend\dao\BlogHomeExtendDao;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\CategoryBlogHomeExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\BlogHomeExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\Lang;
use core\utils\SessionUtil;
use common\persistence\base\dao\CustomerBaseDao;
use common\persistence\base\vo\CustomerVo;
use common\persistence\extend\dao\PriceLevelExtendDao;
use frontend\common\Constants;

class BlogHomeService extends BaseService {
	private $blogExtendDao;
	public $blogCategoryHomeOtherArray;
	public function __construct() {
		$this->blogExtendDao = new BlogHomeExtendDao ();
	}

	public function getBlogHomeById(BlogHomeExtendVo $blogExtendVo) {
		$blog = $this->blogExtendDao->getBlogHomeById ( $blogExtendVo );
		$priceLevel = $this->priceLevelCustomer();
		$blog->basePrice = $blog->price;
		if(!is_null($priceLevel)){
			$blog->price = $blog->basePrice - $blog->basePrice * $priceLevel->value/100;
		}
		return $blog;
	}
	public function getBlogHomeByFilter(BlogHomeExtendVo $blogExtendVo) {
		$blogs = $this->blogExtendDao->getBlogHomeByFilter ( $blogExtendVo );
		return $blogs;
	}
	
	public function getBlogHomeByRandom(BlogHomeExtendVo $blogExtendVo) {
		$blogs = $this->blogExtendDao->getBlogHomeByRandom ( $blogExtendVo );
		return $blogs;
	}
	public function getCategoryHomeByFilter(CategoryBlogHomeExtendVo $categoryExtendVo) {
		$categories = $this->blogExtendDao->getCategoryHomeByFilter ( $categoryExtendVo );
		return $categories;
	}
	public function getCategoryHomeById(CategoryBlogHomeExtendVo $categoryExtendVo) {
		return $this->blogExtendDao->getCategoryHomeById ( $categoryExtendVo );
	}
	public function getBlogCategoryByCategory(CategoryBlogHomeExtendVo $categoryExtendVo, BlogHomeExtendVo $blogExtendVo) {
		$blogCategoryHomeMo = new BlogCategoryHomeMo ();
		$category = $this->blogExtendDao->getCategoryHomeById ( $categoryExtendVo );
		$blogs = $this->blogExtendDao->getBlogHomeByFilter ( $blogExtendVo );
		$blogCategoryHomeMo->categoryHomeExtendVo = $category;
		$priceLevel = $this->priceLevelCustomer();
		foreach ( $blogs as $blog ) {
			$blog->basePrice = $blog->price;
			if(!is_null($priceLevel)){
				$blog->price = $blog->basePrice - $blog->basePrice * $priceLevel->value/100;
			}
			$blogCategoryHomeMo->blogHomeExtendArray->add ( $blog );
		}
		return $blogCategoryHomeMo;
	}
	public function getBlogCategoryHomeByFilter(CategoryBlogHomeExtendVo $categoryExtendVo, BlogHomeExtendVo $blogExtendVo) {
		$blogCategoryHomeArray = new BaseArray ( BlogCategoryHomeMo::class );
		$this->blogCategoryHomeOtherArray = new BaseArray ( BlogCategoryHomeMo::class );
		
		$categories = $this->getCategoryHomeByFilter ( $categoryExtendVo );
		$blogs = $this->getBlogHomeByFilter ( $blogExtendVo );
		$numberBlog = SettingHelper::getSettingValue ( "Max blogs per category" );
		if (AppUtil::isEmptyString ( $numberBlog )) {
			$numberBlog = ApplicationConfig::get ( "category.max.blog.list" );
		}
		if (AppUtil::isEmptyString ( $numberBlog )) {
			$numberBlog = 4;
		}
		$priceLevel = $this->priceLevelCustomer();
		//$blogHomeOtherArray = new BaseArray ( BlogHomeExtendVo::class );
		
		//$blogCategoryHomeOtherMo = new BlogCategoryHomeMo ();
		foreach ( $categories as $category ) {
			$blogCategoryHomeMo = new BlogCategoryHomeMo ();
			$blogCategoryHomeMo->categoryHomeExtendVo = $category;
			
			$blogHomeArray = new BaseArray ( BlogHomeExtendVo::class );
			if($this->countBlogByCategory($blogs, $category)>=3){
				$i = 0;
				foreach ( $blogs as $blog ) {
					if ($i >= $numberBlog) {
						break;
					}
					if ($blog->categoryId == $category->id) {
						$blog->basePrice = $blog->price;
						if(!is_null($priceLevel)){
							$blog->price = $blog->basePrice - $blog->basePrice * $priceLevel->value/100;
						}
						$blogHomeArray->add ( $blog );
						$i ++;
					}
				}
				$blogCategoryHomeMo->blogHomeExtendArray = $blogHomeArray;
				$blogCategoryHomeArray->add ( $blogCategoryHomeMo );
			}else{//category other
				foreach ( $blogs as $blog ) {
					if ($blog->categoryId == $category->id) {
						$blog->basePrice = $blog->price;
						if(!is_null($priceLevel)){
							$blog->price = $blog->basePrice - $blog->basePrice * $priceLevel->value/100;
						}
						$blogHomeArray->add ( $blog );
					}
				}
				
				$blogCategoryHomeMo->blogHomeExtendArray = $blogHomeArray;
				$this->blogCategoryHomeOtherArray->add ( $blogCategoryHomeMo );
			}
		}
		/*
		if(count($blogHomeOtherArray->getArray())>0){
			$categoryHomeExtendVo = new CategoryHomeExtendVo();
			$categoryHomeExtendVo->id = -1;
			$categoryHomeExtendVo->name = Lang::get("Other");
			$blogCategoryHomeOtherMo->categoryHomeExtendVo =$categoryHomeExtendVo; 
			$blogCategoryHomeOtherMo->blogHomeExtendArray = $blogHomeOtherArray;
			$this->categoryOther = $blogCategoryHomeOtherMo;
			//$blogCategoryHomeArray->add($blogCategoryHomeOtherMo);
		}else{
			$this->categoryOther = null;
		}*/
		
		return $blogCategoryHomeArray;
	}
	private function countBlogByCategory($blogs,$category){
		$count = 0;
		foreach ( $blogs as $blog ) {
			if ($blog->categoryId == $category->id) {
				$count ++;
			}
		}
		return $count;
	}
	public function getRelatedBlogs(BlogHomeExtendVo $blogHomeVo) {
		$blogRelations = $this->blogExtendDao->getRelationBlogs ( $blogHomeVo );
		
		if (count ( $blogRelations ) == 0) {
			$filter = new BlogHomeExtendVo ();
			$filter->id = $blogHomeVo->id;
			$filter->categoryId = $blogHomeVo->categoryId;
			$filter->status = $blogHomeVo->status;
			$filter->regionId = $blogHomeVo->regionId;
			$filter->languageCode = $blogHomeVo->languageCode;
			$filter->currencyCode = $blogHomeVo->currencyCode;
			$filter->start_record = 0;
			$filter->end_record = 2;
			
			$blogRelations = $this->blogExtendDao->getBlogHomeRelateCategories ( $filter );
		}
		return $blogRelations;
	}
	public function getBulDiscountByBlog(BulkDiscountExtendVo $bulkDiscountVo) {
		$bulkDiscounts = $this->blogExtendDao->getBulDiscountByBlog ( $bulkDiscountVo );
		return $bulkDiscounts;
	}
	private function priceLevelCustomer() {
		if (! is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			$customerVo = new CustomerVo();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$priceLevelDao = new PriceLevelExtendDao();
			$priceLevel = $priceLevelDao->getPriceLevelByCustomerId($customerVo);

			if (! is_null ( $priceLevel )) {
				return $priceLevel;
			}
		}
		return null;
	}
	public function getBestSellers(BlogHomeExtendVo $blogExtendVo=null){
		return $this->blogExtendDao->getBestSellers($blogExtendVo);
	}
}