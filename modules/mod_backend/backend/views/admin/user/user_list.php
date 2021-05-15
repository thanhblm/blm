<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
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
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-users"></i> <span class="caption-subject bold uppercase"><?=Lang::get('Administrators')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
														<select name="pageSize" onchange="searchUser()" class="form-control input-sm input-xsmall input-inline">
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
										$button->checkActionPath = "admin/user/add/view";
										$button->attributes = "onclick=\"javascript:addUserDialog()\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "user_list_data.php"?>
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
	var defaultField 		= "user_name";
	var defaultDirection 	= "asc";
	$(document).ready(function() {
	    showTableView(defaultField,defaultDirection);
	});
	function showTableView(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["user_name","email","full_name","phone","user_group_id","status",""],
			callback : searchUser
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/user/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/user/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/user/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/user/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/user/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/user/del") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/user/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/user/copy") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/user/search") ?>" + "?rtype=json";

	function addSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    doRefresh(dialogId,btnId,res);
	}

	function editSuccess(dialogId,btnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		doRefresh(dialogId,btnId,res);
	}

	function copySuccess(dialogId,btnId,res){
		showMessage("<?=Lang::get("Copy success") ?>");
		doRefresh(dialogId,btnId,res);
	}

	function delSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    doRefresh(dialogId,btnId,res);
	}
	
	function addUserDialog(){
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
	
	function deleteUserDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&userMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editUserDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&userMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess
		    );
	}

	function copyUserDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy+"&userMo[id]="+id, 
			    pUrlCopy, 
			    copySuccess
		    );
	}

	function resetFormUser(){
	    searchUser(defaultField,defaultDirection,true);
	}
	
	function searchUser(field = defaultField, direction = defaultDirection, isReset = false){
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
	    searchUser(field, direction);
	}
	
	function doRefresh(dialogId,btnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		searchUser(field, direction);
		$(dialogId).modal("toggle");
	}
</script>