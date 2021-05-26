<?php
use common\template\extend\Select;
use core\utils\RequestUtil;
use frontend\controllers\ControllerHelper;
use core\Lang;
$products = RequestUtil::get('products');
$productId = RequestUtil::get('productId');
$productPrice = RequestUtil::get('productPrice');
$productQuantity = RequestUtil::get('productQuantity');
$index = RequestUtil::get("index");
?>
<tr class="cart_item">
	<td class="item">
		<select class="product_select" id="cartContents[<?=$index?>][productId]" name="cartContents[<?=$index?>][productId]">
			<option price="" value=""></option>
			<?php 
			foreach ($products as $product){
				?>
			<option <?=$product->id==$productId?'selected':''?> price="<?=ControllerHelper::showProductPrice($product->price)?>" value="<?=$product->id?>"><?=$product->name?></option>
				<?php
			}
			?>
		</select>
	</td>
	<td class="qty">
		<input type="number" min="0" name="cartContents[<?=$index?>][productQuantity]" value="<?=$productQuantity?>" placeholder="Quantity...">
	</td>
	<td class="price">
		<input type="hidden" name="cartContents[<?=$index?>][productPrice]" value="<?=$productPrice?>"/>
		<span class="product_price"><?=ControllerHelper::showProductPrice($productPrice)?></span>
	</td>
	<td class="action">
		<input type="hidden" class="is_delete" value="no" name="cartContents[0][isDelete]"/>
		<button type="button" class="delete_item"><span><?=Lang::get('Delete')?></span></button>
		<button type="button" class="undo_item" style="display: none;">
			<span><?=Lang::get('Undo')?></span>
		</button>
	</td>
</tr>