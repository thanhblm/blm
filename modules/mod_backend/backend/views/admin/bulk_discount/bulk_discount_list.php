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
						<span class="caption-subject bold uppercase"><?=Lang::get("Bulk Discounts")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="bulk_discount_search_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get ( 'Show' );
									$labelContainer->textAfter = Lang::get ( 'entries' );
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get ( "pageSize" );
									$select->attributes = "onchange=\"refreshBulkDiscounts()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button ();
										$button->type = "button";
										$button->id = "btnAddBulkDiscountDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\"onAddBulkDiscount()\"";
										$button->checkActionPath = "admin/discount/bulk/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="bulk_discount_search_result">
								<?php include "bulk_discount_list_data.php"?>
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
$modalTemplate->id = "bulk_discount_dialog";
$modalTemplate->size = 800;
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showBulkDiscounts("id","asc");
	});
	
	function deleteBulkDiscountDialog(id){
		simpleCUDModal(
				"#bulk_discount_dialog",
				"#del_bulk_discount_form",
				guid(),
				"#btnDelBulkDiscount",
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/del?rtype=json")?>",
				refreshBulkDiscounts
			);
	}
	function showBulkDiscounts(field,direction){
		$("#bulk_discount_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","discount","status",""],
			callback : sortBulkDiscounts
		});
	}
	function sortBulkDiscounts(field, direction, is_reset = false){
		App.blockUI({
            target: '#bulk_discount_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#bulk_discount_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/discount/bulk/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#bulk_discount_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#bulk_discount_search_result").html(res.content);
				// Update view for sorting.
				showBulkDiscounts(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#bulk_discount_table');
			alert("System error.");
		});
	}
	function searchBulkDiscounts(is_reset = false){
		$("#bulk_discount_search_form #page").val(1);
		sortBulkDiscounts("id","asc",is_reset);
	}
	function changePageBulkDiscounts(page){
		var field = $("#bulk_discount_table").attr("field");
		var direction = $("#bulk_discount_table").attr("direction");
		$("#bulk_discount_search_form #page").val(page);
		sortBulkDiscounts(field,direction);
	}
	
	function refreshBulkDiscounts(dialogId,btnId,res){
		var field = $("#bulk_discount_table").attr("field");
		var direction = $("#bulk_discount_table").attr("direction");
		sortBulkDiscounts(field,direction);
		$(dialogId).modal("toggle");
	}
	function onAddBulkDiscount(){
		simpleCUDModal(
				"#bulk_discount_dialog",
				"#bulk_discount_add_form",
				guid(),
				"#btnAddBulkDiscount",
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/add?rtype=json")?>",
						refreshBulkDiscounts
			);
	}
	function editBulkDiscountDialog(id){
		simpleCUDModal(
				"#bulk_discount_dialog",
				"#bulk_discount_edit_form",
				guid(),
				"#btnEditBulkDiscount",
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/edit/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/edit?rtype=json")?>",
						refreshBulkDiscounts
			);
	}
	function copyBulkDiscountDialog(id){
		simpleCUDModal(
				"#bulk_discount_dialog",
				"#bulk_discount_copy_form",
				guid(),
				"#btnCopyBulkDiscount",
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/copy/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/discount/bulk/copy?rtype=json")?>",
						refreshBulkDiscounts
			);
	}
</script>