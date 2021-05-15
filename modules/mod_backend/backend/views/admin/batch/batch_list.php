<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
$batchGroupMo = RequestUtil::get ( "batchGroupMo" );
$listBatchGroup = RequestUtil::get ( "listBatchGroup" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-batchs"></i> <span class="caption-subject bold uppercase"><?=Lang::get("Batch Reports")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
							<?php
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "batchGroupMo[id]";
							$text->value = $batchGroupMo->id;
							$text->render ();
							
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "batchMo[batchGroupId]";
							$text->value = $batchGroupMo->id;
							$text->render ();
							?>
							<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="searchBatch()" class="form-control input-sm input-xsmall input-inline">
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
											$button = new Button ();
											$button->type = "button";
											$button->checkActionPath = "admin/batch/add/view";
											$button->title = " " . Lang::get ( 'Add New' );
											$button->class = "btn btn-sm blue margin-bottom-5";
											$button->icon = "<i class=\"fa fa-plus\"></i>";
											$button->attributes = "onclick=\"javascript:addBatchDialog()\"";
											$button->render ();
											?>
										</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "batch_list_data.php"?>
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
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialog";
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialogErrorBatch";
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
			fieldList : ["id","title","status","fileName",""],
			callback : searchBatch
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/batch/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/batch/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/batch/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/batch/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/batch/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/batch/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/batch/search") ?>" + "?rtype=json";
	pUrlConfirmUpload 	= "<?=ActionUtil::getFullPathAlias("admin/batch/confirm") ?>" + "?rtype=json";
	function addSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    doRefresh(dialogId,actionBtnId,res);
	}

	function addBatchActionError(dialogId,actionBtnId,res){
	    $("#modalDialogErrorBatch").html(res.content).promise().done(function() {
			$("#modalDialogErrorBatch").modal();
	    });
	}

	function editActionError(dialogId, actionBtnId, res){
	    	$(formId).replaceWith(res.content);
	}
	
	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		doRefresh(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    doRefresh(dialogId,actionBtnId,res);
	}
	
	function addBatchDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#batchAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd+"&batchMo[batchGroupId]=<?=$batchGroupMo->id?>", 
			    pUrlAdd, 
			    addSuccess,
			    null,
			    addBatchActionError
		    );
	}
	
	function deleteBatchDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&batchMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editBatchDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&batchMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function resetFormBatch(){
	    searchBatch(defaultField,defaultDirection,true);
	}
	
	function searchBatch(field = defaultField, direction = defaultDirection, isReset = false){
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
			    showMessage(res.errorMessage, "ERROR");
			}
		}).fail(function() {
			alert("System error.");
			App.blockUI({ target: '#page_table' });
		});
	}
	
	function onPageChange(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    searchBatch(field, direction);
	}
	function doRefresh(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		searchBatch(field, direction);
		$(dialogId).modal("toggle");
	}

	function confirmSuccess(res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    $("#modalDialogErrorBatch").modal("toggle");
	    doRefresh("#modalDialog","#btnSubmit",res);
	}
	function confirmUpload(){
	    simpleAjaxPostUpload(
		    guid(), 
		    pUrlConfirmUpload, 
		    "#batchAddFormId", 
		    confirmSuccess
		    );
	}

	function changeBatchStatus(id, val){
		var data = {
				"batchMo[id]":id,
				"batchMo[status]":val
			};
	    simpleAjaxPost(
		    guid(), 
		    pUrlEdit, 
		    data
		    );
	}
</script>