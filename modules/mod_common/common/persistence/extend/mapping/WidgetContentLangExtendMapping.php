<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\WidgetContentLangExtendVo;
use core\database\SqlStatementInfo;

class WidgetContentLangExtendMapping {
	public function getLangsByWidgetContentId(WidgetContentLangExtendVo $filter) {
		try {
			$query = "select l.code, l.name, l.flag, r.* from language l 
					left join
						(select * from widget_content_lang
					    where widget_content_id = #{widgetContentId}
					    ) r on r.language_code = l.code
					order by l.name asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, WidgetContentLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}