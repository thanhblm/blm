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
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get('Tax & Shipping Zones')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="sortTaxShippingZones()" class="form-control input-sm input-xsmall input-inline">
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
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addTaxShippingZoneDialog()\"";
										$button->checkActionPath = "admin/tax/shipping/zone/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "tax_shipping_zone_list_data.php"?>
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
$modalTemplate->id = "modalAddRateDialog";
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
			fieldList : ["id","name", "exclusive", ""],
			callback : sortTaxShippingZones
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/del") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/copy") ?>" + "?rtype=json";
	searchUrl 			= "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/search") ?>" + "?rtype=json";
	function addSuccess(dialogId, actionBtnId, res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    refreshTaxShippingZone(dialogId,actionBtnId,res);
	}

	function editActionError(dialogId, actionBtnId, res){
	    showMessage(res.errorMessage);
	  	$("#taxShippingZoneEditFormId").replaceWith(res.content);
	}

	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshTaxShippingZone(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshTaxShippingZone(dialogId,actionBtnId,res);
	}

	function addTaxShippingZoneDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#taxShippingZoneAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	
	function deleteTaxShippingZoneDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&id="+id, 
			    pUrlDel+"&id="+id, 
			    delSuccess
		    );
	}
	
	function editTaxShippingZoneDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#taxShippingZoneEditFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&id="+id, 
			    pUrlEdit, 
			    editSuccess
		    );
	}

	function copyTaxShippingZoneDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    "#taxShippingZoneCopyFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy +"&id="+id, 
			    pUrlCopy, 
			    addSuccess
		    );
	}

	
	
	function resetForm(){
	    sortTaxShippingZones(defaultField,defaultDirection,true);
	}
	
	function sortTaxShippingZones(field = defaultField, direction = defaultDirection, isReset = false){
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

	function changePageTaxShippingZone(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    sortTaxShippingZones(field, direction);
	}
	function refreshTaxShippingZone(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortTaxShippingZones(field, direction);
		$(dialogId).modal("toggle");
	}
	function searchTaxShippingZones(is_reset = false){
		$("#tax_shipping_zone_search_form #page").val(1);
		sortTaxShippingZones("id","asc", is_reset);
	}
</script>