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
						<span class="caption-subject bold uppercase"><?=Lang::get("Languages")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="language_search_form">
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
									$select->attributes = "onchange=\"refreshLanguages()\"";
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
										$button->checkActionPath = "admin/language/add/view";
										$button->id = "btnAddLanguageDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="language_search_result">
								<?php include "language_list_data.php"?>
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
$modalTemplate->id = "language_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showLanguages("code","asc");
		$("#btnAddLanguageDialog").click(function(){
			simpleCUDModal(
				"#language_dialog",
				"#add_language_form",
				guid(),
				"#btnAddLanguage",
				"<?=ActionUtil::getFullPathAlias("admin/language/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/language/add?rtype=json")?>",
				refreshLanguages
			);
		});
	});
	function editLanguageDialog(code){
		simpleCUDModal(
			"#language_dialog",
			"#edit_language_form",
			guid(),
			"#btnEditLanguage",
			"<?=ActionUtil::getFullPathAlias("admin/language/edit/view?rtype=json&code=")?>" + code,
			"<?=ActionUtil::getFullPathAlias("admin/language/edit?rtype=json")?>",
			refreshLanguages
		);
	}
	function copyLanguageDialog(code){
		simpleCUDModal(
			"#language_dialog",
			"#copy_language_form",
			guid(),
			"#btnCopyLanguage",
			"<?=ActionUtil::getFullPathAlias("admin/language/copy/view?rtype=json&code=")?>" + code,
			"<?=ActionUtil::getFullPathAlias("admin/language/copy?rtype=json")?>",
			refreshLanguages
		);
	}
	function deleteLanguageDialog(code){
		simpleCUDModal(
				"#language_dialog",
				"#del_language_form",
				guid(),
				"#btnDelLanguage",
				"<?=ActionUtil::getFullPathAlias("admin/language/del/view?rtype=json&code=")?>" + code,
				"<?=ActionUtil::getFullPathAlias("admin/language/del?rtype=json")?>",
				refreshLanguages
			);
	}
	function showLanguages(field,direction){
		$("#language_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["code","name","localeName","status","",""],
			callback : sortLanguages
		});
	}
	function sortLanguages(field, direction, is_reset = false){
		App.blockUI({
            target: '#language_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#language_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/language/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#language_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#language_search_result").html(res.content);
				// Update view for sorting.
				showLanguages(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#language_table');
			alert("System error.");
		});
	}
	function searchLanguages(is_reset = false){
		$("#language_search_form #page").val(1);
		sortLanguages("name","asc", is_reset);
	}

	function changePageLanguages(page){
		var field = $("#language_table").attr("field");
		var direction = $("#language_table").attr("direction");
		$("#language_search_form #page").val(page);
		sortLanguages(field,direction);
	}
	function refreshLanguages(dialogId,btnId,res){
		var field = $("#language_table").attr("field");
		var direction = $("#language_table").attr("direction");
		sortLanguages(field,direction);
		$(dialogId).modal("toggle");
	}
</script>