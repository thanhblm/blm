<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\SessionUtil;
use common\rule\url\friendly\ProductUrlFriendly;
use frontend\controllers\ControllerHelper;
use core\utils\AppUtil;
use frontend\service\CartHelper;

// Update order product name if the language changed.
CartHelper::updateOrderProductName();

$listOrderProduct = null;
$symbol = "";
if(!is_null(SessionUtil::get("listOrderProduct"))){
	$listOrderProduct = SessionUtil::get("listOrderProduct")->getArray();
}
$totalQuantity = 0;
if(isset($listOrderProduct) && count($listOrderProduct) > 0){
	$symbol = $listOrderProduct[0]->symbol;
?>
<div id="scroll-container" class="scrollable endoca-skin" tabindex="-1">
	<div class="scroll-bar vertical" style="height:200px; display: none;">
		<div class="thumb" style="top: 0px; height: 200px;"></div>
	</div>
	<div class="viewport" style="height: 200px; overflow: auto">
		<div class="overview" style="top: 0px;">
			<ul class="product-list">
			<?php
			$totalPrice = 0;
			foreach ($listOrderProduct as $orderProduct){
				$totalPrice = ($totalPrice + $orderProduct->price);
				$imageMo = DatoImageHelper::getImageInfoById(json_decode($orderProduct->productImage)[0]);
			?>
				<li><div class="image">
						<img src="<?= DatoImageHelper::getSmallImageUrl($imageMo)?>" alt="" width="38" height="51">
					</div>
					<a class="title" href="<?=ActionUtil::getFullPathAlias("product/detail?id=$orderProduct->productId",new ProductUrlFriendly($orderProduct->languageCode, $orderProduct->productId, $orderProduct->seoUrl, $orderProduct->name))?>"><?=$orderProduct->name ?></a><strong><?=$orderProduct->quantity ?> x <span class="green"><?=ControllerHelper::showProductPrice($orderProduct->price/$orderProduct->quantity)?></span></strong><a
					class="close" href="javascript:shoppingCartUpdate(<?=$orderProduct->productId ?>, -<?=$orderProduct->quantity?>)"></a>
				<div class="clear"></div></li>
			<?php
                $totalQuantity += $orderProduct->quantity;
			}
			?>
			</ul>
		</div>
	</div>
	<div class="scroll-bar horizontal">
		<div class="thumb"></div>
	</div>
</div>
<div class="total">
	<?=Lang::get("Total:") ?> <span class="green"><?=ControllerHelper::showProductPrice($totalPrice)?></span><a class="button green" href="<?=ActionUtil::getFullPathAlias("home/cart/checkout/view", new AliasUrlFriendly("shopping-cart")) ?>"><?=Lang::get("Checkout") ?></a>
	
</div>
<div class="free-shipping-left">
	<p style="padding-top: 15px; color: #0E4145;">
	<?php
		$freeShippingAmount = AppUtil::defaultIfEmpty(ControllerHelper::getRegion()->freeShippingAmount,0);
		$freeShippingTill = $freeShippingAmount - $totalPrice;
		if($freeShippingTill > 0){
		?>
		<strong><?=Lang::getWithFormat("Only {0} left till free Shipping",ControllerHelper::showProductPrice($freeShippingTill)) ?></strong>
		<?php 
		}
	?>
		
	</p>
</div>
<?php 	
}else{ 
?>
<div class="icon no-basket"></div>
<p><?=Lang::get("Your shopping basket is empty, add something or drag to it and continue shopping!") ?></p>
<?php 
}
?>
<script type="text/javascript">
$(document).ready(function(){
    $("span.cart-count").html(<?=$totalQuantity?>);
});
</script>



	
