<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\PagingTemplate;
use core\utils\ActionUtil;
use frontend\controllers\ControllerHelper;

$paging = RequestUtil::get ( "ordersCustomer" );
if(!is_null($paging)){
	$ordersCustomer = $paging->records;
?>
<a name="orders"/>
<h2><?= Lang::get("Customer Orders") ?></h2>
<div id="customer_order_result">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<div class="table-scrollable">
		<table class="table table-striped table-bordered table-hover dataTable no-footer">
		  <tr>
		    <th><?=Lang::get('Order')?></th>
		    <th><?=Lang::get('Ship To')?></th>
		    <th><?=Lang::get('Total')?></th>
		    <th><?=Lang::get('Status')?></th>
		    <th></th>
		  </tr>
		  <?php
			if (empty ( $ordersCustomer ) || count ( $ordersCustomer ) == 0) {
				?>
			<tr role="row">
				<td colspan="5"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
		  foreach ($ordersCustomer as $order){?>
		  <tr class="gradeX odd">
		    <td>#<?=$order->id?></td>
		    <td>
		    	<?=$order->customerFirstname .' '.$order->customerLastname?><br>
		    	<?=$order->shipAddress?><br>
		    	<?=$order->shipZipcode.' '.$order->shipCity.' '.$order->shipState?><br>
		    	<?=$order->shipCountry?>
		    </td>
		    <td><?=ControllerHelper::showProductPrice($order->grandTotalAmount,$order->regionId)?></td>
		    <td><?=$order->orderStatusName?></td>
		    <td>
		    	<a href="javascript:onOrderDetail(<?=$order->id?>)" class="button"><span><?= Lang::get("View") ?></span></a>
		    	<a target="_blank" href="<?=ActionUtil::getFullPathAlias("customer/salesrep/order/pdf?orderId=".$order->id)?>" class="button"><?= Lang::get("PDF") ?></a>
		    </td>
		  </tr>
		  <?php 
		  		}
		  }?>
		</table>
	</div>
<?php
	$pagingTemplate = new PagingTemplate();
	$pagingTemplate->paging = $paging;
	$pagingTemplate->changePageJs = "changePageOrdersCustomer";
	$pagingTemplate->render ();
}
?>
</div>
<script type="text/javascript">
function onOrderDetail(orderId){
	var data = "orderId="+orderId;
	simpleAjaxPost(
		guid(),
		"<?=ActionUtil::getFullPathAlias("customer/salesrep/order/detail?rtype=json")?>",
		data,
		onOrderDetailSuccess,
		onOrderDetailErrors,
		onOrderDetailErrors
	);
}
function onOrderDetailSuccess(res){
	$("#orders").html(res.content);
}
function onOrderDetailErrors(res){
	showMessage(res.errorMessage, 'error');
}
</script>