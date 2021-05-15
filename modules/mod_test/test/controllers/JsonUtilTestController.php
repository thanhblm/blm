<?php

namespace test\controllers;

use common\persistence\base\vo\AddressVo;
use common\vo\region\payment_method\bank_transfer\BankTransferLangTextVo;
use common\vo\region\payment_method\bank_transfer\BankTransferSettingVo;
use core\utils\JsonUtil;
use common\services\address\AddressService;
use core\utils\AppUtil;

class JsonUtilTestController {
	public function __construct() {
	}
	public function serialize() {
		$object = new BankTransferSettingVo ();
		$object->status = "active";
		$object->pendingOrderStatus = "paid";
		$infoText = new BankTransferLangTextVo ();
		$infoText->langCode = "en";
		$infoText->langName = "English";
		$infoText->flag = "en";
		$infoText->info = "English Text";
		$object->infoTexts->add ( $infoText );
		$encryptJson = JsonUtil::base64Encode ( $object );
		var_dump ( $encryptJson );
		var_dump ( JsonUtil::base64Decode ( $encryptJson ) );
		die ();
	}
	public function deserialize() {
		$jsonString = '{"status":"active","pendingOrderStatus":"paid","infoTexts":{"type":"common\\\/vo\\\/region\\\/payment_method\\\/bank_transfer\\\/BankTransferLangTextVo","elements":[{"langCode":"en","langName":"English","flag":"en","info":"English Text"}]}}';
		$object = json_decode ( $jsonString );
		var_dump ( $jsonString );
		var_dump ( $object );
		die ();
	}
	public function useJsonObject() {
		$addressVo = new AddressVo ();
		$addressVo->id = 123;
		$addressVo->country = 417;
		$addressVo->state = 90;
		$innerAddress = new AddressVo ();
		$innerAddress->id = 345;
		$innerAddress->country = 41;
		$addressVo->innerAddress = $innerAddress;
		$jsonStr = JsonUtil::encode ( $addressVo );
		var_dump ( $jsonStr );
		$decodeObject = JsonUtil::decode ( $jsonStr );
		var_dump ( $decodeObject );
		// Insert address.
		$newAddress = new AddressVo ();
		$newAddress->innerAddress = new AddressVo ();;
		AppUtil::perfectCopyProperties($decodeObject, $newAddress);
		var_dump($newAddress);
		//$addressService = new AddressService ();
		//$addressService->createAddress ( $newAddress );
		return null;
	}
}