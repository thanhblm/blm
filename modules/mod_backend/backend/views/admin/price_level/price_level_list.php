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
						<span class="caption-subject bold uppercase"><?=Lang::get("Price Levels")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="price_level_search_form">
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
									$select->attributes = "onchange=\"refreshPriceLevels()\"";
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
										$button->id = "btnAddPriceLevelDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->checkActionPath = "admin/price/level/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="price_level_search_result">
								<?php include "price_level_list_data.php"?>
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
$modalTemplate->id = "price_level_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showPriceLevels("id","asc");
		$("#btnAddPriceLevelDialog").click(function(){
			simpleCUDModal(
				"#price_level_dialog",
				"#add_price_level_form",
				guid(),
				"#btnAddPriceLevel",
				"<?=ActionUtil::getFullPathAlias("admin/price/level/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/price/level/add?rtype=json")?>",
				refreshPriceLevels
			);
		});
	});
	function editPriceLevelDialog(id){
		simpleCUDModal(
			"#price_level_dialog",
			"#edit_price_level_form",
			guid(),
			"#btnEditPriceLevel",
			"<?=ActionUtil::getFullPathAlias("admin/price/level/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/price/level/edit?rtype=json")?>",
			refreshPriceLevels
		);
	}
	function copyPriceLevelDialog(id){
		simpleCUDModal(
			"#price_level_dialog",
			"#copy_price_level_form",
			guid(),
			"#btnCopyPriceLevel",
			"<?=ActionUtil::getFullPathAlias("admin/price/level/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/price/level/copy?rtype=json")?>",
			refreshPriceLevels
		);
	}
	function deletePriceLevelDialog(id){
		simpleCUDModal(
				"#price_level_dialog",
				"#del_price_level_form",
				guid(),
				"#btnDelPriceLevel",
				"<?=ActionUtil::getFullPathAlias("admin/price/level/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/price/level/del?rtype=json")?>",
				refreshPriceLevels
			);
	}
	function showPriceLevels(field,direction){
		$("#price_level_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","value",""],
			callback : sortPriceLevels
		});
	}
	function sortPriceLevels(field, direction, is_reset = false){
		App.blockUI({
            target: '#price_level_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#price_level_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/price/level/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#price_level_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#price_level_search_result").html(res.content);
				// Update view for sorting.
				showPriceLevels(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#price_level_table');
			alert("System error.");
		});
	}
	function searchPriceLevels(is_reset = false){
		$("#price_level_search_form #page").val(1);
		sortPriceLevels("id","asc", is_reset);
	}

	function changePagePriceLevels(page){
		var field = $("#price_level_table").attr("field");
		var direction = $("#price_level_table").attr("direction");
		$("#price_level_search_form #page").val(page);
		sortPriceLevels(field,direction);
	}
	function refreshPriceLevels(dialogId,btnId,res){
		var field = $("#price_level_table").attr("field");
		var direction = $("#price_level_table").attr("direction");
		sortPriceLevels(field,direction);
		$(dialogId).modal("toggle");
	}
</script>