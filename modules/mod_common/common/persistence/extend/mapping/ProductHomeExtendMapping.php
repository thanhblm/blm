<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class ProductHomeExtendMapping
{
    public function getProductHomeById(ProductHomeExtendVo $productExtendVo)
    {
        try {
            $query = "
				select
				 	p.id,
					if(trim(cl.name)='' or cl.name is null,cat.name,cl.name) as category_name,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
					p.is_seo,
				    p.md_date,
				    p.md_by,
					p.tax_rate_id,
					p.type,
				    c.symbol,
					pp.price,
					pp.price base_price,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description,
					csi.url as category_seo_url,
				    csi.title as category_seo_title,
				    csi.keywords as category_seo_keywords,
				    csi.description as category_seo_description
				from product as p
				left join category as cat on cat.id = p.category_id
	            left join category_lang as cl on cl.category_id = cat.id and cl.language_code = #{languageCode}
				left join seo_info_lang as csi on csi.type = 'category' and csi.item_id = cat.id and csi.language_code = #{languageCode}
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`id`", "id")
                ->appendLimit();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProductHomeByFilter(ProductHomeExtendVo $productExtendVo)
    {
        try {
            $query = "
				select * from(
					select 
				 	p.id,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					p.tax_rate_id,
					p.type,
				    c.symbol,
					pp.price,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from product as p 
				inner join category as ca on p.category_id = ca.id and ca.status = 'active'
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}) p ";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`id`", "id", "=", false)
                ->appendCondition("category_id", "categoryId")
                ->appendCondition("`featured`", "featured")
                ->appendCondition("p.`status`", "status")
                ->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
                ->appendOrder()
                ->appendLimit();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCountProductHomeByFilter(ProductHomeExtendVo $productExtendVo)
    {
        try {
            $query = "
				select * from(
					select 
				 	p.id,
				    p.category_id,
				    p.code,
				    p.status,
				    p.featured
				from product as p 
				inner join category as ca on p.category_id = ca.id and ca.status = 'active'
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}) p ";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`id`", "id", "=", false)
                ->appendCondition("category_id", "categoryId")
                ->appendCondition("`featured`", "featured")
                ->appendCondition("p.`status`", "status")
                ->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE");
            $sql = "select count(*) from (" . $queryBuilder->getSql() . ") tmp";
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $sql, ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProductHomeRelateCategories(ProductHomeExtendVo $productExtendVo)
    {
        try {
            $query = "
				select * from(
					select
				 	p.id,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					p.tax_rate_id,
					p.type,
				    c.symbol,
					pp.price,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from product as p 
				inner join category as ca on p.category_id = ca.id and ca.status = 'active'
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}) p 
					where p.category_id=#{categoryId} and p.status = #{status} and p.id != #{id}
				ORDER BY RAND() LIMIT 3";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCategoryHomeById(CategoryHomeExtendVo $categoryExtendVo)
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
				from category as c
				left join category_lang as cl on c.id = cl.category_id and cl.`language_code` = #{languageCode}
				left join seo_info_lang as sil on sil.item_id = c.id and sil.`type` = 'category' and sil.`language_code` = #{languageCode}";
            $queryBuilder = new QueryBuilder($categoryExtendVo, $query);
            $queryBuilder
                ->appendCondition("c.`id`", "id")
                ->appendCondition("c.`status`", "status");
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCategoryHomeByFilter(CategoryHomeExtendVo $categoryExtendVo)
    {
        try {
            $query = "
				select
					c.id,
					c.parent_id,
					c.level,
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
				from category as c 
				left join category_lang as cl on c.id = cl.category_id and cl.`language_code` = #{languageCode}
				left join seo_info_lang as sil on sil.item_id = c.id and sil.`type` = 'category' and sil.`language_code` = #{languageCode}";
            $queryBuilder = new QueryBuilder($categoryExtendVo, $query);
            $queryBuilder
                ->appendCondition("c.`id`", "id")
                ->appendCondition("c.`status`", "status")
                ->appendCondition("c.`parent_id`", "parentId");
            $sql = $queryBuilder->getSql();
            $sql .= ' group by c.id';
            $queryBuilder = new QueryBuilder($categoryExtendVo, $sql);
            $queryBuilder
                ->appendOrder();
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getRelationProducts(ProductHomeExtendVo $productHomeVo)
    {
        try {
            $query = "
				select
				 	p.id,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
					p.type,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
				    c.symbol,
					pl.language_code,
					pp.price,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from product as p
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code 
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}
				where p.id in (select pr.relate_product_id from product_relation as pr where pr.product_id = #{id}) and p.status = #{status}";
            $queryBuilder = new QueryBuilder($productHomeVo, $query);
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getBulDiscountByProduct(BulkDiscountExtendVo $bulkDiscountVo)
    {
        try {
            $query = "
				select 
					bd.*,
					bdp.quantity as product_quantity 
				from bulk_discount as bd 
				inner join bulk_discount_product as bdp on bd.id = bdp.bulk_discount_id";
            $queryBuilder = new QueryBuilder($bulkDiscountVo, $query);
            $queryBuilder
                ->appendCondition("bdp.product_id", "productId")
                ->appendCondition("bd.status", "status")
                ->appendCondition("bd.valid_from", "dateNow", "<=")
                ->appendCondition("bd.valid_to", "dateNow", ">=");
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BulkDiscountExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getBestSellers(ProductHomeExtendVo $productExtendVo = null)
    {
        try {
            $query = "
				select * from(
					select
				 	p.id,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					p.tax_rate_id,
					p.type,
				    c.symbol,
					pp.price,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from product as p
				inner join category as ca on p.category_id = ca.id and ca.status = 'active'
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}
				inner join (select op.product_id, sum(op.quantity) as amount from order_product op group by op.product_id order by amount desc) as op on p.id = op.product_id) p ";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);
            $queryBuilder
                ->appendCondition("p.`status`", "status");
            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProductHomeByRandom(ProductHomeExtendVo $productExtendVo)
    {
        try {
            $query = "
				select * from(
					select
				 	p.id,
				    p.category_id,
				    p.code,
				    if (trim(pl.name)='' or pl.name is null, p.name, pl.name) as name,
				    p.status,
				    p.item_code,
				    p.bar_code,
				    p.weight,
				    p.weight_unit,
				    if (trim(pl.description)='' or pl.description is null, p.description, pl.description) as description,
				    if (trim(pl.composition)='' or pl.composition is null, p.composition, pl.composition) as composition,
				    p.featured,
				    p.cbd_amount,
				    p.page_id,
				    p.images,
				    p.cr_date,
				    p.cr_by,
				    p.md_date,
				    p.md_by,
					p.tax_rate_id,
					p.type,
				    c.symbol,
					pp.price,
					pl.language_code,
				    si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from product as p 
				inner join category as ca on p.category_id = ca.id and ca.status = 'active'
				left join product_lang as pl on pl.product_id = p.id and pl.language_code = #{languageCode}
				left join product_price as pp on pp.product_id = p.id and pp.currency_code = #{currencyCode}
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}
				left join currency as c on c.code = pp.currency_code
				inner join product_region as pre on p.id = pre.product_id and pre.region_id = #{regionId}) p 
					where p.status = #{status} and p.id != #{id}
				ORDER BY RAND() LIMIT 3";
            $queryBuilder = new QueryBuilder($productExtendVo, $query);

            return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductHomeExtendVo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}