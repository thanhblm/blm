<?php

namespace common\services\address;

use common\persistence\base\dao\CountryBaseDao;
use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\dao\AddressExtendDao;
use common\persistence\extend\vo\AddressExtendVo;
use common\services\base\BaseService;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;

class AddressService extends BaseService {
	private $extendDao;

	public function __construct($context = array()){
		parent::__construct($context);
		$this->extendDao = new AddressExtendDao ($this->context);
	}

	public function selectByKey(AddressVo $vo){
		return $this->extendDao->selectByKey($vo);
	}

	public function selectByFilter(AddressVo $vo){
		return $this->extendDao->selectByFilter($vo);
	}

	public function countByFilter(AddressVo $vo){
		return $this->extendDao->countByFilter($vo);
	}

	public function createAddress(AddressVo $vo){
		return $this->extendDao->insertDynamic($vo);
	}

	public function updateAddress(AddressVo $vo){
		return $this->extendDao->updateDynamicByKey($vo);
	}

	public function search(AddressExtendVo $vo){
		return $this->extendDao->search($vo);
	}

	public function searchCount(AddressExtendVo $vo){
		return $this->extendDao->searchCount($vo);
	}

	public function deleteAddress(AddressExtendVo $vo){
		return $this->extendDao->deleteByKey($vo);
	}

	public function selectAll(){
		return $this->extendDao->selectAll();
	}

