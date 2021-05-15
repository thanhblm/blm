<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Text;
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
						<span class="caption-subject bold uppercase"><?=Lang::get('Batch Groups')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="sortBatchGroup()" class="form-control input-sm input-xsmall input-inline">
											<?php
											foreach ( $pageSizes as $pageSize ) {
												?>
												<option value="<?=$pageSize?>" <?=(RequestUtil::get("pageSize")==$pageSize)?"selected":""?>><?=$pageSize?></option>
												<?php
											}
											?>
											</select> 
											<?=Lang::get('entries')?>
										</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										/* $button = new Button ();
										$button->type = "button";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addBatchGroupDialog()\"";
										$button->render (); */
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "batch_group_list_data.php"?>
							</div>
						</div>
					</form>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<?php
$form = new FormContainer ();
$form->id = "batch_group_view_form";
$form->attributes = 'class="form-horizontal"';
$form->action = ActionUtil::getFullPathAlias ( "admin/batch/list" );
$form->renderStart ();

$text = new Text ();
$text->type = "hidden";
$text->id = "batchGroupMo_id";
$text->name = "batchMo[batchGroupId]";
$text->render ();

$form->renderEnd ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	var defaultField 		= "id";
	var defaultDirection 	= "asc";
	$(document).ready(function() {
	    showTableView(defaultField,defaultDirection);
	});
	function showTableView(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : sortBatchGroup
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/add") ?>" + "?rtype=json";
	gUrlCoppy 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/copy/view") ?>" + "?rtype=json";
	pUrlCoppy			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/copy") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/batch/group/search") ?>" + "?rtype=json";

	function addSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshBatchGroup(dialogId,actionBtnId,res);
	}

	function editActionError(dialogId, actionBtnId, res){
	    	$(formId).replaceWith(res.content);
	}

	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshBatchGroup(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshBatchGroup(dialogId,actionBtnId,res);
	}

	function addBatchGroupDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#batchGroupAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	function viewBatchGroups(id){
		$("#batchGroupMo_id").val(id);
		$("#batch_group_view_form").submit();
	}
	function deleteBatchGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&batchGroupMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}

	function copyBatchGroupDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#batchGroupAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlCoppy +"&batchGroupMo[id]="+id, 
			    pUrlCoppy, 
			    addSuccess
		    );
	}
	
	function editBatchGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#batchGroupEditFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&batchGroupMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function resetForm(){
	    sortBatchGroup(defaultField,defaultDirection,true);
	}
	
	function sortBatchGroup(field = defaultField, direction = defaultDirection, isReset = false){
	    App.blockUI({ target: '#page_table' });
	    var data = "";
	    if (!isReset){
			data = $("#page_form").serialize();
			data += "&orderBy=" + field + " " + direction;
		 }
		$.post(searchUrl, data, function(res) {
		    App.unblockUI('#page_table');
			if (res.errorCode == "SUCCESS") {
				$("#page_result").html(res.content);
				showTableView(field,direction);
			} else {
			    alert(res.errorMessage);
			}
		}).fail(function() {
		    App.unblockUI('#page_table');
			alert("System error.");
		});
	}

	function changePageBatchGroup(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortBatchGroup(field, direction);
	}
	function refreshBatchGroup(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortBatchGroup(field, direction);
		$(dialogId).modal("toggle");
	}

	function changeBatchStatus(id, val, name){
		var data = {
				"batchGroupMo[id]":id,
				"batchGroupMo[status]":val,
				"batchGroupMo[name]":name
			};
	    simpleAjaxPost(
		    guid(), 
		    pUrlEdit, 
		    data
		    );
	}
</script>