<?php

namespace backend\controllers\payment;

use common\persistence\extend\vo\LanguageExtendVo;
use common\services\language\LanguageService;
use common\services\order\OrderStatusService;
use common\vo\region\payment_method\bank_transfer\BankTransferLangTextVo;
use common\vo\region\payment_method\bank_transfer\BankTransferSettingVo;
use core\BaseArray;
use core\config\ApplicationConfig;
use core\Controller;
use core\utils\AppUtil;
use core\utils\JsonUtil;

class BankTranferSettingController extends Controller {
	public $orderStatuses;
	public $setting;
	public $regionPaymentMethodSetting;
	private $orderStatusService;
	private $languageService;
	public function __construct() {
		parent::__construct ();
		$this->regionPaymentMethodSetting = new BankTransferSettingVo ();
		$this->orderStatusService = new OrderStatusService ();
		$this->languageService = new LanguageService ();
	}
	public function editView() {
		$this->prepareOrderStatuses ();
		if (! AppUtil::isEmptyString ( $this->setting )) {
			// $this->setting = base64_decode ( $this->setting );
			// $this->regionPaymentMethodSetting = unserialize ( $this->setting );
			$this->regionPaymentMethodSetting = JsonUtil::base64Decode ( $this->setting );
		}
		$this->prepareLangInfoTexts ();
		return "success";
	}
	public function edit() {
		$this->prepareOrderStatuses ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// $this->setting = serialize ( $this->regionPaymentMethodSetting );
		// $this->setting = base64_encode ( $this->setting );
		$this->setting = JsonUtil::base64Encode ( $this->regionPaymentMethodSetting );
		$this->addExtraData ( "setting", $this->setting );
		$this->addExtraData ( "statusId", $this->regionPaymentMethodSetting->status );
		$this->addExtraData ( "statusName", AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $this->regionPaymentMethodSetting->status ) );
		return "success";
	}
	private function validate() {
	}
	private function prepareOrderStatuses() {
		$this->orderStatuses = $this->orderStatusService->getAll ();
	}
	private function prepareLangInfoTexts() {
		$filter = new LanguageExtendVo ();
		$filter->status = "active";
		$filter->order_by = "code asc";
		$languages = $this->languageService->getLanguageByFilter ( $filter );
		$langInfoTexts = new BaseArray ( BankTransferLangTextVo::class );
		if (! empty ( $languages )) {
			$infoTextMap = AppUtil::mapFromArray ( $this->regionPaymentMethodSetting->infoTexts->getArray (), "langCode" );
			foreach ( $languages as $language ) {
				if (! isset ( $infoTextMap [$language->code] )) {
					$langInfoText = new BankTransferLangTextVo ();
					$langInfoText->langCode = $language->code;
					$langInfoText->langName = $language->name;
					$langInfoText->flag = $language->flag;
					$langInfoText->info = "";
				} else {
					$langInfoText = $infoTextMap [$language->code];
				}
				$langInfoTexts->add ( $langInfoText );
			}
		}
		$this->regionPaymentMethodSetting->infoTexts = $langInfoTexts;
	}
}