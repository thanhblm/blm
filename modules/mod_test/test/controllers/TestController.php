<?php

namespace test\controllers;

use common\helper\SettingHelper;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\order\OrderService;
use core\BaseArray;
use core\config\ApplicationConfig;
use core\Controller;
use core\Lang;
use core\utils\AppUtil;
use core\utils\PhpFileUtil;
use core\utils\SessionUtil;
use core\utils\TagUtil;
use frontend\model\ShoppingCartModel;
use frontend\service\CartHelper;
use frontend\service\DiscountHelper;

class TestController extends Controller {
	public function getPriceLevel() {
		var_dump ( DiscountHelper::getPriceLevel ( 1 ) );
		return null;
	}
	public function getBulkDiscount() {
		var_dump ( DiscountHelper::getBulkDiscount ( 42, 3 ) );
		return null;
	}
	public function getDiscountCoupon() {
		$shoppingCart = new ShoppingCartModel ();
		// Add product list.
		$productList = new BaseArray ( OrderProductVo::class );
		// Add product 1.
		$orderProductVo = new OrderProductVo ();
		$orderProductVo->productId = 49;
		$orderProductVo->basePrice = 100;
		$orderProductVo->price = 90;
		$orderProductVo->quantity = 2;
		$productList->add ( $orderProductVo );
		// Add product 2.
		$orderProductVo = new OrderProductVo ();
		$orderProductVo->productId = 42;
		$orderProductVo->basePrice = 200;
		$orderProductVo->price = 100;
		$orderProductVo->quantity = 3;
		$productList->add ( $orderProductVo );
		$shoppingCart->products = $productList;
		// Add order info.
		$orderVo = new OrderVo ();
		$orderVo->currencyCode = "usd";
		$orderVo->customerId = 1;
		$shoppingCart->subTotal = 100;
		$shoppingCart->order = $orderVo;
		$shoppingCart->order->couponCode = "endoca440725";
		var_dump ( DiscountHelper::getDiscountCoupon ( $shoppingCart ) );
		return null;
	}
	public function getLang() {
		SessionUtil::set ( "language.default.code", "fr" );
		$settingValue = SettingHelper::getSettingValue ( "Notice" );
		var_dump ( $settingValue );
		var_dump ( Lang::getWithFormat ( $settingValue ) );
		return null;
	}
	public function updateShoppingCart() {
		$shoppingCart = new ShoppingCartModel ();
		// Add product list.
		$productList = new BaseArray ( OrderProductVo::class );
		// Add product 1.
		$orderProductVo = new OrderProductVo ();
		$orderProductVo->productId = 49;
		$orderProductVo->basePrice = 100;
		$orderProductVo->price = 90;
		$orderProductVo->quantity = 2;
		$productList->add ( $orderProductVo );
		// Add product 2.
		$orderProductVo = new OrderProductVo ();
		$orderProductVo->productId = 42;
		$orderProductVo->basePrice = 200;
		$orderProductVo->price = 100;
		$orderProductVo->quantity = 3;
		$productList->add ( $orderProductVo );
		$shoppingCart->products = $productList;
		// Add order charges.
		$charges = new OrderChargeInfoVo ();
		$charges->subTotalAmount = 200;
		// Add order info.
		$orderVo = new OrderVo ();
		$orderVo->currencyCode = "USD";
		$orderVo->customerId = 1;
		$shoppingCart->charges = $charges;
		$shoppingCart->order = $orderVo;
		$shoppingCart->order->couponCode = "test01";
		$updateShoppingCart = CartHelper::updateShoppingCart ( $shoppingCart );
		var_dump ( $updateShoppingCart );
	}
	public function getReplaceTag() {
		$tags = "first_name:firstName;lastname:lastName;email:email;password:password";
		$string = '<p>Hello $(first_name),<br> Someone (You) requested a password reset for your account.<br> Your new password is: $(password)<br> You can login from here <a href="https://www.endoca.com/">https://www.endoca.com/</a></p><p>Warm Regards,</p><p>The Endoca Team</p><p>�</p><p>If you have any questions regarding your order, please contact us:</p><p><span style="font-weight: bold;">Phone USA:</span> 001 619 831 0156</p><p><span style="font-weight: bold;">Phone EU:</span> 0045 898 707 00</p><p><span style="font-weight: bold;">Email:</span> <a href="mailto:info@endoca.com">info@endoca.com</a></p><p>�</p>';
		$object = new \stdClass ();
		$object->firstName = "dattrinh";
		$object->password = "123123";
		echo TagUtil::replaceTags ( $string, $tags, $object, true );
		$object = new \stdClass ();
		$object->firstname = "dattvhp";
		$object->unsubscribe = "<a href=\"http:\\\\dantri.com.vn\">Click here to unsubscriber</a>";
		echo TagUtil::replaceTags ( "Dear $(firstname), greetings from Endoca!Thank you for registering with Endoca.You can purchase the purest quality hemp products online at www.endoca.com.We hope our products will provide you the best experience and satisfaction.Warm Regards,The Endoca TeamEndoca always wants to ensure we have your permission to contact you via email. If you ever want to stop hearing from us you can click $(unsubscribe) and you will no longer receive our updates.", "firstname:First Name;unsubscribe:Unsubscribe", $object, true );
		return null;
	}
	public function getClasses() {
		$fileName = "D:\\xampp\\htdocs\\endoca\\modules\\mod_common\\common\\rule\\url\\friendly\\DeCategoryFriendlyUrl.php";
		AppUtil::debugInfo ( PhpFileUtil::getInterfaceFileContent ( $fileName ) );
		return null;
	}
	public function startWith() {
		$string = "private function startWith(\$a, \$b);";
		if (AppUtil::startsWith ( $string, "private" )) {
			echo "String start with private";
		} else {
			echo "String no start with private";
		}
		return null;
	}
	public function endWith() {
		$string = "private function startWith(\$a, \$b);";
		if (AppUtil::endsWith ( $string, "private" )) {
			echo "String end with private";
		} else {
			echo "String no end with private";
		}
		return null;
	}
	public function parsePhpFile() {
		// $filePathName = "D:\\xampp\\htdocs\\endoca\\modules\\mod_common\\common\\persistence\\base\\mapping\\BackendMenuMapping.php";
		// $filePathName = "D:\\xampp\\htdocs\\endoca\\modules\\mod_common\\common\\rule\\url\\friendly\\DeCategoryFriendlyUrl.php";
		$filePathName = "D:\\xampp\\htdocs\\endoca\\modules\\mod_common\\common\\helper\\AddressHelper.php";
		echo PhpFileUtil::getInterfaceFileContext2 ( $filePathName );
		return null;
	}
	public function testPendingOrder(){
		$orderSv = new OrderService();
		$orderVo = new OrderExtendVo();
		$orderVo->startDate = ApplicationConfig::get("pending.order.startdate");
		$orderVos = $orderSv->getPendingOrders($orderVo);
		AppUtil::debugInfo($orderVos);
	}
}