	public function upsAddressValidation(AddressVo $address = null){
		if (is_null($address)) {
			return array(
				"status" => true,
				"errorCode" => "",
				"candidateAddress" => array(),
				"errorMessage" => ""
			);
		}
		$isUpsEnable = ApplicationConfig::get("ups.address.validation.api.enable");
		$isUpsEnable = is_null($isUpsEnable) ? false : $isUpsEnable;
		$isUpsEnable = is_bool($isUpsEnable) ? $isUpsEnable : false;

		if (!$isUpsEnable) {
			return array(
				"status" => true,
				"errorCode" => "",
				"candidateAddress" => array(),
				"errorMessage" => ""
			);
		}

		// begin check for US
		$isOK = true;
		$errorCode = "";
		$candidateAddress = array();
		$errorMessage = "";
		$upsUserName = "Endob";
		$upsPassword = "Patamy2273";
		$upsAccessLicenseNumber = "6D1FEA0A68805648";
		$maxlistSize = 10;

		$addressLine = $address->address;
		$cityName = $address->city;
		$cityName = isset ($cityName) ? trim($cityName) : "";
		$zipCode = $address->postalCode;

		$stateDao = new StateBaseDao ();
		$stateVo = new StateVo ();
		$stateVo->id = $address->state;
		if (!AppUtil::isEmptyString($address->state)) {
			$stateVo = $stateDao->selectByKey($stateVo);
		} else {
			$stateVo = null;
		}

		if (!is_null($stateVo)) {
			$stateCode = $stateVo->iso2;
		} else {
			$stateCode = "";
		}

		$countryDao = new CountryBaseDao ();
		$countryVo = new CountryVo ();
		$countryVo->id = $address->country;
		$countryVo = $countryDao->selectByKey($countryVo);
		if (!is_null($countryVo)) {
			$countryCode = $countryVo->iso2;
		} else {
			$countryCode = "";
		}

		if ($countryCode === "US") {
			if ($cityName !== "" && $stateCode !== "") {
				$data_string = "{
           \"UPSSecurity\": {
               \"UsernameToken\": {
                   \"Username\": \"" . $upsUserName . "\",
                   \"Password\": \"" . $upsPassword . "\"
               },
               \"ServiceAccessToken\": {
                   \"AccessLicenseNumber\": \"" . $upsAccessLicenseNumber . "\"
               }
           },
           \"XAVRequest\": {
               \"Request\": {
                   \"RequestOption\": \"1\",
                   \"TransactionReference\": {
                       \"CustomerContext\": \"Your Customer Context\"
                   }
               },
               \"MaximumListSize\": \"" . $maxlistSize . "\",
               \"AddressKeyFormat\": {
                \"ConsigneeName\": \"Consignee Name\",
                   \"BuildingName\": \"Building Name\",";
				$data_string .= "\"AddressLine\": \"" . $addressLine . "\",";
				$data_string .= "\"PoliticalDivision2\": \"" . $cityName . "\",";
				$data_string .= "\"PoliticalDivision1\": \"" . $stateCode . "\",";
				$data_string .= "\"PostcodePrimaryLow\": \"" . $zipCode . "\",";
				$data_string .= "\"CountryCode\": \"" . $countryCode . "\"}}}";

				$ch = curl_init('https://onlinetools.ups.com/rest/XAV');
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string)
				));
				$result = curl_exec($ch);
				$arrResult = json_decode($result, true);
				$upsApiStatus = isset ($arrResult ["XAVResponse"] ["Response"] ["ResponseStatus"] ["Code"]) ? $arrResult ["XAVResponse"] ["Response"] ["ResponseStatus"] ["Code"] : 0;
				if (($upsApiStatus == 1) && !isset ($arrResult ["XAVResponse"] ["ValidAddressIndicator"])) {
					$isOK = false;
					$errorMessage = "Invalid address! Please correct your address and try again.";
					if (isset ($arrResult ["XAVResponse"] ["AmbiguousAddressIndicator"])) {
						$errorCode = "AmbiguousAddressIndicator";

						// if (isset ( $arrResult ["XAVResponse"] ["Candidate"] )){
						// foreach ( $arrResult ["XAVResponse"] ["Candidate"] as $add ) {
						// $addStr = "";
						// if (is_array ( $add ["AddressKeyFormat"] ["AddressLine"] )) {
						// $addStr = $add ["AddressKeyFormat"] ["AddressLine"] [0];
						// $addStr = $add ["AddressKeyFormat"] ["AddressLine"] [1] . ' ' . $addStr ;
						// } else{
						// $addStr .= $add ["AddressKeyFormat"] ["AddressLine"] ;
						// }
						// //$addStr .= ', ' . $add ["AddressKeyFormat"] ["PoliticalDivision2"] ;
						// //$addStr .= '<b>State code</b>:' . $add ["AddressKeyFormat"] ["PoliticalDivision1"] ;
						// //$addStr .= '<b>Zip Code</b>:' . $add ["AddressKeyFormat"] ["PostcodePrimaryLow"] ;
						// //$addStr .= 'PostcodeExtendedLow:' . $add ["AddressKeyFormat"] ["PostcodeExtendedLow"] ;

						// $addStr .= ', ' . $add ["AddressKeyFormat"] ["Region"] ;
						// $addStr .= ', ' . $add ["AddressKeyFormat"] ["CountryCode"] ;
						// $addStr .= '' ;

						// $candidateAddress[]= $addStr;
						// }
						// }
					}
				} else {
					$isOK = true;
					$errorCode = "ValidAddressIndicator";
				}
			} else {
				$isOK = false;
				$errorMessage = Lang::get("Invalid address! Please correct your address and try again.");
			}
		}

		$result = array(
			"status" => $isOK,
			"errorCode" => $errorCode,
			"candidateAddress" => $candidateAddress,
			"errorMessage" => $errorMessage
		);
		\DatoLogUtil::debug($address);
		\DatoLogUtil::debug($result);
		/*
		 * if($isOK){
		 * $isMatch = AddressHelper::isPOBoxAddress($addressLine);
		 * if($isMatch){
		 * $result["status"] = false;
		 * $result["errorCode"] = "";
		 * $result["errorMessage"] = "Sorry, we are unable to ship to P.O. Box, please enter another address and try again.";
		 * }
		 * }
		 */
		return $result;
		// End check for US
	}
}