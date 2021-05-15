<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
$pageSizes = RequestUtil::get ( "pageSizes" );

if (RequestUtil::hasActionErrors ()) {
	?>
<div class="alert alert-danger" role="alert"><?=RequestUtil::getErrorMessage() ?></div>
<?php
}
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner" id="pageContainer">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get('Users')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="sortCustomer()" class="form-control input-sm input-xsmall input-inline">
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
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->attributes = "onclick=\" addCustomerDialog()\"";
										$button->checkActionPath = "admin/customer/add";
										$button->render ();
										
										$button = new Button ();
										$button->type = "button";
										$button->title = " " . Lang::get ( 'Export' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-download\"></i>";
										$button->attributes = "onclick=\" exportCustomerCsv()\"";
										$button->checkActionPath = "admin/customer/export";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "customer_list_data.php"?>
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
$modalTemplate->size = 800;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "deleteDialog";
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalAddAddressDialog";
$modalTemplate->size = 800;
$modalTemplate->render ();
?>
<script type="text/javascript" src="<?=AppUtil::resource_url("global/plugins/jquery.fileDownload.js")?>"></script>
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
			fieldList : ["id","first_name","last_name", "company_name","registration_no","email", "price_level_id", "account_type_id", ""],
			callback : sortCustomer
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/customer/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/customer/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/customer/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/customer/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/customer/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/customer/del") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/customer/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/customer/copy") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/customer/search") ?>" + "?rtype=json";
	gUrlExport 			= "<?=ActionUtil::getFullPathAlias("admin/customer/export") ?>" ;
	gUrlAddressList		= "<?=ActionUtil::getFullPathAlias("admin/customer/address/view") ?>" + "?rtype=json";
	pUrlAddressSave		= "<?=ActionUtil::getFullPathAlias("admin/customer/address/save") ?>" + "?rtype=json";

	function addSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshCustomer(dialogId,actionBtnId,res);
	}

	function editActionError(dialogId, actionBtnId, res){
	    $(dialogId).modal("toggle");
	    showMessage(res.errorMessage, 'error');
	  	/* $("#customerEditFormId").replaceWith(res.content); */
	}

	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshCustomer(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshCustomer(dialogId,actionBtnId,res);
	}

	function addCustomerDialog(){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#customerAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	
	function deleteCustomerDialog(id){
	    simpleCUDModal(
		    	"#deleteDialog", 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&customer[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}

	function exportSuccess(res){
	    showMessage("<?=Lang::get("Export success") ?>");
	}

	function exportError(res){
	    showMessage(res, "error");
	}
	
	function exportCustomerCsv(){
		App.blockUI();
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		data = $("#page_form").serialize();
		data += "&orderBy=" + field + " " + direction;

		$.fileDownload(gUrlExport,{
		    successCallback: function (url) {
		        App.unblockUI();
            },
		    failCallback: function (res, url) {
		        App.unblockUI();
                exportError(res);
            },
            httpMethod: "POST",
            data:data,
        });
	}
	
	function editCustomerDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#customerEditFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&customer[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function viewAddressSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Load Address success") ?>");
	}
	function viewAddressAcctionError(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Load Address error") ?>");
	}
	function viewAddressDialog(id){
		simpleCUDModal(
		    	modalDiaglogId, 
			    "#addressFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAddressList+"&address[groupId]="+id, 
			    pUrlAddressSave, 
			    viewAddressSuccess,
			    null,
			    viewAddressAcctionError
		    );
	    
	}
	function copyCustomerDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#customerCopyFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy +"&customer[id]="+id, 
			    pUrlCopy, 
			    addSuccess
		    );
	}

	function resetForm(){
	    sortCustomer(defaultField,defaultDirection,true);
	}
	
	function sortCustomer(field = defaultField, direction = defaultDirection, isReset = false){
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

	function changePageCustomer(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortCustomer(field, direction);
	}
	function refreshCustomer(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortCustomer(field, direction);
		$(dialogId).modal("toggle");
	}
</script>