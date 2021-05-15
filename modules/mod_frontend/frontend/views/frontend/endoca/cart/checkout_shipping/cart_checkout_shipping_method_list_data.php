<?php
use common\utils\StringUtil;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use common\template\extend\Text;
use common\config\RegionEnum;
use frontend\controllers\ControllerHelper;

$shippingMethods = RequestUtil::get ( "shippingMethods" );
$shippingMethodItem = "";
$order = SessionUtil::get("order");
if(isset($order->shippingMethodItem)){
	$shippingMethodItem = $shippingMethodItem;
}
$isFreeShipping = RequestUtil::get ( "isFreeShipping" );

?>
<h2
	<?php
	if (strlen ( RequestUtil::getFieldError ( "order[shippingMethod]" ) ) > 0) {
		?>
		style="color: red;" <?php

	}
	?>>
	<?= Lang::get("Shipping Method") ?></h2>
<div class="box col-xs-12 shipping_box">

	<?php

	$text = new Text ();
	$text->type = "hidden";
	$text->id = "hid_value_object";
	$text->name = "order[shippingMethodItem]";
	$text->value = $order->shippingMethodItem;
	$text->render ();

	if (!empty($shippingMethods)){
		foreach ( $shippingMethods as $shippingMethod ) {
			try {
				$file = StringUtil::loadViewCheckoutMethod ( $shippingMethod->id );
				include $file;
			} catch ( Exception $e ) {
				DatoLogUtil::trace ( $file );
				DatoLogUtil::error ( $e );
			}
		}
	}else{?>
		<?php echo Lang::get("No shipping methods available for selected destination.")?>
	<?php }?>


</div>