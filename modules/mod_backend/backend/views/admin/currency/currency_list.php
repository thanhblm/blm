<?php
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\Select;
use common\template\extend\ModalTemplate;
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Currencies")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="currency_search_form">
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
									$select->attributes = "onchange=\"refreshCurrencies()\"";
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
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->checkActionPath = "admin/currency/add/view";
										$button->id = "btnAddCurrencyDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="currency_search_result">
								<?php include "currency_list_data.php"?>
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
$modalTemplate->id = "currency_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showCurrencies("name","asc");
		$("#btnAddCurrencyDialog").click(function(){
			simpleCUDModal(
				"#currency_dialog",
				"#add_currency_form",
				guid(),
				"#btnAddCurrency",
				"<?=ActionUtil::getFullPathAlias("admin/currency/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/currency/add?rtype=json")?>",
				refreshCurrencies
			);
		});
	});
	function editCurrencyDialog(code){
		simpleCUDModal(
			"#currency_dialog",
			"#edit_currency_form",
			guid(),
			"#btnEditCurrency",
			"<?=ActionUtil::getFullPathAlias("admin/currency/edit/view?rtype=json&code=")?>" + code,
			"<?=ActionUtil::getFullPathAlias("admin/currency/edit?rtype=json")?>",
			refreshCurrencies
		);
	}
	function copyCurrencyDialog(code){
		simpleCUDModal(
			"#currency_dialog",
			"#copy_currency_form",
			guid(),
			"#btnCopyCurrency",
			"<?=ActionUtil::getFullPathAlias("admin/currency/copy/view?rtype=json&code=")?>" + code,
			"<?=ActionUtil::getFullPathAlias("admin/currency/copy?rtype=json")?>",
			refreshCurrencies
		);
	}
	function deleteCurrencyDialog(code){
		simpleCUDModal(
				"#currency_dialog",
				"#del_currency_form",
				guid(),
				"#btnDelCurrency",
				"<?=ActionUtil::getFullPathAlias("admin/currency/del/view?rtype=json&code=")?>" + code,
				"<?=ActionUtil::getFullPathAlias("admin/currency/del?rtype=json")?>",
				refreshCurrencies
			);
	}
	function showCurrencies(field,direction){
		$("#currency_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["code","name","symbol","placement","decimal","status",""],
			callback : sortCurrencies
		});
	}
	function sortCurrencies(field, direction, is_reset = false){
		App.blockUI({
            target: '#currency_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#currency_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/currency/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#currency_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#currency_search_result").html(res.content);
				// Update view for sorting.
				showCurrencies(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#currency_table');
			alert("System error.");
		});
	}
	function searchCurrencies(is_reset = false){
		$("#currency_search_form #page").val(1);
		sortCurrencies("name","asc",is_reset);
	}
	function changePageCurrencies(page){
		var field = $("#currency_table").attr("field");
		var direction = $("#currency_table").attr("direction");
		$("#currency_search_form #page").val(page);
		sortCurrencies(field,direction);
	}
	function refreshCurrencies(dialogId,btnId,res){
		var field = $("#currency_table").attr("field");
		var direction = $("#currency_table").attr("direction");
		sortCurrencies(field,direction);
		$(dialogId).modal("toggle");
	}
</script>