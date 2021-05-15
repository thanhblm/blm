<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
$manufactureGroupMo = RequestUtil::get ( "manufactureGroupMo" );
$listManufactureGroup = RequestUtil::get ( "listManufactureGroup" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-manufactures"></i> <span class="caption-subject bold uppercase"><?=Lang::get("Manufacture Reports")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
							<?php
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "manufactureGroupMo[id]";
							$text->value = $manufactureGroupMo->id;
							$text->render ();
							
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "manufactureMo[manufactureGroupId]";
							$text->value = $manufactureGroupMo->id;
							$text->render ();
							?>
							<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="searchManufacture()" class="form-control input-sm input-xsmall input-inline">
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
											$button->checkActionPath = "admin/manufacture/add/view";
											$button->title = " " . Lang::get ( 'Add New' );
											$button->class = "btn btn-sm blue margin-bottom-5";
											$button->icon = "<i class=\"fa fa-plus\"></i>";
											$button->attributes = "onclick=\"javascript:addManufactureDialog()\"";
											$button->render ();
											?>
										</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "manufacture_list_data.php" ?>
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
$modalTemplate->id = "modalDialogErrorManufacture";
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
			fieldList : ["id","","title","", ""],
			callback : searchManufacture
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/manufacture/search") ?>" + "?rtype=json";
	pUrlConfirmUpload 	= "<?=ActionUtil::getFullPathAlias("admin/manufacture/confirm") ?>" + "?rtype=json";
	function addSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    doRefresh(dialogId,actionBtnId,res);
	}

	function addManufactureActionError(dialogId,actionBtnId,res){
	    $("#modalDialogErrorManufacture").html(res.content).promise().done(function() {
			$("#modalDialogErrorManufacture").modal();
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
	
	function addManufactureDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#manufactureAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd+"&manufactureMo[manufactureGroupId]=<?=$manufactureGroupMo->id?>", 
			    pUrlAdd, 
			    addSuccess,
			    null,
			    addManufactureActionError
		    );
	}
	
	function deleteManufactureDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&manufactureMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editManufactureDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&manufactureMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function resetFormManufacture(){
	    searchManufacture(defaultField,defaultDirection,true);
	}
	
	function searchManufacture(field = defaultField, direction = defaultDirection, isReset = false){
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
	    searchManufacture(field, direction);
	}
	function doRefresh(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		searchManufacture(field, direction);
		$(dialogId).modal("toggle");
	}


	function changeManufactureStatus(id, val){
		var data = {
				"manufactureMo[id]":id,
				"manufactureMo[status]":val
			};
	    simpleAjaxPost(
		    guid(), 
		    pUrlEdit, 
		    data
		    );
	}
</script>