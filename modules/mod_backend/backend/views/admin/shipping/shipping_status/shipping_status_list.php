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
						<span class="caption-subject bold uppercase"><?=Lang::get("Shipping Statuses")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="shipping_status_search_form">
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
									$select->attributes = "onchange=\"refreshShippingStatus()\"";
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
										$button->id = "btnAddShippingStatusDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->checkActionPath = "admin/shipping/status/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="shipping_status_search_result">
								<?php include "shipping_status_list_data.php"?>
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
$modalTemplate->id = "shipping_status_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showShippingStatus("id","asc");
		$("#btnAddShippingStatusDialog").click(function(){
			simpleCUDModal(
					"#shipping_status_dialog",
					"#add_shipping_status_form",
					guid(),
					"#btnAddShippingStatus",
					"<?=ActionUtil::getFullPathAlias("admin/shipping/status/add/view?rtype=json")?>",
					"<?=ActionUtil::getFullPathAlias("admin/shipping/status/add?rtype=json")?>",
					refreshShippingStatus
				);
		});
	});
	function searchShippingStatuses(is_reset = false){
		$("#shipping_status_search_form #page").val(1);
		sortShippingStatus("id","asc", is_reset);
	}
	function editShippingStatusDialog(id){
		simpleCUDModal(
			"#shipping_status_dialog",
			"#edit_shipping_status_form",
			guid(),
			"#btnEditShippingStatus",
			"<?=ActionUtil::getFullPathAlias("admin/shipping/status/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/shipping/status/edit?rtype=json")?>",
					refreshShippingStatus
		);
	}
	function copyShippingStatusDialog(id){
		simpleCUDModal(
			"#shipping_status_dialog",
			"#copy_shipping_status_form",
			guid(),
			"#btnCopyShippingStatus",
			"<?=ActionUtil::getFullPathAlias("admin/shipping/status/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/shipping/status/copy?rtype=json")?>",
					refreshShippingStatus
		);
	}
	function deleteShippingStatusDialog(id){
		simpleCUDModal(
				"#shipping_status_dialog",
				"#del_shipping_status_form",
				guid(),
				"#btnDelShippingStatus",
				"<?=ActionUtil::getFullPathAlias("admin/shipping/status/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/shipping/status/del?rtype=json")?>",
						refreshShippingStatus
			);
	}
	function refreshShippingStatus(dialogId,btnId,res){
		var field = $("#shipping_status_table").attr("field");
		var direction = $("#shipping_status_table").attr("direction");
		sortShippingStatus(field,direction);
		$(dialogId).modal("toggle");
	}
	function sortShippingStatus(field, direction, is_reset = false){
		App.blockUI({
            target: '#shipping_status_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#shipping_status_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/shipping/status/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#shipping_status_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#shipping_status_search_result").html(res.content);
				// Update view for sorting.
				showShippingStatus(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#shipping_status_table');
			alert("System error.");
		});
	}
	function showShippingStatus(field,direction){
		$("#shipping_status_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : sortShippingStatus
		});
	}
	function changePageShippingStatus(page){
		var field = $("#shipping_status_table").attr("field");
		var direction = $("#shipping_status_table").attr("direction");
		$("#shipping_status_search_form #page").val(page);
		sortShippingStatus(field,direction);
	}
</script>