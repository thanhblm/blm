<?php
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Order Statuses")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="order_status_search_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get ( 'Show' );
									$labelContainer->textAfter = Lang::get ( 'entries' );
									$select = new Select ();
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get ( "pageSize" );
									$select->attributes = "onchange=\"refreshOrderStatus()\"";
									$select->collections = $pageSizes;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button ();
										$button->type = "button";
										$button->id = "btnAddOrderStatusDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->checkActionPath = "admin/order/status/add/view";
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="order_status_search_result">
								<?php include "order_status_list_data.php"?>
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
$modalTemplate->id = "order_status_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showOrderStatus("id","asc");
		$("#btnAddOrderStatusDialog").click(function(){
			simpleCUDModal(
					"#order_status_dialog",
					"#add_order_status_form",
					guid(),
					"#btnAddOrderStatus",
					"<?=ActionUtil::getFullPathAlias("admin/order/status/add/view?rtype=json")?>",
					"<?=ActionUtil::getFullPathAlias("admin/order/status/add?rtype=json")?>",
					refreshOrderStatus
				);
		});
	});
	function searchOrderStatuses(is_reset = false){
		$("#order_status_search_form #page").val(1);
		sortOrderStatus("id","asc", is_reset);
	}
	function editOrderStatusDialog(id){
		simpleCUDModal(
			"#order_status_dialog",
			"#edit_order_status_form",
			guid(),
			"#btnEditOrderStatus",
			"<?=ActionUtil::getFullPathAlias("admin/order/status/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/order/status/edit?rtype=json")?>",
					refreshOrderStatus
		);
	}
	function copyOrderStatusDialog(id){
		simpleCUDModal(
			"#order_status_dialog",
			"#copy_order_status_form",
			guid(),
			"#btnCopyOrderStatus",
			"<?=ActionUtil::getFullPathAlias("admin/order/status/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/order/status/copy?rtype=json")?>",
					refreshOrderStatus
		);
	}
	function deleteOrderStatusDialog(id){
		simpleCUDModal(
				"#order_status_dialog",
				"#del_order_status_form",
				guid(),
				"#btnDelOrderStatus",
				"<?=ActionUtil::getFullPathAlias("admin/order/status/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/order/status/del?rtype=json")?>",
						refreshOrderStatus
			);
	}
	function refreshOrderStatus(dialogId,btnId,res){
		var field = $("#order_status_table").attr("field");
		var direction = $("#order_status_table").attr("direction");
		sortOrderStatus(field,direction);
		$(dialogId).modal("toggle");
	}
	function sortOrderStatus(field, direction, is_reset = false){
		App.blockUI({
            target: '#order_status_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#order_status_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/order/status/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#order_status_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#order_status_search_result").html(res.content);
				// Update view for sorting.
				showOrderStatus(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#order_status_table');
			alert("System error.");
		});
	}
	function showOrderStatus(field,direction){
		$("#order_status_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : sortOrderStatus
		});
	}
	function changePageOrderStatus(page){
		var field = $("#order_status_table").attr("field");
		var direction = $("#order_status_table").attr("direction");
		$("#order_status_search_form #page").val(page);
		sortOrderStatus(field,direction);
	}
</script>