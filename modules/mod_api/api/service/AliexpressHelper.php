<?php

namespace api\service;

use api\common\AliexpressConstants;
use common\persistence\base\vo\AttributeVo;
use common\persistence\extend\vo\AttrGroupExtendVo;
use common\utils\StringUtil;
use core\BaseArray;
use core\utils\AppUtil;
use core\utils\FileUploadUtil;
use filemanager\persistence\base\vo\ImageVo;
use filemanager\services\filemanager\ImageService;
use filemanager\utils\FileManagerHelper;

class AliexpressHelper{
	public static function getProductMinPrice($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_MIN_PRICE);
		} catch (\Exception $ex) {
			return 0;
		}
	}

	public static function getProductMaxPrice($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_MAX_PRICE);
		} catch (\Exception $ex) {
			return 0;
		}
	}

	public static function getProductCurrencyCode($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_BASE_CURRENCE_CODE);
		} catch (\Exception $ex) {
			return "USD";
		}
	}

	public static function getProductId($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_ID);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductTitleAttribute($html){
		try {
			return StringUtil::getContentLineByKeywordJson($html, AliexpressConstants::ALIEXPRESS_PRODUCT_SIZE_PARAMS);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductAttributes($html){
		try {
			return StringUtil::getContentLineByKeywordJsonV($html, AliexpressConstants::ALIEXPRESS_PRODUCT_ATTR);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductCategory($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_CATEGORY);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductOrderTotal($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_TOTAL_ORDER);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductDescription($html){
		try {
			return file_get_contents(StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_DESCRIPTION));
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductDiscount($html){
		try {
			return StringUtil::getContentLineByKeyword($html, AliexpressConstants::ALIEXPRESS_PRODUCT_DISCOUNT_VALUE);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductImages($html){
		try {
			return StringUtil::getContentLineByKeywordJsonV($html, AliexpressConstants::ALIEXPRESS_PRODUCT_IMAGES);
		} catch (\Exception $ex) {
			return "";
		}
	}

	public static function getProductTitle($html){
		$title = StringUtil::getContentByTagName($html, "title");
		return explode(" from ", $title)[0];
	}

	public static function getProductShortDescript($html){
		return StringUtil::getContentByMeta($html, "description");
	}

	public static function getProductTag($html){
		return StringUtil::getContentByMeta($html, "keywords");
	}

	public static function getProductDiscountTimeLeft($html){
		$dayLeft = StringUtil::getContentByTagFullName($html, 'span class="p-eventtime-left"', "span");
		$dayLeft = trim($dayLeft);
		$dayLeft = explode(" ", $dayLeft)[0];
		return $dayLeft;
	}

	public static function importImageFromUrl($fileOnline, $pid, $extName = null){
		$imageId = "";
		$fileTemp = self::addToFiles($fileOnline, $extName);
		$pid = AppUtil::isEmptyString($pid) ? "default" : $pid;
		$imageService = new ImageService();
		$cfgs = FileManagerHelper::getProfileCfg($pid);

		$types = $fileTemp['type'];
		$names = $fileTemp['name'];
		$tmps = $fileTemp['tmp_name'];

		for ($i = 0; $i < count($names); $i++) {
			$fileInfo = FileUploadUtil::prepareFileInfo($names [$i], $tmps [$i]);
			$newFileName = $fileInfo ['filename'] . $fileInfo ['extension'];
			if ($cfgs ['filename.random']) {
				$newFileName = uniqid() . $fileInfo ['extension'];
			}
			$imageVo = new ImageVo();
			$imageVo->fileName = $newFileName;
			$imageVo->profile = $pid;
			$imageVos = $imageService->selectByFilter($imageVo);
			// detect to upload image if missing
			$oldImageVo = null;
			$isUpload = false;
			if (count($imageVos) > 0) {
				if ($imageVos [0]->status == 'active') {
					$isUpload = true;
					$oldImageVo = $imageVos [0];
					$imageId = $oldImageVo->id;
				} else {
					$isUpload = false;
				}
			} else {
				$isUpload = true;
			}
			$isImage = true;

			if ($isUpload) {
				$imageVo = new ImageVo ();
				$imageVo->fileName = $newFileName;
				$imageVo->mineType = $types [$i];
				$imageVo->profile = $pid;
				$imageVo->relativePath = FileManagerHelper::getRelativepath($cfgs, "");
				if ($isImage) {
					$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath($cfgs, "small");
				} else {
					$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath($cfgs, "small");
				}
				$imageVo->relativeMediumPath = FileManagerHelper::getRelativepath($cfgs, "medium");
				$imageVo->relativeLargePath = FileManagerHelper::getRelativepath($cfgs, "large");

				$sourceFile = FileManagerHelper::getRealpath($cfgs) . $newFileName;

				file_put_contents($sourceFile, file_get_contents($fileOnline));

				if ($isImage) {
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "small") . $newFileName, FileManagerHelper::getWidth($cfgs, "small"));
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "medium") . $newFileName, FileManagerHelper::getWidth($cfgs, "medium"));
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "large") . $newFileName, FileManagerHelper::getWidth($cfgs, "large"));
				}
				if (!isset ($oldImageVo)) {
					$imageVo->crDate = date('Y-m-d H:i:s');
					$imageVo->mdDate = date('Y-m-d H:i:s');
					$imageVo->crBy = 0;
					$imageVo->mdBy = 0;
					$imageVo->status = 'active';
					$imageId = $imageService->createImage($imageVo);
				} else {
					$imageVo->id = $oldImageVo->id;
					$imageVo->mdDate = date('Y-m-d H:i:s');
					$imageVo->mdBy = 0;
					$imageVo->status = 'active';
					$imageService->updateDynamicByKey($imageVo);
					$imageId = $imageVo->id;
				}
			}
		}
		return $imageId;
	}

	function addToFiles($url, $extName = null){
		$tempName = tempnam(sys_get_temp_dir(), 'UL_IMAGE');
		$originalName = basename(parse_url($url, PHP_URL_PATH));
		$imgRawData = file_get_contents($url);
		file_put_contents($tempName, $imgRawData);
		$fileTmp = array();
		$fileTmp['name'][] = $extName . "_" . $originalName ;
		$fileTmp['type'][] = mime_content_type($tempName);
		$fileTmp['tmp_name'][] = $tempName;
		$fileTmp['error'][] = 0;
		$fileTmp['size'][] = strlen($imgRawData);
		return $fileTmp;
	}

	public static function loadAttributes($html){
		$dom = new \DOMDocument();
		$dom->loadHTML($html);

		$divs = $dom->getElementById('j-product-info-sku');

		$listArrayAttrGroup = new BaseArray(AttrGroupExtendVo::class);
		foreach ($divs->childNodes as $node) {
			if ($node->tagName == "dl") {
				$dts = $node->getElementsByTagName("dt");

				$i = 0;
				foreach ($dts as $dt) {
					$attrGroupVo = new AttrGroupExtendVo();
					$attrGroupVo->name = str_replace(":", "", $dt->textContent);
					$attrGroupVo->description = str_replace(":", "", $dt->textContent);
					$attrGroupVo->order = $i;
					$i = $i + 1;

					$dd = $dt->parentNode->getElementsByTagName("dd");
					$lis = $dd[0]->getElementsByTagName("li");
					$attrGroupVo->isChoice = 1;
					$j = 0;
					foreach ($lis as $li) {
						if ($li->getAttribute('class') == "item-sku-image") {
							$a = $li->getElementsByTagName("a")[0];
							$image = $a->getElementsByTagName("img")[0];
							$urlImage = $image->getAttribute('bigpic');
							$attributeVo = new AttributeVo();
							$attributeVo->code = $a->getAttribute('data-sku-id');
							$attributeVo->name = $a->getAttribute('title');
							$attributeVo->description = $a->getAttribute('title');
							$attributeVo->order = $j;
							$attributeVo->type = "image";
							$attributeVo->image = $urlImage;
							$attrGroupVo->listAttr->add($attributeVo);
						} else {
							$a = $li->getElementsByTagName("a")[0];
							$attributeVo = new AttributeVo();
							$attributeVo->code = $a->getAttribute('data-sku-id');
							$attributeVo->name = $a->textContent;
							$attributeVo->description = $a->textContent;
							$attributeVo->order = $j;
							$attributeVo->type = "content";
							$attrGroupVo->listAttr->add($attributeVo);
						}
						$j = $j + 1;
					}
					$listArrayAttrGroup->add($attrGroupVo);
				}
			}
		}
		return $listArrayAttrGroup;
	}
}