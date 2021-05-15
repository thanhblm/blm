<?php

namespace filemanager\persistence\extend\mapping;

use filemanager\persistence\base\mapping\ImageMapping;
use filemanager\persistence\base\vo\ImageVo;
use core\database\SqlStatementInfo;

class ImageExtendMapping extends ImageMapping {
	public function selectByPid(ImageVo $imageVo) {
		try {
			$query = "select * from `image` where (`profile` = #{profile}) order by md_date desc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ImageVo::class );
		} catch ( \Exception $e ) { 
			throw $e;
		}
	}
}