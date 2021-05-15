<?php
use common\template\extend\Button;
use common\template\extend\Link;
use common\template\extend\Text;
use common\template\extend\TextArea;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use frontend\service\PaymentHelper;
use frontend\service\OrderHelper;
use core\utils\DateTimeUtil;
use common\template\extend\TextInput;
use common\template\extend\SelectInput;

$order = RequestUtil::get("order");
$countryList = RequestUtil::get("countryList");
$stateList = RequestUtil::get("stateList");
$shipStateList = RequestUtil::get("shipStateList");

if ($order !== null) {
	$orderProducts = $order->orderProducts;
	$orderHistories = $order->orderHistories;
	?>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-row-seperated" id="edit_order_form" method="post">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"><?php echo Lang::get("Order detail") . "  - <a href=\"#\">#" . $order->id . "</a>"; ?></span>
                        </div>
                        <div class="actions btn-set">
							<?php
							$link = new Link ();
							$link->title = Lang::get('Back');
							$link->link = ActionUtil::getFullPathAlias('admin/order/list');
							$link->class = "btn btn-sm grey margin-bottom-5";
							$link->render();

							$button = new Button ();
							$button->id = "btnEditOrder";
							$button->icon = "<i class='fa fa-plus'></i>";
							$button->title = Lang::get("Save ");
							$button->class = "btn btn-sm blue margin-bottom-5";
							$button->attributes = "type='button' onclick='editOrder()'";
							$button->render();

							$button = new Button ();
							$button->id = "btnEditAndCloseOrder";
							$button->icon = "<i class='fa fa-plus'></i>";
							$button->title = Lang::get("Save & Close");
							$button->class = "btn btn-sm blue margin-bottom-5";
							$button->attributes = "type='button' onclick='editAndCloseOrder()'";
							$button->render();
							?>
                        </div>
                    </div>
                    <div class="portlet-body">
						<?php
						if (RequestUtil::hasActionErrors()) {
							?>
                            <div class="alert alert-danger" role="alert">
								<?= RequestUtil::getErrorMessage(); ?>
                            </div>
							<?php
						}
						if (RequestUtil::hasFieldErrors()) {
							?>
                            <div class="alert alert-danger" role="alert"><?= Lang::get("There are some field errors, please check!") ?></div>
							<?php
						}
						if (RequestUtil::hasActionMessages()) {
							?>
                            <div id="alert_info" class="alert alert-info" role="alert">
								<?= RequestUtil::getActionMessage() ?>
                            </div>
							<?php
						}
						?>
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_general" data-toggle="tab"><?= Lang::get("General") ?>  </a>
                                </li>
                                <li>
                                    <a href="#tab_product" data-toggle="tab"> <?= Lang::get("Products") ?> </a>
                                </li>
                                <li>
                                    <a href="#tab_history" data-toggle="tab"> <?= Lang::get("History") ?> </a>
                                </li>
                                <li>
                                    <a href="#tab_comment" data-toggle="tab"> <?= Lang::get("Comment") ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_general">
									<?php
									$text = new Text ();
									$text->value = $order->id;
									$text->name = "order[id]";
									$text->type = "hidden";
									$text->render();
									?>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <div class="portlet box blue-madison">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-info-circle"></i> <?= Lang::get("Order details") ?>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Order Status :") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->orderStatusName ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Shipping Status :") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->shippingStatusName ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Coupon code:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->couponCode ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Currency:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->currencyCode ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Region:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->regionName ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Language:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->languageName ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="portlet box blue-hoki">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-user-circle-o"></i> <?= Lang::get("Customer details") ?>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("First Name:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->customerFirstname ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Last Name:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->customerLastname ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Company:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->customerCompany ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Phone:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->customerPhone ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> <?= Lang::get("Email:") ?></div>
                                                        <div class="col-md-7 value">
															<?= $order->customerEmail ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="order_detail_row">
                                        <?php require_once 'order_detail_row_bill_ship_data.php';?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_product">
                                    <div class="table-container">
                                        <div id="datatable_shipment_wrapper" class="dataTables_wrapper dataTables_extended_wrapper dataTables_extended_wrapper dataTables_extended_wrapper no-footer">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_shipment" aria-describedby="datatable_shipment_info" role="grid">
                                                    <thead>
                                                    <tr role="row" class="heading">
                                                        <th><?= Lang::get("ID") ?></th>
                                                        <th><?= Lang::get("Product") ?></th>
                                                        <th><?= Lang::get("Name") ?></th>
                                                        <th><?= Lang::get("Price Base") ?></th>
                                                        <th><?= Lang::get("Discount") ?></th>
                                                        <th><?= Lang::get("Price") ?></th>
                                                        <th><?= Lang::get("Tax") ?></th>
                                                        <th><?= Lang::get("Quantity") ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="order_product">
													<?php
													$itemCount = 0;
													foreach ($orderProducts as $orderProduct) {
														?>
                                                        <tr>
                                                            <td><?= $orderProduct->productId ?></td>
                                                            <td><?= $orderProduct->productCode ?> </td>
                                                            <td><?= $orderProduct->name ?></td>
                                                            <td><?= $orderProduct->basePrice ?></td>
                                                            <td><?= $orderProduct->discount ?>%</td>
                                                            <td><?= $orderProduct->price ?> </td>
                                                            <td><?= $orderProduct->tax ?>%</td>
                                                            <td><?= $orderProduct->quantity ?></td>
                                                        </tr>
														<?php
														$itemCount++;
													}
													?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row" id="total-list">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="well">
														<?php foreach ($order->orderTotal as $orderTotal) {
															$subtitle = $orderTotal->subtitle;
															if (!AppUtil::isEmptyString($orderTotal->subtitle) && ($orderTotal->type == "shipping" || $orderTotal->type == "coupon")) {
																$subtitle = "[" . $orderTotal->subtitle . "]";
															}
															$orderGrandTotal = $orderTotal->value;
															?>
                                                            <div class="row static-info align-reverse">
                                                                <div class="col-md-8 name"><?php echo $orderTotal->title . ' ' . $subtitle ?></div>
                                                                <div class="col-md-3 value"> <?php echo $orderTotal->value . ' ' . $order->currencyCode; ?><?php //$order->discountAmount ?></div>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_history">
                                    <div class="table-container">
                                        <div id="datatable_shipment_wrapper" class="dataTables_wrapper dataTables_extended_wrapper dataTables_extended_wrapper dataTables_extended_wrapper no-footer">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_shipment" aria-describedby="datatable_shipment_info" role="grid">
                                                    <thead>
                                                    <tr role="row" class="heading">
                                                        <th>#</th>
                                                        <th><?= Lang::get("Date/Time") ?></th>
                                                        <th><?= Lang::get("Status") ?></th>
                                                        <th><?= Lang::get("Description") ?></th>
                                                        <th><?= Lang::get("Cust. Notified") ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="order_product">
													<?php
													$itemCount = 0;
													foreach ($orderHistories as $orderHistory) {
														?>
                                                        <tr>
                                                            <td><?= $orderHistory->id ?> </td>
                                                            <td><?= DateTimeUtil::mySqlStringDate2String($orderHistory->crDate, DateTimeUtil::getDateTimeFormat()) ?> </td>
                                                            <td><?= $orderHistory->orderStatusName ?></td>
                                                            <td><?php
																/*
																	$description=json_decode($orderHistory->description );
																	if(isset($description->responseMsg)){echo $description->responseMsg ;}
																	*/
																echo str_replace("\n", "<br/>", $orderHistory->description);
																?></td>
                                                            <td>
                                                                <!--
                                                        	<?php if (AppUtil::isEmptyString($orderHistory->cusNotified) || strtolower($orderHistory->cusNotified) == "no") { ?>
                                                                <span class="label label-sm label-danger"><?= !AppUtil::isEmptyString($orderHistory->cusNotified) ? $orderHistory->cusNotified : Lang::get("no") ?>
                                                                    <i class="fa fa-remove"></i></span>
																<?php
																} else { ?>
                                                                <span class="label label-sm label-success"><?= $orderHistory->cusNotified ?>
                                                                    <i class="fa fa-check"></i></span>
																<?php
																}
																?>
															-->
																<?= $orderHistory->cusNotified ?></td>
                                                        </tr>
														<?php
														$itemCount++;
													}
													?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
										<?php
										if ($order->orderStatusId === 2) {
											$button = new Button();
											$button->title = Lang::get("Refund order");
											$button->attributes = "type='button' onclick='refundOrder()'";
											$button->render();
										}
										?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_comment">
                                    <div class="form-body">
                                        <div class="form-group ">
											<?php
											$text = new TextArea ();
											$text->label = Lang::get("Comment (User)");
											$text->value = $order->customerComment;
											$text->readonly = true;
											$text->render();

											$text = new TextArea ();
											$text->label = Lang::get("Comment (Admin)");
											$text->value = $order->adminComment;
											$text->name = 'order[adminComment]';
											$text->render();

											$text = new TextArea ();
											$text->label = Lang::get("Comment (Invoice)");
											$text->value = $order->invoiceComment;
											$text->name = 'order[invoiceComment]';
											$text->render();
											?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
		function editOrder(){
			simpleAjaxPost(
				guid(),
				"<?=ActionUtil::getFullPathAlias("admin/order/edit?rtype=json")?>",
				$("#edit_order_form").serialize(),
				onEditOrderSuccess,
				onEditOrderFieldErrors,
				onEditOrderActionErrors
			);
		}

		function onEditOrderSuccess(res){
			$("#order_detail_row").html(res.content);
			showMessage("<?=Lang::get("Updated successfully") ?>");
		}
		function onEditOrderFieldErrors(res){
			//$("#edit_order_form").replaceWith(res.content);
			$("#order_detail_row").html(res.content);
		}
		function onEditOrderActionErrors(res){
			showMessage(res.errorMessage, 'error');
		}
		function editAndCloseOrder(){
			simpleAjaxPost(
				guid(),
				"<?=ActionUtil::getFullPathAlias("admin/order/edit?rtype=json")?>",
				$("#edit_order_form").serialize(),
				onEditAndCloseOrderSuccess,
				onEditAndCloseOrderFieldErrors,
				onEditAndCloseOrderActionErrors
			);
		}

		function onEditAndCloseOrderSuccess(res){
			location.href = "<?=ActionUtil::getFullPathAlias('admin/order/list')?>";
		}
		function onEditAndCloseOrderFieldErrors(res){
			//$("#edit_order_form").replaceWith(res.content);
			$("#order_detail_row").html(res.content);
		}
		function onEditAndCloseOrderActionErrors(res){
			showMessage(res.errorMessage, 'error');
		}
		
		function refundOrder(){
			var orderId = '<?php echo $order->id; ?>';
			var refundAmt = prompt("Please enter amount to refund?", "<?php echo $orderGrandTotal + OrderHelper::getTotalRefundAmtByOrderId($order->id); ?>");
			if (refundAmt != null) {
				simpleAjaxPost(
					guid(),
					"<?=ActionUtil::getFullPathAlias("admin/order/refund?rtype=json")?>",
					{
						'orderId':orderId,
						'refundAmt':refundAmt
					},
					onRefundOrderSuccess,
					onRefundOrderFieldErrors,
					onRefundOrderActionErrors
				);
			}
		}

		function onRefundOrderSuccess(res){
			showMessage("<?=Lang::get("Refund successfully") ?>");
			location.reload();
		}
		function onRefundOrderFieldErrors(res){
			$("#edit_order_form").replaceWith(res.content);
		}
		function onRefundOrderActionErrors(res){
			showMessage(res.errorMessage, 'error');
		}
		function getBillState(obj){
			var countryIso = obj.value;
			var categoryState = "bill";
			var data = "";
			data += "&countryIso=" + countryIso+"&categoryState="+categoryState;
			$.post("<?=ActionUtil::getFullPathAlias("admin/order/detail/get/state?rtype=json")?>", data, function(res){
				if (res.errorCode == "SUCCESS") {//alert(res.content);
					$("#billState").html(res.content);
				} else {
					alert(res.errorMessage);
				}
			}).fail(function(){
				alert("System error.");
			});
		}	
		
		function getShipState(obj){
			var countryIso = obj.value;
			var categoryState = "ship";
			var data = "";
			data += "&countryIso=" + countryIso + "&categoryState="+categoryState;
			$.post("<?=ActionUtil::getFullPathAlias("admin/order/detail/get/state?rtype=json")?>", data, function(res){
				if (res.errorCode == "SUCCESS") {//alert(res.content);
					$("#shipState").html(res.content);
				} else {
					alert(res.errorMessage);
				}
			}).fail(function(){
				alert("System error.");
			});
		}
    </script>
	<?php
} else {
	echo Lang::get('This order is not exsit.');
}
?>