<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\BlogHomeExtendVo;
use common\persistence\extend\vo\CategoryBlogHomeExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\BulkDiscountExtendVo;

class BlogHomeExtendMapping
{
    public function getBlogHomeById(CategoryBlogHomeExtendVo $blogExtendVo)
    {
        try {
            $query = "
				select
				 	p.id,
					if(trim(cl.name)='' or cl.name is null,cat.name,cl.name) as category_blog_name,
				    p.category_blog_id,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
					p.is_seo,
				    p.md_date,
				    p.md_by,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description,
					csi.url as category_blog_seo_url,
				    csi.title as category_blog_seo_title,
				    csi.keywords as category_blog_seo_keywords,
				    csi.description as category_blog_seo_description
				from blog as p
				left join category_blog as cat on cat.id = p.category_blog_id
	            left join category_blog_lang as cl on cl.category_blog_id = cat.id and cl.language_code = #{languageCode}
				left join seo_info_lang as csi on csi.type = 'category_blog' and csi.item_id = cat.id and csi.language_code = #{languageCode}
				left join blog_lang as pl on pl.blog_id = p.id and pl.language_code = #{languageCode}
				left join seo_info_lang as si on si.type = 'blog' and si.item_id = p.id and si.language_code = #{languageCode}
				";
            $queryBuilder = new QueryBuilder($blogExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`id`", "id")
                ->appendLimit();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getBlogHomeByFilter(BlogHomeExtendVo $blogExtendVo)
    {
        try {
            if (!empty($blogExtendVo->tag)) {
                $condition = ' where p.`tag` = #{tag}';
            } else {
                $condition = '';
            }
            $query = "
					select 
				 	p.id,
				    p.category_blog_id,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from blog as p 
				inner join category_blog as ca on p.category_blog_id = ca.id 
				left join blog_lang as pl on pl.blog_id = p.id 
				left join seo_info_lang as si on si.item_id = p.id
				";
            $queryBuilder = new QueryBuilder($blogExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`id`", "id", "=", false)
                ->appendCondition("p.category_blog_id", "category_blogId")
                ->appendCondition("`p.featured`", "featured")
                ->appendCondition("`p.type`", "type")
                ->appendCondition("p.`status`", "status")
                ->appendCondition("`p.name`", "name", "like", false, ":PARAM_BOTH_LIKE")
                ->appendOrder()
                ->appendLimit();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getBlogHomeRelateCategories(BlogHomeExtendVo $blogExtendVo)
    {
        try {
            $query = "
				select * from(
					select
				 	p.id,
				    p.category_blog_id,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from blog as p 
				inner join category_blog as ca on p.category_blog_id = ca.id and ca.status = 'active'
				left join blog_lang as pl on pl.blog_id = p.id and pl.language_code = #{languageCode}
				left join seo_info_lang as si on si.type = 'blog' and si.item_id = p.id and si.language_code = #{languageCode}
				inner join blog_region as pre on p.id = pre.blog_id and pre.region_id = #{regionId}) p 
					where p.category_blog_id=#{category_blogId} and p.status = #{status} and p.id != #{id}
				ORDER BY RAND() LIMIT 3";
            $queryBuilder = new QueryBuilder($blogExtendVo, $query);
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCategoryHomeById(CategoryHomeExtendVo $category_blogExtendVo)
    {
        try {
            $query = "
				select distinct
					c.id,
					c.code,
					if (trim(cl.name)='' or cl.name is null, c.name, cl.name) as name,
					c.status,
					c.bg_img,
					c.small_icon,
					c.big_icon,
					c.featured,
					cl.language_code,
					if (trim(cl.description)='' or cl.description is null, c.description, cl.description) as description,
					if (trim(cl.introduction)='' or cl.introduction is null, c.introduction, cl.introduction) as introduction,
					sil.type,sil.url as seo_url,sil.title as seo_title,sil.keywords as seo_keywords,sil.description as seo_description
				from category_blog as c
				left join category_blog_lang as cl on c.id = cl.category_blog_id and cl.`language_code` = #{languageCode}
				left join seo_info_lang as sil on sil.item_id = c.id and sil.`type` = 'category_blog' and sil.`language_code` = #{languageCode}";
            $queryBuilder = new QueryBuilder($category_blogExtendVo, $query);
            $queryBuilder
                ->appendCondition("c.`id`", "id")
                ->appendCondition("c.`status`", "status");
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCategoryHomeByFilter(CategoryBlogHomeExtendVo $category_blogExtendVo)
    {
        try {
            $query = "
				select distinct
					c.id,
					c.code,
					if (trim(cl.name)='' or cl.name is null, c.name, cl.name) as name,
					c.status,
					c.bg_img,
					c.small_icon,
					c.big_icon,
					c.featured,
					c.md_date,
					cl.language_code,
					if (trim(cl.description)='' or cl.description is null, c.description, cl.description) as description,
					if (trim(cl.introduction)='' or cl.introduction is null, c.introduction, cl.introduction) as introduction,
					sil.type,
					sil.url as seo_url,
					sil.title as seo_title,
					sil.keywords as seo_keywords,
					sil.description as seo_description
				from category_blog as c 
				left join category_blog_lang as cl on c.id = cl.category_blog_id and cl.`language_code` = #{languageCode}
				left join seo_info_lang as sil on sil.item_id = c.id and sil.`type` = 'category_blog' and sil.`language_code` = #{languageCode}";
            $queryBuilder = new QueryBuilder($category_blogExtendVo, $query);
            $queryBuilder
                ->appendCondition("c.`id`", "id")
                ->appendCondition("c.`status`", "status")
                ->appendCondition("c.`parent_id`", "parentId")
                ->appendOrder();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getRelationBlogs(BlogHomeExtendVo $blogHomeVo)
    {
        try {
            $query = "
				select
				 	p.id,
				    p.category_blog_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.images,
					p.type,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					pl.language_code,
					pp.price,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from blog as p
				left join blog_lang as pl on pl.blog_id = p.id and pl.language_code = #{languageCode}
				left join seo_info_lang as si on si.type = 'blog' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code 
				inner join blog_region as pre on p.id = pre.blog_id and pre.region_id = #{regionId}
				where p.id in (select pr.relate_blog_id from blog_relation as pr where pr.blog_id = #{id}) and p.status = #{status}";
            $queryBuilder = new QueryBuilder($blogHomeVo, $query);
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function getBlogHomeByRandom(BlogHomeExtendVo $blogExtendVo)
    {
        try {
            $query = "
				select * from(
					select
				 	p.id,
				    p.category_blog_id,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					p.type,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from blog as p 
				inner join category_blog as ca on p.category_blog_id = ca.id and ca.status = 'active'
				left join blog_lang as pl on pl.blog_id = p.id and pl.language_code = #{languageCode}
				left join seo_info_lang as si on si.type = 'blog' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join blog_region as pre on p.id = pre.blog_id and pre.region_id = #{regionId}) p 
					where p.status = #{status} and p.id != #{id}
				ORDER BY RAND() LIMIT 3";
            $queryBuilder = new QueryBuilder($blogExtendVo, $query);

            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlogHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}