<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\BlogBaseDao;
use common\persistence\extend\mapping\BlogHomeExtendMapping;
use common\persistence\extend\vo\BlogHomeExtendVo;
use common\persistence\extend\vo\CategoryBlogHomeExtendVo;
use core\database\SqlMapClient;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\BulkDiscountExtendVo;

class BlogHomeExtendDao extends BlogBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function getBlogHomeById(BlogHomeExtendVo $blogExtendVo){
		$result = $this->executeSelectOne(BlogHomeExtendMapping::class, 'getBlogHomeById',$blogExtendVo);
		return $result;
	}
	
	public function getBlogHomeByFilter(BlogHomeExtendVo $blogExtendVo = null) {
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getBlogHomeByFilter', $blogExtendVo );
		return $result;
	}
	
	public function getBlogHomeRelateCategories(BlogHomeExtendVo $blogExtendVo = null) {
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getBlogHomeRelateCategories', $blogExtendVo );
		return $result;
	}
	
	public function getBlogHomeByRandom(BlogHomeExtendVo $blogExtendVo = null) {
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getBlogHomeByRandom', $blogExtendVo );
		return $result;
	}
	
	public function getCategoryHomeById(CategoryHomeExtendVo $categoryExtendVo){
		$result = $this->executeSelectOne(BlogHomeExtendMapping::class, 'getCategoryHomeById',$categoryExtendVo);
		return $result;
	}
	
	public function getCategoryHomeByFilter(CategoryBlogHomeExtendVo $categoryExtendVo ){
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getCategoryHomeByFilter', $categoryExtendVo );
		return $result;
	}
	
	public function getRelationBlogs(BlogHomeExtendVo $blogHomeVo){
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getRelationBlogs', $blogHomeVo );
		return $result;
	}
	
	public function getBulDiscountByBlog(BulkDiscountExtendVo $bulkDiscountVo){
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getBulDiscountByBlog', $bulkDiscountVo );
		return $result;
	}
	public function getBestSellers(BlogHomeExtendVo $blogExtendVo = null) {
		$result = $this->executeSelectList ( BlogHomeExtendMapping::class, 'getBestSellers', $blogExtendVo );
		return $result;
	}
}