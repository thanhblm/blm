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
						<span class="caption-subject bold uppercase"><?=Lang::get("Block Emails")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="block_email_search_form">
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
									$select->attributes = "onchange=\"refreshBlockEmail()\"";
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
										$button->id = "btnAddBlockEmailDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->checkActionPath = "admin/block/email/add/view";
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="block_email_search_result">
								<?php include "block_email_list_data.php"?>
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
$modalTemplate->id = "block_email_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showBlockEmail("id","asc");
		$("#btnAddBlockEmailDialog").click(function(){
			simpleCUDModal(
					"#block_email_dialog",
					"#add_block_email_form",
					guid(),
					"#btnAddBlockEmail",
					"<?=ActionUtil::getFullPathAlias("admin/block/email/add/view?rtype=json")?>",
					"<?=ActionUtil::getFullPathAlias("admin/block/email/add?rtype=json")?>",
					refreshBlockEmail
				);
		});
	});
	function searchBlockEmails(is_reset = false){
		$("#block_email_search_form #page").val(1);
		sortBlockEmail("id","asc", is_reset);
	}
	function editBlockEmailDialog(id){
		simpleCUDModal(
			"#block_email_dialog",
			"#edit_block_email_form",
			guid(),
			"#btnEditBlockEmail",
			"<?=ActionUtil::getFullPathAlias("admin/block/email/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/block/email/edit?rtype=json")?>",
					refreshBlockEmail
		);
	}
	function copyBlockEmailDialog(id){
		simpleCUDModal(
			"#block_email_dialog",
			"#copy_block_email_form",
			guid(),
			"#btnCopyBlockEmail",
			"<?=ActionUtil::getFullPathAlias("admin/block/email/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/block/email/copy?rtype=json")?>",
					refreshBlockEmail
		);
	}
	function deleteBlockEmailDialog(id){
		simpleCUDModal(
				"#block_email_dialog",
				"#del_block_email_form",
				guid(),
				"#btnDelBlockEmail",
				"<?=ActionUtil::getFullPathAlias("admin/block/email/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/block/email/del?rtype=json")?>",
						refreshBlockEmail
			);
	}
	function refreshBlockEmail(dialogId,btnId,res){
		var field = $("#block_email_table").attr("field");
		var direction = $("#block_email_table").attr("direction");
		sortBlockEmail(field,direction);
		$(dialogId).modal("toggle");
	}
	function sortBlockEmail(field, direction, is_reset = false){
		App.blockUI({
            target: '#block_email_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#block_email_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/block/email/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#block_email_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#block_email_search_result").html(res.content);
				// Update view for sorting.
				showBlockEmail(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#block_email_table');
			alert("System error.");
		});
	}
	function showBlockEmail(field,direction){
		$("#block_email_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : sortBlockEmail
		});
	}
	function changePageBlockEmail(page){
		var field = $("#block_email_table").attr("field");
		var direction = $("#block_email_table").attr("direction");
		$("#block_email_search_form #page").val(page);
		sortBlockEmail(field,direction);
	}
</script>