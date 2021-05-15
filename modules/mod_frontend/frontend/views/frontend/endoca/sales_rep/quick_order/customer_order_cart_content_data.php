<?php
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use core\utils\ActionUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;

$customers = RequestUtil::get('customers');
$products = RequestUtil::get('products');
$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
$customerChildId = -1;
if($loginCustomerInfo->isSaleRepChild){
	$customerChildId = $loginCustomerInfo->userId;
}
?>
<form id="form_cart_content">
<table class="table" id="table_cart_content">
	<thead>
		<tr>
			<th class="item"><span><?=Lang::get("Item")?></span></th>
			<th class="qty"><span><?=Lang::get("Quantity")?></span></th>
			<th class="price"><span><?=Lang::get("Price")?></span></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php include_once 'customer_order_cart_content_tr_new_data.php';?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<select name="customerId" id="customerId">
					<option value=""><?=Lang::get("-Select Customer-")?></option>
					<?php 
					foreach ($customers as $customer){
						?>
					<option value="<?=$customer->id?>" <?=$customer->id==$customerChildId ? 'selected' : ''?> ><?=$customer->firstName.' '.$customer->lastName?></option>
						<?php
					}
					?>
				</select>
			</td>
			<td>
			 	<button type="button" onclick="quickCheckOut()"><?=Lang::get("Checkout")?></button>
			</td>
		</tr>
	</tfoot>
</table>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$("#table_cart_content").delegate(".product_select","click",function(){
		var price = $(this).find("option:selected").attr("price");
		$tr = $(this).closest("tr");
		$spanPrice = $tr.find("span[class='product_price']"); 
		$spanPrice.html(price);
	});
	$("#table_cart_content").delegate(".delete_item","click",function(){
		var $tr = $(this).closest("tr");
		$tr.css( "background-color", "#ccc" );
		var inputs = $tr.find('input,select');
		$(inputs).each(function(index){
			$(this).attr("disabled", "disabled").css( "background-color", "#ccc" );
		});
		$(this).hide();
		var $undo = $tr.find("button[class='undo_item']");
		$undo.show();
		$isDelete = $tr.find("input[class='is_delete']");
		$isDelete.val('yes');
	});
	$("#table_cart_content").delegate(".undo_item","click",function(){
		var $tr = $(this).closest("tr");
		$tr.css( "background-color", "#f5f6f9" );
		var inputs = $tr.find('input,select');
		$(inputs).each(function(index){
			$(this).removeAttr('disabled').css( "background-color", "#fff" );
		});
		$(this).hide();
		var $delete = $tr.find("button[class='delete_item']");
		$delete.show();
		$isDelete = $tr.find("input[class='is_delete']");
		$isDelete.val('no');
	});
});
function quickCheckOut(){
	resetIndex();
	var data = $("#form_cart_content").serialize();
	simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("customer/salesrep/quick/order/checkout?rtype=json")?>",
			data,
			onOrderCheckoutSuccess,
			onOrderCheckoutErrors,
			onOrderCheckoutErrors
		);
}
function onOrderCheckoutSuccess(res){
	location.href = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/view")?>";
}
function onOrderCheckoutErrors(res){
	showMessage(res.errorMessage, 'error');
}
function resetIndex(){
	$("tr.cart_item").each(function(index){
		var inputs = $(this).find('input,select');
		$(inputs).each(function(index2){
			var name = $(this).attr("name");
			if(name.indexOf('productId')>0){
				$(this).attr("name","cartContents[" + index + "][productId]");
			}
			if(name.indexOf('productQuantity')>0){
				$(this).attr("name","cartContents[" + index + "][productQuantity]");
			}
			
			if(name.indexOf('productPrice')>0){
				$(this).attr("name","cartContents[" + index + "][productPrice]");
			}
			if(name.indexOf('isDelete')>0){
				$(this).attr("name","cartContents[" + index + "][isDelete]");
			}
		});
	});
}
function changeProduct(){
	var price = $("#new_product option:selected").attr("price");
	$("#new_price").html(price);
}
function clickNewQuantity(){
	if($("#new_price").html() !=""){
		var $tr = $("#new_quantity").parent().parent();
		var $delete = $tr.find("button[class='delete_item']");
		$delete.show();
		
		$(".new_item").attr('class','cart_item');
		$("#new_product").attr('name','cartContents[0][productId]');
		$("#new_product").attr('id','cartContents[0][productId]');
		
		$("#new_quantity").attr('name','cartContents[0][productQuantity]');
		$("#new_quantity").attr('id','cartContents[0][productQuantity]');
		$("#new_hidden_price").attr('name','cartContents[0][productPrice]');
		$("#new_hidden_price").attr('id','cartContents[0][productPrice]');
		//$("#new_price").attr('onclick',null);
		//$("#new_price").attr('class','price');
		$("#new_price").attr('id','price');
		
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("customer/salesrep/cart/content/tr/new?rtype=json")?>",
			null,
			clickNewQuantitySuccess,
			clickNewQuantityErrors,
			clickNewQuantityErrors
		);
	}
}
function clickNewQuantitySuccess(res){
	$("#table_cart_content tbody").append(res.content);
}
function clickNewQuantityErrors(res){
	showMessage(res.errorMessage, 'error');
}
function buttonDelete(){
	
}
</script>