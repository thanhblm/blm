<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
use core\utils\ActionUtil;
use frontend\controllers\ControllerHelper;

$products = RequestUtil::get ( 'products' );
if(count($products)>0){
?>
<table class="table" id="tabel_product_search">
	<thead>
		<tr>
			<th><?=Lang::get('Part Number')?></th>
			<th><?=Lang::get('Description')?></th>
			<th><?=Lang::get('Price')?></th>
			<th><?=Lang::get('Quantity')?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($products as $product){
	?>
		<tr class="prod">
			<td class="code"><?=$product->id?></td>
			<td class="name"><?=$product->name?></td>
			<td class="price" price="<?=$product->price?>"><?=ControllerHelper::showProductPrice($product->price)?></td>
			<td class="qty"><input name="qty" value="0"
				type="number" min="0"></td>
		</tr>
	<?php }?>
	</tbody>
</table>
<div>
	<?php 
	$button = new Button();
	$button->title = Lang::get("Add to Cart");
	$button->attributes = "type='button' onclick='addToCart()'";
	$button->class = "button green";
	$button->render();
	?>
</div>
<?php 
}else{
?>
<div><?=Lang::get('No data available...')?> </div>
<?php
}?>
<script type="text/javascript">
function addToCart(){
	$("#tabel_product_search tr").each(function(index){
		var id = $(this).find("td").eq(0).html();
		var name = $(this).find("td").eq(1).html();
		var price = $(this).find("td").eq(2).attr("price");
		var qty = $(this).find("input[name='qty']").val();
		if(qty != undefined && qty >0){
			var data = "productId="+id+"&productPrice="+price+"&productQuantity="+qty+"&index=0";
			simpleAjaxPost(
				guid(),
				"<?=ActionUtil::getFullPathAlias("customer/salesrep/cart/content/tr?rtype=json")?>",
				data,
				onAddToCartOrderSuccess,
				onAddToCartOrderErrors,
				onAddToCartOrderErrors
			);
			$(this).find("input[name='qty']").val(0);
		}
	});
	
}
function onAddToCartOrderSuccess(res){
	$("#table_cart_content tbody").prepend(res.content);
}
function onAddToCartOrderErrors(res){
	showMessage(res.errorMessage, 'error');
}
</script>