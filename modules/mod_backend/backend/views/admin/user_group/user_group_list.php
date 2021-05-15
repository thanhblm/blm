<?php
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\ModalTemplate;
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
						<span class="caption-subject bold uppercase"><?=Lang::get('Administrator Groups')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
														<select name="pageSize" onchange="sortUserGroup()" class="form-control input-sm input-xsmall input-inline">
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
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addUserGroupDialog()\"";
										$button->checkActionPath = "admin/user/group/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "user_group_list_data.php"?>
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
?>
<script type="text/javascript">
	var defaultField 		= "name";
	var defaultDirection 	= "asc";
	$(document).ready(function() {
	    showTableView(defaultField,defaultDirection);
	});
	function showTableView(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["name","status",""],
			callback : sortUserGroup
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/del") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/user/group/copy") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/user/group/search") ?>" + "?rtype=json";

	function addSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshUserGroup(dialogId,btnId,res);
	}

	function editSuccess(dialogId,btnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshUserGroup(dialogId,btnId,res);
	}

	function copySuccess(dialogId,btnId,res){
		showMessage("<?=Lang::get("Copy success") ?>");
		refreshUserGroup(dialogId,btnId,res);
	}

	function delSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshUserGroup(dialogId,btnId,res);
	}
	
	function addUserGroupDialog(){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	
	function deleteUserGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&userGroupMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editUserGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&userGroupMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess
		    );
	}

	function copyUserGroupDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy+"&userGroupMo[id]="+id, 
			    pUrlCopy, 
			    copySuccess
		    );
	}

	function resetForm(){
	    sortUserGroup(defaultField,defaultDirection,true);
	}
	
	function sortUserGroup(field = defaultField, direction = defaultDirection, isReset = false){
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

	function changePageUserGroup(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortUserGroup(field, direction);
	}
	function refreshUserGroup(dialogId,btnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortUserGroup(field, direction);
		$(dialogId).modal("toggle");
	}
</script>