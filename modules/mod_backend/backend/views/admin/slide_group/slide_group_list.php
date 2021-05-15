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
						<span class="caption-subject bold uppercase"><?=Lang::get('Slide Groups')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="sortSlideGroup()" class="form-control input-sm input-xsmall input-inline">
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
										$button->title = " " . Lang::get ( 'Add New' );
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addSlideGroupDialog()\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "slide_group_list_data.php"?>
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
$form->id = "slide_group_view_form";
$form->attributes = 'class="form-horizontal"';
$form->action = ActionUtil::getFullPathAlias ( "admin/slide/list" );
$form->renderStart ();

$text = new Text ();
$text->type = "hidden";
$text->id = "slideGroupMo_id";
$text->name = "slideMo[slideGroupId]";
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
			callback : sortSlideGroup
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/add") ?>" + "?rtype=json";
	gUrlCoppy 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/copy/view") ?>" + "?rtype=json";
	pUrlCoppy			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/copy") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/slide/group/search") ?>" + "?rtype=json";

	function addSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshSlideGroup(dialogId,actionBtnId,res);
	}

	function editActionError(dialogId, actionBtnId, res){
	    	$(formId).replaceWith(res.content);
	}

	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshSlideGroup(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshSlideGroup(dialogId,actionBtnId,res);
	}

	function addSlideGroupDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#slideGroupAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	function viewSlideGroups(id){
		$("#slideGroupMo_id").val(id);
		$("#slide_group_view_form").submit();
	}
	function deleteSlideGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&slideGroupMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}

	function copySlideGroupDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#slideGroupAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlCoppy +"&slideGroupMo[id]="+id, 
			    pUrlCoppy, 
			    addSuccess
		    );
	}
	
	function editSlideGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#slideGroupEditFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&slideGroupMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function resetForm(){
	    sortSlideGroup(defaultField,defaultDirection,true);
	}
	
	function sortSlideGroup(field = defaultField, direction = defaultDirection, isReset = false){
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

	function changePageSlideGroup(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortSlideGroup(field, direction);
	}
	function refreshSlideGroup(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortSlideGroup(field, direction);
		$(dialogId).modal("toggle");
	}

	function changeSlideStatus(id, val, name){
		var data = {
				"slideGroupMo[id]":id,
				"slideGroupMo[status]":val,
				"slideGroupMo[name]":name
			};
	    simpleAjaxPost(
		    guid(), 
		    pUrlEdit, 
		    data
		    );
	}
</script>