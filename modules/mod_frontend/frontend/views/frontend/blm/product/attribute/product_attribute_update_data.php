<?php

use common\persistence\base\vo\ProductAttributeVo;
use common\template\extend\Text;
use common\utils\StringUtil;
use core\utils\RequestUtil;
use frontend\controllers\ControllerHelper;

$product = RequestUtil::get('product');
$bulkDiscounts = RequestUtil::get('bulkDiscounts');

$productAttribute = new ProductAttributeVo ();
if (! is_null ( RequestUtil::get ( "productAttribute" ) )) {
	$productAttribute = RequestUtil::get ( "productAttribute" );
}

$discount= 0;
if (count ( $bulkDiscounts ) > 0) {
	foreach ( $bulkDiscounts as $bulkDiscount ) {
		if(($bulkDiscount->discount) > $discount){
			$discount= $bulkDiscount->discount;
		}
	}
}

if (RequestUtil::hasActionMessages ()) {
	?>
<div id="alert_info" class="alert alert-info" role="alert">
		<?= RequestUtil::getActionMessage() ?>
	</div>
<?php
}
if (RequestUtil::hasActionErrors ()) {
	?>
<div class="alert alert-danger" role="alert">
		<?= RequestUtil::getErrorMessage(); ?>
	</div>

<?php
}
?>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="price green">
		<?php
		$text = new Text();
		$text->type="hidden";
		$text->id="productAttributeId";
		$text->name="productAttribute[id]";
		$text->value=$productAttribute->id;
		$text->render();
		if ( $productAttribute->price != null) {
			if($discount >0){
				$price_discount= StringUtil::calculatePerPrice($discount, $productAttribute->price);
				$new_price= $productAttribute->price - $price_discount;
				?>
				<span class="new"><?= ControllerHelper::showProductPrice($new_price) ?></span>
				<span class="old"><?= ControllerHelper::showProductPrice($productAttribute->price) ?></span>
				<?php
			}else{
				?>
				<span class="new"><?= ControllerHelper::showProductPrice($productAttribute->price) ?></span>
				<?php
			}
			
		} else if ($product->price === $product->basePrice) {
			if($discount >0){
				$price_discount= StringUtil::calculatePerPrice($discount, $product->basePrice);
				$new_price= $product->basePrice - $price_discount;
				?>
					<span class="new"><?= ControllerHelper::showProductPrice($new_price) ?></span>
					<span class="old"><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
				<?php
				}else{
					?>
					<span class="new"><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
					<?php
				}
		}
		?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="ammount_offers_new">
			<?php
			if (count ( $bulkDiscounts ) > 0) {
				foreach ( $bulkDiscounts as $bulkDiscount ) {
					?>
					<div class="ammount_offer_new"><?= $bulkDiscount->name ?></div>
					<?php
				}
			}
			?>
		</div>			
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		<?php
		$disiableUpdate = " disabled ";
		if(!is_null(RequestUtil::get("isEnableEditPrice"))) {
			$disiableUpdate = RequestUtil::get("isEnableEditPrice");
		}
		if($disiableUpdate != ""){
			echo '$(".infoblock input").prop("readonly", true);';
			echo '$(".infoblock button").attr("disabled","disabled");';
			echo '$(".infoblock button").attr("style","background: #676767;");';
			echo '$(".infoblock button").attr("data-product-attribute","");';
		}else{
			echo '$(".infoblock input").prop("readonly", false);';
			echo '$(".infoblock button").removeAttr("disabled");';
			echo '$(".infoblock button").removeAttr("style");';
			echo '$(".infoblock button").attr("data-product-attribute","'.$productAttribute->id.'");';
		}
		?>
		$(".amount").find("div").unbind('click');
	});
</script>