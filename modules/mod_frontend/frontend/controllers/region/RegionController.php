<?php

namespace frontend\controllers\region;

use core\Controller;
use core\utils\SessionUtil;
use common\services\region\RegionService;
use common\persistence\base\vo\RegionVo;

class RegionController extends Controller {
	public $regionId;
	public function change() {
		SessionUtil::set ( "region.default.id", $this->regionId );
		$regionService= new RegionService();
		$regionFilter= new RegionVo();
		$regionFilter->id=$this->regionId;
		$region=$regionService->getById($regionFilter);
		SessionUtil::set ( "currency.default.code", $region->currencyCode );

		return null;
	}
}
