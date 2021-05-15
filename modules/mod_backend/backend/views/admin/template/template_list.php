<?php
use common\template\extend\LabelContainer;
use common\template\extend\Link;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="template-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Template")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="template_search_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelTemplate = new LabelContainer ();
									$labelTemplate->textBefore = Lang::get ( 'Show' );
									$labelTemplate->textAfter = Lang::get ( 'entries' );
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get ( "pageSize" );
									$select->attributes = "onchange=\"refreshTemplates()\"";
									$select->collections = $collections;
									$labelTemplate->addElement ( $select );
									$labelTemplate->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$link = new Link ();
										$link->class = "btn btn-sm btn-success margin-bottom-5";
										$link->title = "<i class=\"fa fa-plus\"></i> " . Lang::get ( 'Add New' );
										$link->link = ActionUtil::getFullPathAlias ( 'admin/template/add/view' );
										$link->render ();
										?>
									</div>
								</div>
							</div>
							<div id="template_search_result">
								<?php include "template_list_data.php"?>
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
$modalTemplate->id = "template_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();
?>

<script type="text/javascript">
	$(document).ready(function(){
		showTemplates("id","asc");
	});
	function showTemplates(field,direction){
		$("#template_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name", ""],
			callback : sortTemplates
		});
	};
	function sortTemplates(field, direction, is_reset = false){
		App.blockUI({
            target: '#template_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#template_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/template/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#template_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#template_search_result").html(res.content);
				// Update view for sorting.
				showTemplates(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#template_table');
			alert("System error.");
		});
	};
	function searchTemplates(is_reset = false){
		$("#template_search_form #page").val(1);
		sortTemplates("id","asc", is_reset);
	}

	function changeTemplatePages(page){
		var field = $("#template_table").attr("field");
		var direction = $("#template_table").attr("direction");
		$("#template_search_form #page").val(page);
		sortTemplates(field,direction);
	}
	function refreshTemplates(dialogId,btnId,res){
		var field = $("#template_table").attr("field");
		var direction = $("#template_table").attr("direction");
		sortTemplates(field,direction);
		$(dialogId).modal("toggle");
	}
</script>

<script type="text/javascript">
	function deleteTemplateDialog(templateId){
		simpleCUDModal(
			"#template_dialog",
			"#del_template_form",
			guid(),
			"#btnDel",
			"<?=ActionUtil::getFullPathAlias("admin/template/del/view?rtype=json&templateId=")?>" + templateId,
			"<?=ActionUtil::getFullPathAlias("admin/template/del?rtype=json")?>",
			function(dialogId,btnId,res){
				refreshTemplates(dialogId,btnId,res);
				var message = '<?=Lang::get('Delete template is success')?>';
				showMessage(message, 'success');
			},
            function (dialogId,btnId,res){	//field error callback
                showMessage(res.errorMessage, "error", true);
            }
		);
	}
</script>