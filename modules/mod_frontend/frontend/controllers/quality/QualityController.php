<?php

namespace frontend\controllers\quality;

use common\helper\LocalizationHelper;
use common\persistence\base\vo\BatchGroupVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\BatchExtendVo;
use common\services\batch\BatchService;
use common\services\batch_group\BatchGroupService;
use common\services\seo\SeoInfoLangService;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class QualityController extends FrontendController{
	public $seoInfoVo;
	private $seoInfoLangService;
	public $batchDatas;
	private $batchGroups;
	private $batchs;
	private $value;
	private $batchGroupSv;
	private $batchData;
	private $batchSv;

	public function __construct(){
		parent::__construct();
		$this->batchGroupSv = new BatchGroupService();
		$this->batchSv = new BatchService();
		$this->seoInfoVo = new SeoInfoLangVo ();
		$this->seoInfoLangService = new SeoInfoLangService ();
	}

	public function show(){
		$this->getSeoInfo(128);
		return "success";
	}

	public function report(){
		$this->getSeoInfo(129);
		$batchGroupVo = new BatchGroupVo ();
		$batchGroupVo->status = "active";
		$this->batchGroups = $this->batchGroupSv->selectByFilter($batchGroupVo);
		foreach ($this->batchGroups as $batchGroup) {
			$batchVo = new BatchExtendVo ();
			$batchVo->status = "active";
			$batchVo->batchGroupId = $batchGroup->id;
			$batchVo->order_by = "batchId asc";
			$this->batchs = $this->batchSv->selectByFilterExtend($batchVo);
			$this->value = array();
			$this->batchData = array();
			$nbatch = 50;
			foreach ($this->batchs as $batch) {
				$number = $batch->batchId;
				$batchId = floor($number / $nbatch);
				if (($number % $nbatch) == 0 && $batchId > 0) {
					$batchId = $batchId - 1;
				}
				$keyNew = "Batch " . ($batchId * $nbatch + 1) . "-" . ($batchId + 1) * $nbatch;
				$this->batchDatas [$batchGroup->name][$keyNew][] = $batch;
			}
		}
		return "success";
	}

	protected function getSeoInfo($itemId){
		$this->seoInfoVo->itemId = $itemId;
		$this->seoInfoVo->type = "page";
		$this->seoInfoVo->languageCode = LocalizationHelper::getLangCode();
		$seoInfoLang = $this->seoInfoLangService->selectByFilter($this->seoInfoVo);
		if (AppUtil::isEmptyString($seoInfoLang [0]->title)) {
			$this->seoInfoVo = new SeoInfoLangVo ();
			$this->seoInfoVo->itemId = $itemId;
			$this->seoInfoVo->type = "page";
			$this->seoInfoVo->languageCode = "en";
			$seoInfoLang = $this->seoInfoLangService->selectByFilter($this->seoInfoVo);
		}
		$seoInfoLang[0]->description = str_replace(array('<p>', '</p>'), array('', ''), $seoInfoLang[0]->description);
		$this->seoInfoVo = $seoInfoLang [0];
	}
}