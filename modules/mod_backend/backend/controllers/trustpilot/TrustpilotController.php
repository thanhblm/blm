<?php

namespace backend\controllers\trustpilot;

use common\helper\DatoImageHelper;
use common\helper\SettingHelper;
use common\persistence\base\vo\LanguageVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\dao\OrderProductExtendDao;
use common\rule\url\friendly\ProductUrlFriendly;
use common\services\language\LanguageService;
use common\services\order\OrderService;
use common\services\product\ProductService;
use core\PagingController;
use core\utils\ActionUtil;
use core\utils\EmailUtil;
use frontend\controllers\ControllerHelper;

class TrustpilotController extends PagingController {
	private $orderService;
	public $orders;
	public function __construct() {
		parent::__construct ();
		$this->orderService = new OrderService ();
		$this->orders = new OrderVo ();
	}
	public function trustpilot() {
		$this->orders = $this->orderService->getPaidOrdersTwoWeeksAgo ();
		// var_dump($this->orders);die;
		if (! empty ( $this->orders )) {
			foreach ( $this->orders as $order ) {
				// Trustpilot
				$regionVo = ControllerHelper::getRegion ();
				$languageVo = new LanguageVo ();
				$languageService = new LanguageService ();
				$languageVo->code = $order->languageCode;
				$languageVo = $languageService->getLanguageByCode ( $languageVo );
				
				$recipientEmail = $order->billEmail;
				$recipientName = $order->billFirstname . " " . $order->billLastname;
				$referenceId = "";
				$templateId = "5926849193e65801e02dd097";
				$locale = $languageVo->localeName;
				$senderEmail = $regionVo->contactEmail;
				$senderName = "";
				$replyTo = $regionVo->contactEmail;
				$preferredSendTime = "";
				
				$products = "";
				$product = ( object ) array (
						"productUrl" => null,
						"imageUrl" => null,
						"name" => null 
				);
				
				$orderProductVo = new OrderProductVo ();
				$orderProductDao = new OrderProductExtendDao ();
				$orderProductVo->orderId = $order->id;
				$orderProducts = $orderProductDao->selectByFilter ( $orderProductVo );
				// var_dump($orderProducts);
				$i = 0;
				if (! empty ( $orderProducts )) {
					foreach ( $orderProducts as $orderProduct ) {
						// var_dump($orderProduct->productId);
						$productVo = new ProductVo ();
						$productVo->id = $orderProduct->productId;
						$productService = new ProductService ();
						$productVos = $productService->getProductByKey ( $productVo );
						// var_dump($productVos);die;
						
						$seperator = ",";
						if ($i >= count ( $orderProducts ) - 1)
							$seperator = "";
						$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $orderProduct->productImage ) [0] );
						$seoUrl = ActionUtil::getFullPathAlias ( "product/detail?id=$orderProduct->productId", new ProductUrlFriendly ( $orderProduct->languageCode, $orderProduct->productId, $orderProduct->seoUrl, $orderProduct->name ) );
						$product->productUrl = $seoUrl;
						$product->imageUrl = DatoImageHelper::getUrl ( $imageMo );
						$product->name = $orderProduct->name;
						$productEncode = json_encode ( $product );
						$productEncode = str_replace ( "\/", "/", $productEncode );
						$products .= $productEncode . $seperator;
						$i ++;
					}
				}
				$products = "[" . $products . "]";
				
				$trustpilot_script = '<script type="application/json+trustpilot">
								{
								  "recipientEmail": "' . $recipientEmail . '",
								  "recipientName": "' . $recipientName . '",
								  "referenceId": "' . $referenceId . '",
								  "templateId": "' . $templateId . '",
								  "locale": "' . $locale . '",
								  "senderEmail": "' . $senderEmail . '",
								  "senderName": "' . $senderName . '",
								  "replyTo": "' . $replyTo . '",
								  "preferredSendTime": "' . $preferredSendTime . '",
								  "tags": ["",""],
								  "products":' . $products . '
								 }
								</script>';
				// End trustpilot
				\DatoLogUtil::devInfo ( "TRUSTPILOT: " . $trustpilot_script );
				$subject = "";
				$body = $trustpilot_script;
				$toEmail = SettingHelper::getSettingValue ( "Email trust pilot" );
				$fromEmail = $regionVo->contactEmail;
				$result = EmailUtil::sendMail ( $subject, $body, $toEmail, array (), array (), array (), $fromEmail );
				if ($result) {
					$order->trustpilotSent = "yes";
					$this->orderService->updateOrder($order);
				}
			}
		}
		return "success";
	}
}