<?php
use common\template\extend\LabelContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get("pageSizes");
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"><?= Lang::get("Orders") ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="dataTables_wrapper no-footer">
                        <form id="order_search_form">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get('Show');
									$labelContainer->textAfter = Lang::get('entries');
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get("pageSize");
									$select->attributes = "onchange=\"refreshOrders()\"";
									$select->collections = $collections;
									$labelContainer->addElement($select);
									$labelContainer->render();
									?>
                                </div>
                            </div>
                            <div id="order_search_result">
								<?php include "order_list_data.php" ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
<?php
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "order_dialog";
$modalTemplate->render();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("div.container").attr("class", "container-fluid");
		showOrders("crDate", "desc");
		$("#btnAddOrderDialog").click(function(){
			simpleCUDModal(
				"#order_dialog",
				"#add_order_form",
				guid(),
				"#btnAddOrder",
				"<?=ActionUtil::getFullPathAlias("admin/order/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/order/add?rtype=json")?>",
				refreshOrders
			);
		});
	});
	function deleteOrderDialog(id){
		simpleCUDModal(
			"#order_dialog",
			"#del_order_form",
			guid(),
			"#btnDelOrder",
			"<?=ActionUtil::getFullPathAlias("admin/order/del/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/order/del?rtype=json")?>",
			refreshOrders
		);
	}
	function showOrders(field, direction){
		$("#order_table").tablesorter({
			field: field,
			direction: direction,
			fieldList: ["id", "customerFirstname", "crDate", "orderStatusId", "billCountryCode", "regionId", "", "adminComment", "paymentMethod", ""],
			callback: sortOrders
		});
	}
	function sortOrders(field, direction, is_reset = false){
		App.blockUI({
			target: '#order_table'
		});
		var data = "";
		if (!is_reset) {
			data = $("#order_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/order/search?rtype=json")?>", data, function(res){
			App.unblockUI('#order_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#order_search_result").html(res.content);
				// Update view for sorting.
				showOrders(field, direction);
			} else {
				showMessage(res.errorMessage, "error");
			}
		}).fail(function(){
			App.unblockUI('#order_table');
			showMessage("System error", "error");
		});
	}
	function searchOrders(is_reset = false){
		$("#order_search_form #page").val(1);
		sortOrders("id", "desc", is_reset);
	}
	function changePageOrders(page){
		var field = $("#order_table").attr("field");
		var direction = $("#order_table").attr("direction");
		$("#order_search_form #page").val(page);
		sortOrders(field, direction);
	}
	function refreshOrders(dialogId, btnId, res){
		var field = $("#order_table").attr("field");
		var direction = $("#order_table").attr("direction");
		sortOrders(field, direction);
		$(dialogId).modal("toggle");
	}
	function changeOrderStatus(obj, orderId){
		var data = "";
		data += "&id=" + orderId + "&orderStatusId=" + obj.value;
		$.post("<?=ActionUtil::getFullPathAlias("admin/order/change/order/status?rtype=json")?>", data, function(res){
			if (res.errorCode == "SUCCESS") {
				showMessage("<?=Lang::get("Change order status successfully") ?>");
			} else {
				showMessage(res.errorMessage, "error");
			}
		}).fail(function(){
			showMessage("System error", "error");
		});
	}
	function changeShippingStatus(obj, orderId){
		var data = "";
		data += "&id=" + orderId + "&shippingStatusId=" + obj.value;
		$.post("<?=ActionUtil::getFullPathAlias("admin/order/change/shipping/status?rtype=json")?>", data, function(res){
			if (res.errorCode == "SUCCESS") {
				showMessage("<?=Lang::get("Change shipping status successfully") ?>");
			} else {
				showMessage(res.errorMessage, "error");
			}
		}).fail(function(){
			showMessage("System error", "error");
		});
	}
	function checkERDT(obj, orderId){
		var data = "";
		if (obj.checked == true) {
			data += "&id=" + orderId;
			$.post("<?=ActionUtil::getFullPathAlias("admin/order/check/erdt?rtype=json")?>", data, function(res){
				if (res.errorCode == "SUCCESS") {
					showMessage("<?=Lang::get("Change shipping status to ordered successfully") ?>", "success", true);
				} else {
					showMessage(res.errorMessage, "error");
				}
				refreshOrders();
			}).fail(function(){
				showMessage("System error", "error");
			});
		}
	}
	function unCheckERDT(obj, orderId){
		var data = "";
		data += "&id=" + orderId;
		$.post("<?=ActionUtil::getFullPathAlias("admin/order/uncheck/erdt?rtype=json")?>", data, function(res){
			if (res.errorCode == "SUCCESS") {
				showMessage("<?=Lang::get("Uncheck ERDT successfully") ?>", "success", true);
			} else {
				showMessage(res.errorMessage, "error");
			}
			refreshOrders();
		}).fail(function(){
			showMessage("System error", "error");
		});
	}
	function changeUSAFilter(obj){
		if(obj.value==1){
			$("#usaFilter").hide();
			$("#usaFilter :input").prop('disabled', true);
		}else{
			$("#usaFilter").show();
			$("#usaFilter :input").prop('disabled', false);
		}
	}
</script>