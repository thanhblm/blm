<?php
use common\template\extend\LabelContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\Button;
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Translation")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="language_value_search_form">
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
									$select->attributes = "onchange=\"refreshLanguageValues()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button();
										$button->type = "button";
										$button->title = " " . Lang::get ( 'Export' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-download\"></i>";
										$button->attributes = "onclick=\" exportLanguageValueCsv()\"";
										$button->checkActionPath = "admin/language/value/export";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="language_value_search_result">
								<?php include "language_value_list_data.php"?>
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
$modalTemplate->id = "language_value_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showLanguageValues("languageCode","asc");
	});
	function editLanguageValueDialog(id){
		simpleCUDModal(
			"#language_value_dialog",
			"#edit_language_value_form",
			guid(),
			"#btnEditLanguageValue",
			"<?=ActionUtil::getFullPathAlias("admin/language/value/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/language/value/edit?rtype=json")?>",
			refreshLanguageValues
		);
	}
	function showLanguageValues(field,direction){
		$("#language_value_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["languageCode","original","destination",""],
			callback : sortLanguageValues
		});
	}
	function sortLanguageValues(field, direction, is_reset = false){
		App.blockUI({
            target: '#language_value_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#language_value_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/language/value/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#language_value_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#language_value_search_result").html(res.content);
				// Update view for sorting.
				showLanguageValues(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			alert("System error.");
			App.unblockUI('#language_value_table');
		});
	}
	function searchLanguageValues(is_reset = false){
		$("#language_value_search_form #page").val(1);
		sortLanguageValues("languageCode","asc",is_reset);
		
	}
	function changePageLanguageValues(page){
		var field = $("#language_value_table").attr("field");
		var direction = $("#language_value_table").attr("direction");
		$("#language_value_search_form #page").val(page);
		sortLanguageValues(field,direction);
	}
	function refreshLanguageValues(dialogId,btnId,res){
		var field = $("#language_value_table").attr("field");
		var direction = $("#language_value_table").attr("direction");
		sortLanguageValues(field,direction);
		$(dialogId).modal("toggle");
	}
	function exportLanguageValueCsv(){
			window.location.href = "<?=ActionUtil::getFullPathAlias("admin/language/value/export")?>";
	}
</script>