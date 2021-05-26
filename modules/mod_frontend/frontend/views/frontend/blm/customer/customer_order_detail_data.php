<?php
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;
use common\rule\url\friendly\ProductUrlFriendly;
use frontend\controllers\ControllerHelper;
use core\utils\AppUtil;
use common\config\PaymentMethodEnum;
use core\utils\DateTimeUtil;

$order = RequestUtil::get ( 'order' );

switch ($order->paymentMethodId) {
	case PaymentMethodEnum::BANK_TRANSTER :
		break;
	default :
		$order->paymentMethod= Lang::get("Credit Card");
		break;
}
?>

<div class="row">
	<h2><?= Lang::get("Order").' #'.$order->id ?></h2>
	<input type="hidden" id="order_id" value="<?=$order->id?>"> <input
		type="hidden" id="from_email" value="<?=$order->customerEmail?>" /> <input
		type="hidden" id="from_customer_name"
		value="<?=$order->customerFirstname .' '.$order->customerLastname?>" />
	<input type="hidden" id="region_id" value="<?=$order->regionId?>">
	<table class="table">
		<tbody>
			<tr>
				<td style="width: 30%"><strong><?=Lang::get("Date Purchased")?>:</strong><br>&nbsp;<?=DateTimeUtil::mySqlStringDate2String($order->crDate, DateTimeUtil::getDateTimeFormat())?><br>
					<strong><?=Lang::get("Payment Method")?>:</strong><br>&nbsp;<?=$order->paymentMethod?><br>
					<strong><?=Lang::get("Shipping Method")?>:</strong><br>&nbsp;<?=$order->shippingMethod.' : '.$order->shippingMethodItem?><br>
				</td>
				<td style="width: 35%"><strong><?=Lang::get("Billing Address")?>:</strong>
					<div>
					<?=$order->billFirstName.' '.$order->billLastName?><br>
					<?=$order->billAddress?><br>
					<?=$order->billZipcode .' '.$order->billCity.' '.$order->billState?><br>
					<?=$order->billCountry?>
					</div></td>
				<td style="width: 35%"><strong><?=Lang::get("Delivery Address")?>:</strong>
					<div>
						<?=$order->shipFirstName .' '.$order->shipLastName?><br>
				    	<?=$order->shipAddress?><br>
				    	<?=$order->shipZipcode.' '.$order->shipCity.' '.$order->shipState?><br>
				    	<?=$order->shipCountry?>
					</div></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th class="item"><?=Lang::get("Product (Model)")?></th>
				<th class="qty text-center"><?=Lang::get("Qty")?></th>
				<th class="qty text-center"><?=Lang::get("Retail")?></th>
				<th class="price text-center"><?=Lang::get("Price")?></th>
				<th class="tax text-center"><?=RequestUtil::get("taxName")?></th>
				<th class="total text-center"><?=Lang::get("Total")?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (count ( $order->orderProducts ) > 0) {
			foreach ( $order->orderProducts as $product ) {
				?>
			<tr>
				<td class="item">
					<a
					href="<?=ActionUtil::getFullPathAlias("product/detail?id=$product->productId",new ProductUrlFriendly($product->languageCode, $product->productId, $product->seoUrl, $product->name))?>"><?=$product->name?></a></td>
				<td class="qty"><?=$product->quantity?></td>
				<td class="price text-right"><?=ControllerHelper::showProductPrice($product->basePrice,$order->regionId)?></td>
				<td class="price text-right"><?=ControllerHelper::showProductPrice($product->price,$order->regionId)?></td>
				<td class="tax text-right"><?=$product->tax.'%'?></td>
				<td class="total text-right"><?=ControllerHelper::showProductPrice($product->price,$order->regionId)?></td>
			</tr>
			<?php
			}
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td class="text-right" colspan="5">
				<?php foreach ($order->orderTotal as $orderTotal){
					?>
                    <div class="row static-info align-reverse">
						<div class="col-md-10 name text-right"><strong>
						<?php
						if($orderTotal->type=='coupon'){
							echo $orderTotal->title.' ['.$order->couponCode.'] :';
						}else{
							$subtitle = ' ';
							if(!AppUtil::isEmptyString($orderTotal->subtitle)){
								$subtitle.='['.$orderTotal->subtitle.']';
							}
							echo Lang::get($orderTotal->title).Lang::get($subtitle).' :';
						}
						?></strong>
						</div>
						<div class="col-md-2 text-right"><?=ControllerHelper::showProductPrice($orderTotal->value,$order->regionId)?></div>
					</div>
                <?php }?>
				</td>
			</tr>
		</tfoot>
	</table>
	<h2><?=Lang::get("History and Updates") ?></h2>
	<div id="order_history_update"></div>
	<h2><?=Lang::get('Send Message')?> </h2>
	<div id="order_send_message">
		<?php include_once 'customer_order_send_message_data.php';?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var data = "orderId="+$("#order_id").val();
	simpleAjaxPost(
		guid(),
		"<?=ActionUtil::getFullPathAlias("customer/order/history?rtype=json")?>",
		data,
		onOrderHistorySuccess,
		onOrderHistoryFieldErrors,
		onOrderHistoryErrors
	);
});
function onOrderHistorySuccess(res){
	$("#order_history_update").html(res.content);
}
function onOrderHistoryFieldErrors(res){
	$("#order_history_update").html(res.content);
}
function onOrderHistoryErrors(res){
	showMessage(res.errorMessage, 'error');
}
function onOrderHistoryViewSuccess(res){
	$("#order_send_message").html(res.content);
}
function onOrderHistoryViewErrors(res){
	showMessage(res.errorMessage, 'error');
}

function sendMessageOrder(){
	var data = $("#form_order_comment").serialize();
	data +="&regionId="+$("#region_id").val()+"&orderId="+$("#order_id").val() + "&fromEmail="+$("#from_email").val();
	data +="&fromCustomerName=" + $("#from_customer_name").val();
	simpleAjaxPost(
		guid(),
		"<?=ActionUtil::getFullPathAlias("customer/order/send/message?rtype=json")?>",
		data,
		onSendOrderHistorySuccess,
		onSendMessageOrderFieldErrors,
		onSendMessageOrderErrors
	);
}
function onSendOrderHistorySuccess(res){
	$("#order_history_update").html(res.content);
	simpleAjaxPost(
		guid(),
		"<?=ActionUtil::getFullPathAlias("customer/order/send/message/view?rtype=json")?>",
		"",
		onOrderHistoryViewSuccess,
		onOrderHistoryViewErrors,
		onOrderHistoryViewErrors
	);
	showMessage("<?=Lang::get('Your message was sent successfully')?>");
}
function onSendMessageOrderFieldErrors(res){
	$("#order_send_message").html(res.content);
}
function onSendMessageOrderErrors(res){
	showMessage(res.errorMessage, 'error');
}

</script>