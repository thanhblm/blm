<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\AppUtil;
$pageSizes = RequestUtil::get ( "pageSizes" );

if (RequestUtil::hasActionErrors ()) {
	?>
<div class="alert alert-danger" role="alert"><?=RequestUtil::getErrorMessage() ?></div>
<?php
}
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get('Tax Rates')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="sortTaxRate()" class="form-control input-sm input-xsmall input-inline">
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
										$button->attributes = "onclick=\" addTaxRateDialog()\"";
										$button->render (); */
										
										/* $button = new Button ();
										$button->type = "button";
										$button->title = " " . Lang::get ( 'Export' );
										$button->icon = "<i class=\"fa fa-download\"></i>";
										$button->attributes = "onclick=\" exportTaxRateCsv()\"";
										$button->render (); */
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "tax_rate_list_data.php"?>
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
$modalTemplate->attributes = "style='margin-top: 0px'";
$modalTemplate->render ();

$modalTemplate = new ModalTemplate();
$modalTemplate->id = "modalAddRateDialog";
$modalTemplate->render (); 
?>
<script type="text/javascript" src="<?=AppUtil::resource_url("global/plugins/jquery.fileDownload.js")?>"></script>
<script type="text/javascript">
	var defaultField 		= "id";
	var defaultDirection 	= "asc";
	$(document).ready(function() {
	    showTableView(defaultField,defaultDirection);
        $.fn.modalmanager.defaults.modalOverflow = true;
	});
	function showTableView(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name", ""],//"cr_date", "md_date", "count_tax_info", 
			callback : sortTaxRate
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/del") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/copy") ?>" + "?rtype=json";
	searchUrl 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/search") ?>" + "?rtype=json";
	gUrlExport 			= "<?=ActionUtil::getFullPathAlias("admin/tax/rate/export") ?>" ;
	function addSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshTaxRate(dialogId,actionBtnId,res);
	}

	function editActionError(dialogId, actionBtnId, res){
	    showMessage(res.errorMessage);
	  	$("#taxRateEditFormId").replaceWith(res.content);
	}

	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshTaxRate(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshTaxRate(dialogId,actionBtnId,res);
	}

	function addTaxRateDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#taxRateAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	
	function deleteTaxRateDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&taxRate[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editTaxRateDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#taxRateEditFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&taxRate[id]="+id, 
			    pUrlEdit, 
			    editSuccess
		    );
	}

	function copyTaxRateDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#taxRateCopyFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy +"&taxRate[id]="+id, 
			    pUrlCopy, 
			    addSuccess
		    );
	}

	function exportError(res){
	    showMessage(res, "error");
	}
	
	function exportTaxRateCsv(){
	    App.blockUI();
		$.fileDownload(gUrlExport,{
		    successCallback: function (url) {
		        App.unblockUI();
            },
		    failCallback: function (res, url) {
		        App.unblockUI();
                exportError(res);
            }
        });
	}
	
	function resetForm(){
	    sortTaxRate(defaultField,defaultDirection,true);
	}
	
	function sortTaxRate(field = defaultField, direction = defaultDirection, isReset = false){
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

	function changePageTaxRate(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortTaxRate(field, direction);
	}
	function refreshTaxRate(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortTaxRate(field, direction);
		$(dialogId).modal("toggle");
	}
</script>