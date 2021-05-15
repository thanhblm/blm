<?php

namespace frontend\service;
use common\services\block_email\BlockEmailService;
use common\persistence\base\vo\BlockEmailVo;
class BlockEmailHelper {
	public static function checkIsBlockEmail($email) {
		$blockEmailService = new BlockEmailService();
		$filter=new BlockEmailVo();
		$filter->email= $email;
		$voResult =$blockEmailService->getBlockEmailByEmail($filter);
		if(count($voResult )>0){return true;}
		return false;
	}
}