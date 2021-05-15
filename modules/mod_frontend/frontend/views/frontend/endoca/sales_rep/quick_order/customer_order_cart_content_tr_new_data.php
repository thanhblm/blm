<?php
use common\template\extend\Select;
use common\template\extend\SelectInput;
use core\utils\RequestUtil;
use frontend\controllers\ControllerHelper;
use core\Lang;

$products = RequestUtil::get('products');
?>
<tr class='new_item'>
	<td class="item">
		<select class="product_select" id="new_product">
			<option price="" value=""></option>
			<?php 
			foreach ($products as $product){
				?>
			<option price="<?=ControllerHelper::showProductPrice($product->price)?>" value="<?=$product->id?>"><?=$product->name?></option>
				<?php
			}
			?>
		</select>
	</td>
	<td class="qty">
		<input type="number" min="0" onclick="clickNewQuantity()" id="new_quantity" value="" placeholder="Quantity...">
	</td>
	<td class="price">
		<input type="hidden" value="" name="cartContents[0][productPrice]" /> 
		<span id="new_price" class="product_price"></span>
	</td>
	<td class="action">
		<input type="hidden" class="is_delete" value="no" name="cartContents[0][isDelete]"/>
		<button type="button" class="delete_item" style="display: none"><span><?=Lang::get('Delete')?></span></button>
		<button type="button" class="undo_item" style="display: none;">
			<span><?=Lang::get('Undo')?></span>
		</button>
	</td>
</tr>