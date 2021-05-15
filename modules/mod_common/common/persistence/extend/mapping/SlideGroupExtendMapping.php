<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\SlideGroupMapping;
use core\database\SqlStatementInfo;
use common\model\SlideGroupMo;
use common\filter\slide_group\SlideGroupFilter;
use core\database\QueryBuilder;

class SlideGroupExtendMapping extends SlideGroupMapping
{
    public function search(SlideGroupFilter $filter)
    {
        try {
            $query = "select * from slide_group";
            $queryBuilder = new QueryBuilder($filter, $query);
            $queryBuilder
                ->appendCondition("`id`", "id")
                ->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
                ->appendCondition("`status`", "status")
                ->appendCondition("`code`", "code")
                ->appendOrder()
                ->appendLimit();
            return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), SlideGroupMo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function searchCount(SlideGroupFilter $filter)
    {
        try {
            $query = "select count(*) from slide_group";
            $queryBuilder = new QueryBuilder($filter, $query);
            $queryBuilder
                ->appendCondition("`id`", "id")
                ->appendCondition("`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
                ->appendCondition("`status`", "status")
                ->appendCondition("`code`", "code");
            return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), SlideGroupMo::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}