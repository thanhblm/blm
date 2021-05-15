<?php
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Email Templates")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="email_template_search_form">
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
								$select->attributes = "onchange=\"refreshEmailTemplates()\"";
								$select->collections = $collections;
								$labelContainer->addElement ( $select );
								$labelContainer->render ();
								?>
								</div>
							</div>
							<div id="email_template_search_result">
								<?php include "email_template_list_data.php"?>
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
$modalTemplate->id = "email_template_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "delete_email_template_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showEmailTemplates("id","asc");
	});
	function editEmailTemplateDialog(id){
		simpleCUDModal(
			"#email_template_dialog",
			"#edit_email_template_form",
			guid(),
			"#btnEditEmailTemplate",
			"<?=ActionUtil::getFullPathAlias("admin/email/template/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/email/template/edit?rtype=json")?>",
			refreshEmailTemplates
		);
	}
	function copyEmailTemplateDialog(id){
		simpleCUDModal(
				"#email_template_dialog",
				"#copy_email_template_form",
				guid(),
				"#btnCopyEmailTemplate",
				"<?=ActionUtil::getFullPathAlias("admin/email/template/copy/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/email/template/copy?rtype=json")?>",
				refreshEmailTemplates
			);
		}
	function deleteEmailTemplateDialog(id){
		simpleCUDModal(
				"#delete_email_template_dialog",
				"#del_email_template_form",
				guid(),
				"#btnDelEmailTemplate",
				"<?=ActionUtil::getFullPathAlias("admin/email/template/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/email/template/del?rtype=json")?>",
				refreshEmailTemplates
			);
	}
	function showEmailTemplates(field,direction){
		$("#email_template_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","title","sendTo",""],
			callback : sortEmailTemplates
		});
	}
	function sortEmailTemplates(field, direction, is_reset = false){
		App.blockUI({
            target: '#email_template_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#email_template_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/email/template/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#email_template_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#email_template_search_result").html(res.content);
				// Update view for sorting.
				showEmailTemplates(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#email_template_table');
			alert("System error.");
		});
	}
	function searchEmailTemplates(is_reset = false){
		$("#email_template_search_form #page").val(1);
		sortEmailTemplates("id","asc", is_reset);
	}

	function changePageEmailTemplates(page){
		var field = $("#email_template_table").attr("field");
		var direction = $("#email_template_table").attr("direction");
		$("#email_template_search_form #page").val(page);
		sortEmailTemplates(field,direction);
	}
	function refreshEmailTemplates(dialogId,btnId,res){
		var field = $("#email_template_table").attr("field");
		var direction = $("#email_template_table").attr("direction");
		sortEmailTemplates(field,direction);
		$(dialogId).modal("toggle");
	}
</script>