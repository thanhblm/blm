<?php

use common\persistence\base\vo\ProductAttributeVo;
use common\template\extend\Text;
use common\utils\StringUtil;
use core\utils\RequestUtil;
use frontend\controllers\ControllerHelper;

$product = RequestUtil::get('product');
$bulkDiscounts = RequestUtil::get('bulkDiscounts');

$productAttribute = new ProductAttributeVo ();
if (!is_null(RequestUtil::get("productAttribute"))) {
	$productAttribute = RequestUtil::get("productAttribute");
}

$discount = 0;
if (count($bulkDiscounts) > 0) {
	foreach ($bulkDiscounts as $bulkDiscount) {
		if (($bulkDiscount->discount) > $discount) {
			$discount = $bulkDiscount->discount;
		}
	}
}

if (RequestUtil::hasActionMessages()) {
	?>
	<div id="alert_info" class="alert alert-info" role="alert">
		<?= RequestUtil::getActionMessage() ?>
	</div>
	<?php
}
if (RequestUtil::hasActionErrors()) {
	?>
	<div class="alert alert-danger" role="alert">
		<?= RequestUtil::getErrorMessage(); ?>
	</div>

	<?php
}
?>
<?php
$text = new Text();
$text->type = "hidden";
$text->id = "productAttributeId";
$text->name = "productAttribute[id]";
$text->value = $productAttribute->id;
$text->render();
if ($productAttribute->price != null) {
	if ($discount > 0) {
		$price_discount = StringUtil::calculatePerPrice($discount, $productAttribute->price);
		$new_price = $productAttribute->price - $price_discount;
		?>
		<p class="number-font price margin_bottom_40">
			<span class="new"><?= ControllerHelper::showProductPrice($new_price) ?></span>
			<span class="old"><?= ControllerHelper::showProductPrice($productAttribute->price) ?></span>
		</p>
		<?php
	} else {
		?>
		<p class="number-font price margin_bottom_40">
			<span class="new"><?= ControllerHelper::showProductPrice($productAttribute->price) ?></span>
		</p>
		<?php
	}

} else if ($product->price === $product->basePrice) {
	if ($discount > 0) {
		$price_discount = StringUtil::calculatePerPrice($discount, $product->basePrice);
		$new_price = $product->basePrice - $price_discount;
		?>
		<p class="number-font price margin_bottom_40">
			<span class="new"><?= ControllerHelper::showProductPrice($new_price) ?></span>
			<span class="old"><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
		</p>
		<?php
	} else {
		?>
		<p class="number-font price margin_bottom_40">
			<span class="new"><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
		</p>
		<?php
	}
}
?>
<?php
if (count($bulkDiscounts) > 0) {
	foreach ($bulkDiscounts as $bulkDiscount) {
		?>
		<p class="number-font price margin_bottom_40"><?= $bulkDiscount->name ?></p>>
		<?php
	}
}
?>
<script type="text/javascript">
    $(document).ready(function () {
		<?php
		$disiableUpdate = " disabled ";
		if (!is_null(RequestUtil::get("isEnableEditPrice"))) {
			$disiableUpdate = RequestUtil::get("isEnableEditPrice");
		}
		if ($disiableUpdate != "") {
			// echo '$(".enj-add-to-cart-btn").attr("disabled","disabled");';
		} else {
			echo '$(".enj-add-to-cart-btn").removeAttr("disabled");';
			echo '$(".enj-add-to-cart-btn").attr("data-product-attribute","' . $productAttribute->id . '");';
		}
		?>
    });
</script>